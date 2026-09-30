<?php
/**
 * So What Podcast functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package So_What_Podcast
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function so_what_podcast_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on So What Podcast, use a find and replace
		* to change 'so_what_podcast' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'so_what_podcast', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'so_what_podcast' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'so_what_podcast_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'so_what_podcast_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function so_what_podcast_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'so_what_podcast_content_width', 640 );
}
add_action( 'after_setup_theme', 'so_what_podcast_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function so_what_podcast_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'so_what_podcast' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'so_what_podcast' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'so_what_podcast_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function so_what_podcast_scripts() {
	wp_enqueue_style( 'so_what_podcast-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'so_what_podcast-style', 'rtl', 'replace' );

	wp_enqueue_script( 'so_what_podcast-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	wp_localize_script('so_what_podcast-navigation', 'soWhatAjax', [
	    'url'                   => admin_url('admin-ajax.php'),
	    'soWhat_thinking_nonce' => wp_create_nonce('soWhat_thinking_nonce'),
	    'soWhat_thinking_nonce_cs' => wp_create_nonce('soWhat_thinking_nonce_cs'),
	]);
}
add_action( 'wp_enqueue_scripts', 'so_what_podcast_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
    
function add_favorite() {
	global $wpdb;
    $wpdb->show_errors();
	$form_data = array(
		'font_name' => isset($_POST['font_name']) ? sanitize_text_field($_POST['font_name']) : NULL,
		'background_color' => isset($_POST['background_color']) ? sanitize_text_field($_POST['background_color']) : NULL,
	);
	$add_favorite = $wpdb->insert( "{$wpdb->prefix}favorites", $form_data );
	
	if ($add_favorite) {
	    echo "success";
	} else {
	    echo $wpdb->print_error();
	    echo $wpdb->last_error;
	    echo $wpdb->last_query;
	    echo $wpdb->last_result;
	}
	die();
}
add_action('wp_ajax_add_favorite', 'add_favorite');
add_action('wp_ajax_nopriv_add_favorite', 'add_favorite');

function read_favorites() {
	global $wpdb;
    $wpdb->show_errors();
    
	$favorites_query = "SELECT * FROM {$wpdb->prefix}favorites";
	
	$favorites = $wpdb->get_results($favorites_query);
	
	foreach($favorites as $favorite) {
		echo "<div class='row'>";
		echo "<span class='font-name'>font: " . $favorite->font_name . "</span>";
		echo "<span class='color-name'>color: " . $favorite->background_color . "</span>";
		echo "<a class='favorite-link' href='https://krisstokes.com/sowhatpodcast?color=" . $favorite->background_color . "&font=" . $favorite->font_name . "'>link</a>";
		echo "</div>";
	}
	
	die();
}
add_action('wp_ajax_read_favorites', 'read_favorites');
add_action('wp_ajax_nopriv_read_favorites', 'read_favorites');

function get_spotify_access_token() {
	$clientId = constant('SPOTIFY_CLIENTID');
	$clientSecret = constant('SPOTIFY_CLIENTSECRET');
	
	$authString = base64_encode($clientId . ':' . $clientSecret);
	
	$url = 'https://accounts.spotify.com/api/token';

	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'Authorization: Basic ' . $authString,
	    'Content-Type: application/x-www-form-urlencoded'
	));
	
	$result = curl_exec($ch);
	
	if (curl_errno($ch)) {
	    echo 'cURL Error: ' . curl_error($ch);
	    exit;
	}
	
	curl_close($ch);
	
	$tokenData = json_decode($result, true);
	
	return $tokenData;
}

function get_spotify_episode_description($episode_id, $tokenData) {
	if (isset($tokenData['access_token'])) {
	    $accessToken = $tokenData['access_token'];
	    // You now have the access token
	
	
	    // Check if the data is already stored in a transient
	    $transient_key = 'spotify_episode_' . $episode_id;
	    $description = get_transient($transient_key);
	
	    if (false === $description) {
	
	        $url = 'https://api.spotify.com/v1/episodes/' . $episode_id;
	        $response = wp_remote_get($url, [
	            'headers' => [
	                'Authorization' => 'Bearer ' . $accessToken,
	            ],
	        ]);
	
	        if (is_wp_error($response)) {
	            return 'Error: Could not retrieve episode data.';
	        }
	
	        $body = wp_remote_retrieve_body($response);
	        $data = json_decode($body, true);
	
	        if (isset($data['html_description'])) {
	            $description = $data['html_description'];
	            // Store the description in a transient for 12 hours
	            set_transient($transient_key, $description, 12 * HOUR_IN_SECONDS);
	        } else {
	            return 'Description not found.';
	        }
	    }
	} else {
	    // Handle the error
	    echo 'Failed to retrieve access token. Response: ' . $result;
	}

    return $description;
}

/*
function get_spotify_episodes($podcastID, $tokenData) {
	
	if (isset($tokenData['access_token'])) {
	    $accessToken = $tokenData['access_token'];
	    // You now have the access token
	
        $url = 'https://api.spotify.com/v1/shows/' . $podcastID .'/episodes';
        $response = wp_remote_get($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
        ]);

        if (is_wp_error($response)) {
            return 'Error: Could not retrieve episode data.';
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
	} else {
	    // Handle the error
	    echo 'Failed to retrieve access token. Response: ' . $result;
	}

    return $data;
}
*/

function get_spotify_episodes($podcastID, $tokenData) {
    $data = null;
    
    if (!isset($tokenData['access_token'])) {
        error_log('Spotify API Error: Missing access token in tokenData');
        return ['error' => 'Failed to retrieve access token. No token provided.'];
    }
    
    $accessToken = $tokenData['access_token'];
    $url = 'https://api.spotify.com/v1/shows/' . $podcastID . '/episodes';
    
    $response = wp_remote_get($url, [
        'headers' => [
            'Authorization' => 'Bearer ' . $accessToken,
        ],
    ]);

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log('Spotify API Error: ' . $error_message);
        return ['error' => 'Could not retrieve episode data: ' . $error_message];
    }

    $status_code = wp_remote_retrieve_response_code($response);
    if ($status_code !== 200) {
        $body = wp_remote_retrieve_body($response);
        error_log('Spotify API Error: HTTP ' . $status_code . ' - ' . $body);
        return ['error' => 'Spotify API returned status ' . $status_code];
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if ($data === null) {
        error_log('Spotify API Error: Failed to decode JSON response: ' . $body);
        return ['error' => 'Failed to parse Spotify response'];
    }

    return $data;
}

function get_podcast_episodes_from_rss($feed_url) {
    // 1. Fetch the RSS Feed
    $response = wp_remote_get($feed_url, [
        'timeout' => 15,
        'sslverify' => true,
    ]);

    if (is_wp_error($response)) {
        error_log('RSS Fetch Error: ' . $response->get_error_message());
        return $response;
    }

    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
        return new WP_Error('http_error', "Server returned status $response_code");
    }

    $xml_string = wp_remote_retrieve_body($response);

    // 2. Parse the XML
    // LIBXML_NOCDATA handles <![CDATA[ ]]> tags gracefully
    $rss = simplexml_load_string($xml_string, 'SimpleXMLElement', LIBXML_NOCDATA);

    if (!$rss) {
        return new WP_Error('xml_error', 'Failed to parse RSS XML.');
    }

    $episodes = [];

    // 3. Loop through items
    foreach ($rss->channel->item as $item) {
        // Handle the 'itunes' namespace for specialized podcast tags
        $itunes = $item->children('http://googleusercontent.com/www.itunes.com/dtds/podcast-1.0.dtd');
        
        $episodes[] = [
            'title'       => (string) $item->title,
            'pubDate'     => (string) $item->pubDate,
            'description' => (string) $item->description,
            'link'        => (string) $item->link,
            'guid'        => (string) $item->guid,
            'audio_url'   => (string) $item->enclosure['url'],
            'duration'    => (string) $itunes->duration,
            'image'       => (string) $itunes->image->attributes()->href,
        ];
    }

    return $episodes;
}

function get_youtube_podcast_episodes($playlist_id, $count = 10) {
	$google_api_key = constant('GOOGLE_API_KEY');
    // 1. Construct the API URL
    // We fetch 'snippet' for titles/descriptions and 'contentDetails' for video IDs
    $url = add_query_arg([
        'part'       => 'snippet,contentDetails',
        'playlistId' => $playlist_id,
        'maxResults' => $count,
        'key'        => $google_api_key,
    ], 'https://www.googleapis.com/youtube/v3/playlistItems');

    // 2. Execute the Request
    $response = wp_remote_get($url, [
        'timeout' => 15,
        'headers' => [
	        'Referer' => home_url(), // Sends your site URL as the referrer
	    ],
    ]);

    // 3. Robust Error Handling
    if (is_wp_error($response)) {
        error_log('YouTube API Transport Error: ' . $response->get_error_message());
        return $response;
    }

    $response_code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if ($response_code !== 200) {
        error_log("YouTube API Error [$response_code]: " . ($data['error']['message'] ?? 'Unknown Error'));
        return new WP_Error('youtube_api_error', 'YouTube API rejected the request.', $data);
    }

    // 4. Map the Data to a Clean Array
    $episodes = [];
    if (!empty($data['items'])) {
        foreach ($data['items'] as $item) {
            $snippet = $item['snippet'];
            $videoId = $item['contentDetails']['videoId'];

            $episodes[] = [
                'title'       => $snippet['title'],
                'description' => $snippet['description'],
                'published'   => $snippet['publishedAt'],
                'thumbnail'   => $snippet['thumbnails']['high']['url'] ?? $snippet['thumbnails']['default']['url'],
                'video_url'   => 'https://www.youtube.com/watch?v=' . $videoId,
                'embed_url'   => 'https://www.youtube.com/embed/' . $videoId,
                'video_id'    => $videoId,
            ];
        }
    }

    return $episodes;
}

function get_first_sentence($text) {
    // This regex looks for text from the start of the string (^) 
    // until it finds a period (.), question mark (?), or exclamation mark (!)
    // followed by a space or the end of the string.
    if (preg_match('/^[^.?!]+[.?!]\s?/s', $text, $match)) {
        return trim($match[0]);
    }
    // If no clear ending punctuation is found, return the entire text (or handle as needed)
    return trim($text);
}

add_action( 'acf/init', 'setup_blocks' );
function setup_blocks() {

	if( function_exists('acf_register_block') ) {
		//spotify embed block
		acf_register_block_type([
		    'name'            => 'custom-spotify-embed-block',
		    'title'           => __('So What Podcast: Spotify Embed Block'),
		    'description'     => __('Custom Spotify Embed Block'),
		    'render_template' => '/blocks/custom-spotify-block/template.php',
		    'category'        => 'text',
		    'icon'            => 'star-empty',
		    'mode'            => 'preview',
		    'keywords'        => ['Spotify','podcast'],
		    'supports'		=> [
		        'align'			    => false,
		        'customClassName'	=> true,
		        'jsx' 			    => true,
		    ]
		]);
		
		//spotify multiepisode block
		acf_register_block_type([
		    'name'            => 'custom-spotify-multiepisode-block',
		    'title'           => __('So What Podcast: Spotify Multi-Episode Block'),
		    'description'     => __('Custom Spotify Embed Block'),
		    'render_template' => '/blocks/custom-spotify-multiepisode-block/template.php',
		    'category'        => 'text',
		    'icon'            => 'star-empty',
		    'mode'            => 'preview',
		    'keywords'        => ['Spotify','podcast'],
		    'supports'		=> [
		        'align'			    => false,
		        'customClassName'	=> true,
		        'jsx' 			    => true,
		    ]
		]);
	}
}
