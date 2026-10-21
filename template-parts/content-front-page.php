<?php
/**
 * Template part for displaying the front page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package So_What_Podcast
 */

?>

<header id="masthead" class="site-header">
	<div class="bg"></div>
	<div class="bg bg2"></div>
	<div class="bg bg3"></div>
	<div class="site-blurb">
		<?php 
			//$site_blurb = get_field('site_blurb', 'option');
			$so_what_podcast_description = get_bloginfo( 'description', 'display' );
			echo "<p>" . esc_html( $so_what_podcast_description ) . "</p>";
		?>
	</div>
	<?php if (have_rows('podcast_directories', 'option')) : ?>
		<div class="container">
			<div class="podcast-directories">
				<h5>Subscribe to <em>So What?</em> Podcast</h5>
				<div class="grid grid-3-col grid-centered">
	<?php 
		while (have_rows('podcast_directories', 'option')) : the_row();
			$podcast_directory_title = get_sub_field('podcast_directory_name');
			$podcast_directory_logo = get_sub_field('podcast_directory_logo');
			$podcast_directory_link = get_sub_field('podcast_directory_link');	
	?>
			<div class="podcast-directory">
				<div class="podcast-directory-logo">
					<a class="podcast-directory-link" href="<?php echo $podcast_directory_link; ?>">
						<?php echo wp_get_attachment_image($podcast_directory_logo['ID'], 'medium', ['alt' => $podcast_directory_title]); ?>
					</a>
				</div>
			</div>
	<?php endwhile; ?>
			</div> <!-- close podcast directories -->
		</div> <!-- close container -->
	<?php endif; ?>		
</header> <!-- #masthead -->

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container container-wide">
		<?php
		$episode_query = new WP_Query(
			array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => 4,
				'meta_key'       => '_so_what_youtube_video_id',
				'orderby'        => array( 'date' => 'DESC', 'ID' => 'DESC' ),
				'no_found_rows'  => true,
			)
		);

		if ( $episode_query->have_posts() ) :
			$episode_query->the_post();
			$video_id = get_post_meta( get_the_ID(), '_so_what_youtube_video_id', true );
		?>
			<section class="latest-episode" aria-labelledby="latest-episode-title">
				<h3>Latest Episode</h3>
				<div class="grid grid-2-col">
					<div class="latest-episode-video column">
						<iframe
							class="latest-episode-player"
							src="<?php echo esc_url( 'https://www.youtube.com/embed/' . rawurlencode( $video_id ) ); ?>"
							title="<?php echo esc_attr( sprintf( __( 'Watch %s', 'so_what_podcast' ), get_the_title() ) ); ?>"
							width="560"
							height="315"
							allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
							allowfullscreen
							loading="lazy"
						></iframe>
					</div> <!-- close latest-episode-video column -->
					<div class="latest-episode-description column">
						<h2 id="latest-episode-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<p><?php echo esc_html( get_the_excerpt() ); ?></p>
					</div> <!-- close latest-episode-description column -->	
				</div> <!-- close grid -->
			</section> <!-- close latest-episode -->

			<?php if ( $episode_query->have_posts() ) : ?>
				<section class="recent-episodes" aria-labelledby="recent-episodes-title">
					<h3>Recent Episodes</h3>
					<div class="grid grid-3-col episode-grid">
						<?php while ( $episode_query->have_posts() ) : ?>
							<?php $episode_query->the_post(); ?>
							<a class="episode-card" href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'large' ); ?>
								<h4><?php the_title(); ?></h4>
							</a>
						<?php endwhile; ?>
					</div>
				</section> <!-- close recent-episodes -->
			<?php endif; ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
