<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package So_What_Podcast
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container container-wide">
		<?php the_content(); ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
