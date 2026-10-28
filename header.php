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
    <meta property="og:description" content="<?php echo esc_html( $so_what_podcast_description ); ?>">
    <meta property="og:image" content="https://podsowhat.com/wp-content/uploads/2026/01/so-what-podcast_logo.png">
    <meta property="og:url" content="https://podsowhat.com/">
    <meta property="og:type" content="website"> <!-- or 'article', 'profile', etc. -->

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Solway:wght@300;400;500;700;800&family=Roboto:ital,wght@0,100..900;1,100..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'so_what_podcast' ); ?></a>
			
<a id="ui-theme-toggle" class="ui-theme-toggle ui-theme-toggle-light-mode-active" href="#">
	<img class="ui-theme-toggle-img ui-theme-toggle-img-dark-mode" src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon_moon.png" />
</a>

<nav id="site-navigation" class="main-navigation">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="site-branding bg-tiffany-green">
			<h1 class="font-solway">So What?</h1>
			<h2 class="font-solway">A Podcast</h2>
		</div>
	</a>
	<!-- <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'so_what_podcast' ); ?></button> -->
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'menu-1',
			'menu_id'        => 'primary-menu',
		)
	);
	?>
</nav><!-- #site-navigation -->

<?php wp_body_open(); ?>

<div id="page" class="site">
