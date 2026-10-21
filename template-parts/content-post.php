<?php
/**
 * Template part for displaying single episode posts in single.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package So_What_Podcast
 */

// Pull the first YouTube embed out of the content so the player can sit above the title.
$so_what_player_block = null;
$so_what_body_blocks  = array();

foreach ( parse_blocks( get_post_field( 'post_content' ) ) as $so_what_block ) {
	if ( ! $so_what_player_block && 'core/embed' === $so_what_block['blockName'] && 'youtube' === ( $so_what_block['attrs']['providerNameSlug'] ?? '' ) ) {
		$so_what_player_block = $so_what_block;
		continue;
	}
	$so_what_body_blocks[] = $so_what_block;
}
?>

<div class="container">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'episode' ); ?>>
			<?php if ( $so_what_player_block ) : ?>
				<div class="episode-player">
					<?php echo apply_filters( 'the_content', serialize_block( $so_what_player_block ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			<?php endif; ?>

			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<p class="episode-date">
					<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				</p> <!-- .episode-date -->
			</header>

			<div class="entry-content episode-description">
				<?php echo apply_filters( 'the_content', serialize_blocks( $so_what_body_blocks ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
	</article><!-- #post-<?php the_ID(); ?> -->
</div>
