<section class="header-bg-i active">
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
	</section> <!-- close header-bg-i -->