<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package So_What_Podcast
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<p>&copy;<?php echo date('Y'); ?> Madhurima Chakraborty &amp; Sean Johnson Andrews</p>
			
			<p>Website by <a target="_blank" href="https://krisstokes.com">Kris Stokes</a></p>
			
			<p>Moon icon by Aybige from <a href="https://thenounproject.com/browse/icons/term/moon/" target="_blank" title="Moon Icons">Noun Project</a> (CC BY 3.0)<br>
			sun icon by Lewen Design from <a href="https://thenounproject.com/browse/icons/term/sun/" target="_blank" title="sun Icons">Noun Project</a> (CC BY 3.0)</p>
			
			<!-- 
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'so_what_podcast' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'so_what_podcast' ), 'WordPress' );
				?>
			</a> -->
			<!-- <span class="sep"> | </span> -->
				<?php 
				/* translators: 1: Theme name, 2: Theme author. */
				// printf( esc_html__( 'Theme: %1$s by %2$s.', 'so_what_podcast' ), 'so_what_podcast', '<a href="http://krisstokes.com">Kris Stokes</a>' );
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<script>
	document.addEventListener('DOMContentLoaded', function () {
		const accordionHeaders = document.querySelectorAll('.accordion-header');
	
		accordionHeaders.forEach(function (accordionHeader, index) {
		  accordionHeader.addEventListener('click', function (event) {
		    event.preventDefault();
		  
		    accordionHeader.classList.toggle('active');
		    accordionHeader.nextElementSibling.classList.toggle('active');
		  });
		});
		
		// Check for browser color scheme preference
		let uiThemeToggle = document.getElementById('ui-theme-toggle');
		let siteBody = document.querySelector('body');
		let uiThemeToggleImg = document.querySelector('.ui-theme-toggle-img');
		const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)");
		
		function switchUITheme() {
			if (uiThemeToggle.classList.contains('ui-theme-toggle-light-mode-active')) {
				uiThemeToggle.classList.remove('ui-theme-toggle-light-mode-active');
				uiThemeToggle.classList.add('ui-theme-toggle-dark-mode-active');
				siteBody.classList.remove('light-mode');
				siteBody.classList.add('dark-mode');
				uiThemeToggleImg.src = 'https://podsowhat.com/wp-content/themes/so_what_podcast/img/icon_sun.png';
		 	} else {
			 	uiThemeToggle.classList.remove('ui-theme-toggle-dark-mode-active');
			 	uiThemeToggle.classList.add('ui-theme-toggle-light-mode-active');
			 	siteBody.classList.remove('dark-mode');
			 	siteBody.classList.add('light-mode');
			 	uiThemeToggleImg.src = 'https://podsowhat.com/wp-content/themes/so_what_podcast/img/icon_moon.png';
		 	}
		}
		
		if (prefersDarkScheme.matches) {
		  // User prefers dark mode
		  console.log("Dark mode is preferred.");
		  if (uiThemeToggle.classList.contains('ui-theme-toggle-light-mode-active')) {
			  uiThemeToggle.classList.remove('ui-theme-toggle-light-mode-active');
			  uiThemeToggle.classList.add('ui-theme-toggle-dark-mode-active');
			  siteBody.classList.remove('light-mode');
			  siteBody.classList.add('dark-mode');
			  uiThemeToggleImg.src = 'https://podsowhat.com/wp-content/themes/so_what_podcast/img/icon_sun.png';
		  }
		} else {
		  // User prefers light mode or no preference is set
		  console.log("Light mode is preferred.");
		  // Add code to set your website/app to light mode here
		}
		
		uiThemeToggle.addEventListener("click", function(e) {
			e.preventDefault();
			switchUITheme();
		});
		
	}, false);	
</script>

<?php wp_footer(); ?>

</body>
</html>
