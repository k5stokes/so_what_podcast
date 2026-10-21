<?php
/**
 * Template part for displaying the Episodes page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package So_What_Podcast
 */
$episode_query = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'meta_key'       => '_so_what_youtube_video_id',
		'orderby'        => array( 'date' => 'DESC', 'ID' => 'DESC' ),
		'no_found_rows'  => true,
	)
);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container container-wide">
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
		<?php if ( $episode_query->have_posts() ) : ?>
				<section class="recent-episodes" aria-labelledby="recent-episodes-title">
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
		<?php wp_reset_postdata(); ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
