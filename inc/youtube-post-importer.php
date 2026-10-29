<?php
/**
 * Import released public YouTube playlist videos as draft posts.
 *
 * @package So_What_Podcast
 */

define( 'SO_WHAT_YOUTUBE_PLAYLIST_ID', 'PLwcja8Y_R4ydyUCCk2NROLh8eFBuipORg' );
define( 'SO_WHAT_YOUTUBE_IMPORT_AUTHOR', 'admin_e4uidhu7' );

add_filter( 'cron_schedules', 'so_what_youtube_cron_schedules' );
add_action( 'init', 'so_what_youtube_schedule_import' );
add_action( 'sw_what_youtube_import', 'so_what_youtube_import_episodes' );
add_action( 'switch_theme', 'so_what_youtube_unschedule_import' );
add_action( 'admin_menu', 'so_what_youtube_add_import_page' );
add_action( 'admin_post_so_what_youtube_import', 'so_what_youtube_handle_manual_import' );

function so_what_youtube_cron_schedules( $schedules ) {
	$schedules['so_what_youtube_five_minutes'] = array(
		'interval' => 5 * MINUTE_IN_SECONDS,
		'display'  => __( 'Every five minutes (YouTube importer)', 'so_what_podcast' ),
	);

	return $schedules;
}

function so_what_youtube_schedule_import() {
	$event = wp_get_scheduled_event( 'sw_what_youtube_import' );

	if ( $event && 'so_what_youtube_five_minutes' !== $event->schedule ) {
		$result = wp_clear_scheduled_hook( 'sw_what_youtube_import', array(), true );
		if ( is_wp_error( $result ) ) {
			error_log( 'YouTube importer schedule migration failed: ' . $result->get_error_message() );
			return;
		}
		$event = false;
	}

	if ( ! $event ) {
		$result = wp_schedule_event( time() + 5 * MINUTE_IN_SECONDS, 'so_what_youtube_five_minutes', 'sw_what_youtube_import', array(), true );
		if ( is_wp_error( $result ) ) {
			error_log( 'YouTube importer scheduling failed: ' . $result->get_error_message() );
		}
	}
}

function so_what_youtube_unschedule_import() {
	$timestamp = wp_next_scheduled( 'sw_what_youtube_import' );
	if ( $timestamp ) {
		wp_unschedule_event( $timestamp, 'sw_what_youtube_import' );
	}
}

function so_what_youtube_fetch_playlist_items() {
	$api_key = sw_config( 'GOOGLE_API_KEY' );
	if ( ! $api_key ) {
		return new WP_Error( 'youtube_missing_api_key', 'The YouTube API key is not configured.' );
	}

	$items     = array();
	$page_token = '';

	do {
		$args = array(
			'part'       => 'snippet,contentDetails',
			'playlistId' => SO_WHAT_YOUTUBE_PLAYLIST_ID,
			'maxResults' => 50,
			'key'        => $api_key,
		);
		if ( $page_token ) {
			$args['pageToken'] = $page_token;
		}

		$response = wp_remote_get(
			add_query_arg( $args, 'https://www.googleapis.com/youtube/v3/playlistItems' ),
			array(
				'timeout' => 20,
				'headers' => array( 'Referer' => home_url() ),
			)
		);
		if ( is_wp_error( $response ) ) {
			return new WP_Error( 'youtube_playlist_request_failed', $response->get_error_message() );
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( 200 !== wp_remote_retrieve_response_code( $response ) || ! is_array( $data ) ) {
			$message = isset( $data['error']['message'] ) ? $data['error']['message'] : 'The playlist API returned an invalid response.';
			return new WP_Error( 'youtube_playlist_api_error', $message );
		}

		foreach ( $data['items'] ?? array() as $item ) {
			$video_id = $item['contentDetails']['videoId'] ?? '';
			if ( preg_match( '/^[A-Za-z0-9_-]{11}$/', $video_id ) ) {
				$items[] = $video_id;
			}
		}

		$page_token = $data['nextPageToken'] ?? '';
	} while ( $page_token );

	return array_values( array_unique( $items ) );
}

function so_what_youtube_fetch_video_details( $video_ids ) {
	$api_key = sw_config( 'GOOGLE_API_KEY' );
	$videos  = array();

	foreach ( array_chunk( $video_ids, 50 ) as $id_batch ) {
		$response = wp_remote_get(
			add_query_arg(
				array(
					'part' => 'snippet,status',
					'id'   => implode( ',', $id_batch ),
					'key'  => $api_key,
				),
				'https://www.googleapis.com/youtube/v3/videos'
			),
			array(
				'timeout' => 20,
				'headers' => array( 'Referer' => home_url() ),
			)
		);
		if ( is_wp_error( $response ) ) {
			return new WP_Error( 'youtube_videos_request_failed', $response->get_error_message() );
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( 200 !== wp_remote_retrieve_response_code( $response ) || ! is_array( $data ) ) {
			$message = isset( $data['error']['message'] ) ? $data['error']['message'] : 'The video details API returned an invalid response.';
			return new WP_Error( 'youtube_videos_api_error', $message );
		}

		foreach ( $data['items'] ?? array() as $video ) {
			$videos[ $video['id'] ] = $video;
		}
	}

	return $videos;
}

function so_what_youtube_find_imported_post( $video_id ) {
	$posts = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => get_post_stati( array(), 'names' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_so_what_youtube_video_id',
			'meta_value'     => $video_id,
			'no_found_rows'  => true,
		)
	);

	return $posts ? (int) $posts[0] : 0;
}

function so_what_youtube_download_thumbnail( $post_id, $thumbnail_url, $title ) {
	$host = wp_parse_url( $thumbnail_url, PHP_URL_HOST );
	if ( 'https' !== wp_parse_url( $thumbnail_url, PHP_URL_SCHEME ) || ! $host || ! preg_match( '/(^|\.)((ytimg\.com)|(googleusercontent\.com))$/i', $host ) ) {
		return new WP_Error( 'youtube_invalid_thumbnail_url', 'The YouTube thumbnail URL was not from an approved image host.' );
	}

	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$attachment_id = media_sideload_image( esc_url_raw( $thumbnail_url ), $post_id, $title, 'id' );
	if ( is_wp_error( $attachment_id ) ) {
		return $attachment_id;
	}

	set_post_thumbnail( $post_id, $attachment_id );
	delete_post_meta( $post_id, '_so_what_youtube_thumbnail_pending' );
	return $attachment_id;
}

function so_what_youtube_build_post_content( $video_id, $description ) {
	$video_url = 'https://www.youtube.com/watch?v=' . rawurlencode( $video_id );
	// The URL must sit on its own line for WordPress's oEmbed to turn it into a player.
	$markup    = '<figure class="wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper">' . "\n" . esc_url( $video_url ) . "\n" . '</div></figure>';
	$embed     = serialize_block(
		array(
			'blockName'    => 'core/embed',
			'attrs'        => array(
				'url'                 => $video_url,
				'type'                => 'video',
				'providerNameSlug'    => 'youtube',
				'responsive'          => true,
				'className'           => 'wp-embed-aspect-16-9 wp-has-aspect-ratio',
			),
			'innerBlocks'  => array(),
			'innerHTML'    => $markup,
			'innerContent' => array( $markup ),
		)
	);

	return $embed . "\n\n" . wpautop( make_clickable( esc_html( $description ) ) );
}

function so_what_youtube_import_episodes() {
	if ( get_transient( 'so_what_youtube_import_lock' ) ) {
		return new WP_Error( 'youtube_import_locked', 'A YouTube import is already running.' );
	}
	set_transient( 'so_what_youtube_import_lock', 1, 15 * MINUTE_IN_SECONDS );

	$summary = array(
		'started'            => current_time( 'mysql' ),
		'imported'           => 0,
		'duplicates'         => 0,
		'skipped_unreleased' => 0,
		'thumbnail_errors'   => 0,
		'errors'             => array(),
	);

	try {
		$video_ids = so_what_youtube_fetch_playlist_items();
		if ( is_wp_error( $video_ids ) ) {
			throw new RuntimeException( $video_ids->get_error_message() );
		}

		$videos = so_what_youtube_fetch_video_details( $video_ids );
		if ( is_wp_error( $videos ) ) {
			throw new RuntimeException( $videos->get_error_message() );
		}

		$author = get_user_by( 'login', SO_WHAT_YOUTUBE_IMPORT_AUTHOR );
		if ( ! $author ) {
			throw new RuntimeException( 'The configured YouTube import author does not exist.' );
		}

		foreach ( $video_ids as $video_id ) {
			$video = $videos[ $video_id ] ?? null;
			if ( ! $video || 'public' !== ( $video['status']['privacyStatus'] ?? '' ) ) {
				$summary['skipped_unreleased']++;
				continue;
			}

			$snippet      = $video['snippet'] ?? array();
			$published_at = $snippet['publishedAt'] ?? '';
			$published_ts = $published_at ? strtotime( $published_at ) : false;
			if ( ! $published_ts || $published_ts > time() ) {
				$summary['skipped_unreleased']++;
				continue;
			}

			$post_id = so_what_youtube_find_imported_post( $video_id );
			if ( $post_id ) {
				$summary['duplicates']++;
				if ( get_post_meta( $post_id, '_so_what_youtube_thumbnail_pending', true ) ) {
					$thumbnail_url = $snippet['thumbnails']['high']['url'] ?? $snippet['thumbnails']['default']['url'] ?? '';
					$image         = $thumbnail_url ? so_what_youtube_download_thumbnail( $post_id, $thumbnail_url, $snippet['title'] ?? '' ) : new WP_Error( 'youtube_thumbnail_missing', 'No thumbnail URL was provided.' );
					if ( is_wp_error( $image ) ) {
						$summary['thumbnail_errors']++;
						$summary['errors'][] = $video_id . ': thumbnail: ' . $image->get_error_message();
					}
				}
				continue;
			}

			$gmt_date = gmdate( 'Y-m-d H:i:s', $published_ts );
			$post_id  = wp_insert_post(
				array(
					'post_type'      => 'post',
					'post_status'    => 'draft',
					'post_title'     => sanitize_text_field( $snippet['title'] ?? '' ),
					'post_content'   => so_what_youtube_build_post_content( $video_id, $snippet['description'] ?? '' ),
					'post_author'    => $author->ID,
					'post_date'      => get_date_from_gmt( $gmt_date ),
					'post_date_gmt'  => $gmt_date,
					'comment_status' => 'closed',
				),
				true
			);
			if ( is_wp_error( $post_id ) ) {
				$summary['errors'][] = $video_id . ': post: ' . $post_id->get_error_message();
				continue;
			}

			update_post_meta( $post_id, '_so_what_youtube_video_id', $video_id );
			update_post_meta( $post_id, '_so_what_youtube_thumbnail_pending', 1 );
			$thumbnail_url = $snippet['thumbnails']['high']['url'] ?? $snippet['thumbnails']['default']['url'] ?? '';
			$image         = $thumbnail_url ? so_what_youtube_download_thumbnail( $post_id, $thumbnail_url, $snippet['title'] ?? '' ) : new WP_Error( 'youtube_thumbnail_missing', 'No thumbnail URL was provided.' );
			if ( is_wp_error( $image ) ) {
				$summary['thumbnail_errors']++;
				$summary['errors'][] = $video_id . ': thumbnail: ' . $image->get_error_message();
				error_log( 'YouTube post importer thumbnail error for ' . $video_id . ': ' . $image->get_error_message() );
			}
			$summary['imported']++;
		}
	} catch ( RuntimeException $error ) {
		$summary['errors'][] = $error->getMessage();
		error_log( 'YouTube post importer error: ' . $error->getMessage() );
	} finally {
		$summary['completed'] = current_time( 'mysql' );
		delete_transient( 'so_what_youtube_import_lock' );
		update_option( 'so_what_youtube_import_last_run', $summary, false );
	}

	return $summary;
}

function so_what_youtube_add_import_page() {
	add_management_page(
		'YouTube Draft Importer',
		'YouTube Draft Importer',
		'manage_options',
		'so-what-youtube-importer',
		'so_what_youtube_render_import_page'
	);
}

function so_what_youtube_render_import_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$summary = get_option( 'so_what_youtube_import_last_run', array() );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'YouTube Draft Importer', 'so_what_podcast' ); ?></h1>
		<p><?php esc_html_e( 'Checks the podcast playlist and creates a draft for each released public video not already imported.', 'so_what_podcast' ); ?></p>
		<p><?php esc_html_e( 'Automatic checks are scheduled every five minutes. WP-Cron depends on site traffic, so checks may be delayed when the site is quiet.', 'so_what_podcast' ); ?></p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="so_what_youtube_import">
			<?php wp_nonce_field( 'so_what_youtube_import' ); ?>
			<?php submit_button( __( 'Run YouTube Sync Now', 'so_what_podcast' ) ); ?>
		</form>
		<?php if ( $summary ) : ?>
			<h2><?php esc_html_e( 'Last run', 'so_what_podcast' ); ?></h2>
			<p><?php echo esc_html( sprintf( 'Completed: %s | Drafts created: %d | Already imported: %d | Unreleased/private or unavailable: %d | Thumbnail errors: %d', $summary['completed'] ?? '', $summary['imported'] ?? 0, $summary['duplicates'] ?? 0, $summary['skipped_unreleased'] ?? 0, $summary['thumbnail_errors'] ?? 0 ) ); ?></p>
			<?php if ( ! empty( $summary['errors'] ) ) : ?>
				<ul>
					<?php foreach ( $summary['errors'] as $error ) : ?>
						<li><?php echo esc_html( $error ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<?php
}

function so_what_youtube_handle_manual_import() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to run the YouTube import.', 'so_what_podcast' ) );
	}
	check_admin_referer( 'so_what_youtube_import' );
	so_what_youtube_import_episodes();

	wp_safe_redirect( admin_url( 'tools.php?page=so-what-youtube-importer' ) );
	exit;
}
