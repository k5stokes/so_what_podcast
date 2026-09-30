<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package So_What_Podcast
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri(); ?>/img/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon-16x16.png">
	
	<!-- Standard meta tag for all platforms -->
    <meta name="image" content="https://podsowhat.com/wp-content/uploads/2026/01/so-what-podcast_logo.png">

    <!-- Open Graph tags (specifically for Facebook and other platforms) -->
    <meta property="og:title" content="So What Podcast">
    <meta property="og:description" content="A podcast that talks to experts about one thing that is profoundly and perhaps unexpectedly significant and that they will argue should matter to everyone. Hosted by Sean Johnson Andrews and Madhurima Chakraborty">
    <meta property="og:image" content="https://podsowhat.com/wp-content/uploads/2026/01/so-what-podcast_logo.png">
    <meta property="og:url" content="https://podsowhat.com/">
    <meta property="og:type" content="website"> <!-- or 'article', 'profile', etc. -->

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Solway:wght@300;400;500;700;800&family=Roboto:ital,wght@0,100..900;1,100..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
	<style>
		/* Typography */
		roboto-<uniquifier> {
		  font-family: "Roboto", sans-serif;
		  font-optical-sizing: auto;
		  font-weight: <weight>;
		  font-style: normal;
		  font-variation-settings:
		    "wdth" 100;
		}
		* {
		  font-family: "Outfit", sans-serif;
		  font-optical-sizing: auto;
		  font-weight: <weight>;
		  font-style: normal;
		  box-sizing: border-box;
		}
		h1, h2, h3, h4, h5 {
			font-family: "Solway", serif;
			font-weight: 500;
			font-style: normal;
			line-height: 1.15em;
		}
		h1, h2, h3 {
			margin: 0 0 30px;
		}
		h4, h5 {
			margin: 0 0 20px;
		}
		h3 {
			font-size: 28px;
			text-align: center;
		}
		h4 {
			font-size: 18px;
			background: #D6E5E3;
			padding: 3px 5px;
		}
		h5 {
			font-size: 18px;
		}
		p {
			font-size: 16px;
			line-height: 1.5em;
			margin: 0.5em 0 1em;
		}
		a {
			color: #B87D4B;
		}
		
		/* General */
		html, body {
			height: 100%;
		}
		.container {
			margin: 0 auto;
			width: 100%;
			max-width: 100%;
			padding: 0 20px;
		}
		@media all and (min-width: 680px) {
			.container, .wp-block-group {
				max-width: 680px;
				padding: 0;
				margin: 0 auto;
			}
			.container.container-wide {
				max-width: 100%;
				padding: 0 20px;
			}
		}
		@media all and (min-width: 980px) {
			.container.container-wide {
				max-width: 980px;
			}
		}
		.grid {
			display: grid;
		}
		.grid.grid-3-col {
			grid-template-columns: 1fr 1fr 1fr;
			gap: 20px;
		}
		.grid.grid-2-col {
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: 20px;
		}
		.grid.grid-centered {
			text-align: center;
		}
		.grid .grid-column {
			width: 100%;
		}
		@media all and (max-width: 840px) {
			.grid.grid-2-col {
				display: block;
			}
		}
		
		/* Utility */
		.display-none {
			display: none;
		}
		.bg-tiffany-green {
			background: #9FD8CB;
		}
		.bg-copper {
			background: #B87D4B;
			color: #fff;
		}
		.bg-melon {
			background: #FFA69E;
		}
		.font-solway {
		  font-family: "Solway", serif;
		  font-weight: 500;
		  font-style: normal;
		}
		
		/* Accordions */
		.accordion-header {
			position: relative;
			display: inline-block;
			cursor: pointer;
		}
		.accordion-header:after {
			content: "+";
		    font-family: "Courier New", Courier, monospace;
		    font-weight: bold;
		    font-size: 24px;
		    position: absolute;
		    top: 0;
		    right: -24px;
		}
		.accordion-header.active:after {
			content: "-";
		}
		.accordion-content {
		  max-height: 0;
		  overflow: hidden;
		  transition: max-height 0.35s ease-in-out;
		}
		.accordion-content.active {
		  max-height: 1000px;
		}
		
		/* Header */
		.site-branding {
			width: 430px;
			height: 430px;
			border-radius: 100%;
			transform: rotate(-6deg);
			padding-top: 10px;
			box-shadow: 5px 5px 0px #B87D4B;
		}
		header.site-header {
			text-align: center;
			display: flex;
			align-items: center;
			justify-content: center;
			flex-direction: column;
			margin: 20px 0 40px;
			position: relative;
		}
		header.site-header h1 {
			font-size: 105px;
			line-height: 1em;
			margin: 0 0 20px;
			font-weight: normal;
			line-height: 85px;
			padding-top: 10px;
			color: #333;
		}
		header.site-header h2 {
			font-size: 28px;
			line-height: 1em;
			margin: 0 0 10px;
		}
		.site-blurb {
			width: 600px;
			text-align: center;
			background: #fff;
			position: absolute;
			bottom: 25px;
		}
		.site-blurb p {
			margin: 10px 0;
		}
		@media all and (max-width: 640px) {
			.site-blurb {
				width: 100%;
				padding: 0 20px 0;
			}
		}
		@media all and (max-width: 500px) {
			.site-blurb {
				bottom: 0;
			}
			
		}
		@media all and (max-width: 450px) {
			.site-branding {
				width: 350px;
				height: 350px;
				padding: 20px 20px 0;
			}
			header.site-header h1 {
				font-size: 85px;
				line-height: 75px;
				padding-top: 30px;
			}
			.site-blurb {
				position: relative;
				margin-top: -70px;
			}
		}
		
		/* Color Scheme Toggle */
		.color-scheme-toggle-wrapper {
			position: fixed;
			top: 5px;
			right: 20px;
		}
		.color-scheme-toggle {
			display: block;
		}
		.color-scheme-toggle-wrapper img {
			display: none;
			width: 24px;
		}
		.color-scheme-toggle-wrapper img.active {
			display: block;
		}
		
		/* Podcast Directories */
		.podcast-directories {
			margin-bottom: 60px;
		}
		.podcast-directories .grid {
			max-width: 400px;
			margin: 0 auto;
		}
		.podcast-directory-logo img {
			width: 96px;
		}
		
		/* Episodes */
		iframe {
			margin-bottom: 5px;
		}
		.wp-block-columns {
			margin-bottom: 10px !important;
		}
		.spotify-episode-description {
			max-width: 600px;
		}
		
		/* Host Bios */
		.wp-block-columns.host-bios .wp-block-column {
			text-align: center;
			margin-bottom: 20px;
		}
		.host-bios h4, .host-bios p {
			max-width: 325px;
			margin-left: auto;
			margin-right: auto;
		}
		@media all and (min-width:782px) {
			.wp-block-columns.host-bios {
				gap: 20px;
				justify-content: space-evenly;
			}
			.wp-block-columns.host-bios .wp-block-column {
				max-width: 325px;
				text-align: center;
			}
		}
		.host-bios img {
			max-width: 250px;
			box-shadow: 6px 6px 10px rgba(200,200,200,0.5);
		}
		
		/* Footer */
		footer {
			background: #D6E5E3;
			padding: 40px;
			text-align: center;
			margin: 60px 0 0;
		}
		
		/* UI Theme Toggle */
		#ui-theme-toggle {
			display: block;
			outline: none;
			position: fixed;
			z-index: 100;
		    top: 20px;
		    right: 20px;
		}
		.ui-theme-toggle {
			box-sizing: border-box;
			padding: 5px;
			border-radius: 5px;
		}
		.ui-theme-toggle-light-mode-active {
			background-color: rgba(255,255,255,0.75);
		}
		.ui-theme-toggle-dark-mode-active {
			background-color: rgba(18,18,18,0.75);
		}
		.ui-theme-toggle-img {
			display: block;
			width: 30px;
		}
		
		/* Dark Mode */
		body.dark-mode, body.dark-mode .site-blurb {
			background: #121212 !important;
		}
		body.dark-mode h1, body.dark-mode h2, body.dark-mode h3, body.dark-mode h4, body.dark-mode h5, body.dark-mode p {
			color: #fafafa !important;
		}
		body.dark-mode header.site-header h1, body.dark-mode header.site-header h2 {
			color: #333 !important;
		}
		body.dark-mode .bg-tiffany-green {
			/* background: #5b8c81; */
		}
		body.dark-mode h4, body.dark-mode footer {
			background: #143935 !important;
		}
		body.dark-mode a:visited {
			color: #c150c1;
		}
		@media all and (prefers-color-scheme: dark) {
			body, .site-blurb {
				background: #121212 !important;
			}
			h1, h2, h3, h4, h5, p {
				color: #fafafa !important;
			}
			header.site-header h1, header.site-header h2 {
				color: #333 !important;
			}
			.bg-tiffany-green {
				/* background: #5b8c81; */
			}
			h4, footer {
				background: #143935 !important;
			}
			a:visited, a:hover {
				color: #c150c1;
			}
			
			/* Light Mode from UI toggle button */
			body.light-mode, body.light-mode .site-blurb {
				background: #ffffff !important;
			}
			body.light-mode h1, body.light-mode h2, body.light-mode h3, body.light-mode h4, body.light-mode h5, body.light-mode p {
				color: #404040 !important;
			}
			body.light-mode header.site-header h1, body.light-mode header.site-header h2 {
				color: #333 !important;
			}
			body.light-mode .bg-tiffany-green {
				/* background: #5b8c81; */
			}
			body.light-mode h4, body.light-mode footer {
				background: #D6E5E3 !important;
			}
			body.light-mode a:visited, body.light-mode a:hover {
				color: #800080;
			}
		}
	</style>
</head>

<body <?php body_class(); ?>>
			
<a id="ui-theme-toggle" class="ui-theme-toggle ui-theme-toggle-light-mode-active" href="#">
	<img class="ui-theme-toggle-img ui-theme-toggle-img-dark-mode" src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon_moon.png" />
</a>

<?php wp_body_open(); ?>

<div id="page" class="site">
	<div class="color-scheme-toggle-wrapper">
		<!--
			<a class="color-scheme-toggle light-mode">
				<img class="active" src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon_moon.png" alt="Moon icon (enable dark mode)" />
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon_sun.png" alt="Sun icon (enable light mode)" />
			</a>
		-->
	</div>

	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'so_what_podcast' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding bg-tiffany-green">
			<h1 class="font-solway">So What?</h1>
			<h2 class="font-solway">A Podcast</h2>
		</div>
		<?php 
			$site_blurb = get_field('site_blurb', 'option');
			if ($site_blurb) {
		?>
			<div class="site-blurb">
				<?php echo $site_blurb; ?>
			</div>
		<?php }		
				/*
			$so_what_podcast_description = get_bloginfo( 'description', 'display' );
			if ( $so_what_podcast_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $so_what_podcast_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->
		<?php */ ?>
		<!--
		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'so_what_podcast' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</header> <!-- #masthead -->
	<?php if (have_rows('podcast_directories', 'option')) : ?>
		<div class="container">
			<div class="podcast-directories">
				<h3>Subscribe to <em>So What?</em> Podcast</h3>
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
				</div> <!-- close grid -->
			</div> <!-- close podcast directories -->
		</div> <!-- close container -->
	<?php 
		endif;

