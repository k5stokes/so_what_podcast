<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package So_What_Podcast
 */

?>

<style>
		/* Fonts */
		.courier-prime-regular {
		  font-family: "Courier Prime", monospace;
		  font-weight: 400;
		  font-style: normal;
		}
		
		.courier-prime-bold {
		  font-family: "Courier Prime", monospace;
		  font-weight: 700;
		  font-style: normal;
		}
		
		.courier-prime-regular-italic {
		  font-family: "Courier Prime", monospace;
		  font-weight: 400;
		  font-style: italic;
		}
		
		.courier-prime-bold-italic {
		  font-family: "Courier Prime", monospace;
		  font-weight: 700;
		  font-style: italic;
		}
		.solway-light {
		  font-family: "Solway", serif;
		  font-weight: 300;
		  font-style: normal;
		}
		
		.solway-regular {
		  font-family: "Solway", serif;
		  font-weight: 400;
		  font-style: normal;
		}
		
		.solway-medium {
		  font-family: "Solway", serif;
		  font-weight: 500;
		  font-style: normal;
		}
		
		.solway-bold {
		  font-family: "Solway", serif;
		  font-weight: 700;
		  font-style: normal;
		}
		
		.solway-extrabold {
		  font-family: "Solway", serif;
		  font-weight: 800;
		  font-style: normal;
		}

		/* Home Page */
		.site-branding, #primary-menu, #colophon {
			display: none;
		}	
		.grid {
			display: grid;
			grid-template-columns: 1fr;
		}
		#content {
			text-align: center;
			height: 50vh;
			display: flex;
			align-items: center;
			justify-content: center;
			cursor: pointer;
		}
		#content h2 {
			font-size: 72px;
			line-height: 1em;
			margin: 0 0 20px;
			font-weight: normal;
		}
		#content h3 {
			font-size: 28px;
			line-height: 1em;
			margin: 0 0 10px;
			font-weight: normal;
		}
		.wrapper {
			position: relative;
		}
		#favorite-heart {
			width: 30px;
			position: absolute;
			top: 20px;
			right: 20px;
			cursor: pointer;
		}
		/*
		.heart-outline {
			display: block;
		}
		.heart-fill {
			display: none;
		}
		*/
		.display-none {
			display: none;
		}
		
		.font-cutive {
		  font-family: "Cutive Mono", monospace;
		  font-weight: 400;
		  font-style: normal;
		}
		.font-oswald {
			font-family: "Oswald", sans-serif;
			font-optical-sizing: auto;
			font-weight: 400;
		  font-style: normal;
		}
		.font-epunda {
			font-family: "Epunda Slab", serif;
			  font-optical-sizing: auto;
			  font-weight: 500;
			  font-style: normal;
		}
		.font-caveat {
			font-family: "Caveat", cursive;
			font-optical-sizing: auto;
			  font-weight: 700;
			  font-style: normal;
		}
		.font-marker {
			font-family: "Permanent Marker", cursive;
			font-optical-sizing: auto;
			  font-weight: 500;
			  font-style: normal;
		}
		.font-courier {
			font-family: "Courier Prime", monospace;
			font-weight: 400;
		  font-style: normal;
		}
		.font-solway {
		  font-family: "Solway", serif;
		  font-weight: 500;
		  font-style: normal;
		}
		
		.bg-azure {
			background: #D6E5E3;
		}
		.bg-celestial-blue {
			background: #008DD5;
			color: #fff;
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
		#branding-meta-info {
			margin: 0;
			box-sizing: border-box;
			padding: 20px;
		}
		#branding-meta-info p {
			margin: 0 0 5px;
		}
		
		h4 {
			text-transform: uppercase;
			color: #333;
			font-weight: normal;
		}
		.favorites-list-wrapper {
			box-sizing: border-box;
			padding: 20px;
			border-top: 1px dashed #999;
		}
		#favorites-list {
			display: flex;
			align-items: center;
			justify-content: flex-start;
			flex-wrap: wrap;
		}
		#favorites-list .row {
			width: 33%;
			margin-bottom: 10px;
		}
		#favorites-list .row span {
			display: inline-block;
			margin-right: 5px;
			padding-right: 5px;
			border-right: 1px solid #999;
		}
	</style>

<article id="post-<?php the_ID(); ?>" <?php post_class('branding'); ?>>
	<div class="container">
		<div class="grid">
			<div id="content" class="">
				<div class="content-wrapper">
					<h2>So What?</h2>
					<h3>A Podcast</h3>
				</div>
			</div>
			<div class="wrapper">
				<div id="branding-meta-info">
					<p><strong>font:</strong> <span id="font-name"></span></p>
					<p><strong>color:</strong> <span id="color-name"></span></p>
				</div>
				<div id="favorite-heart">
					<div class="heart-outline">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M442.9 144C415.6 144 389.9 157.1 373.9 179.2L339.5 226.8C335 233 327.8 236.7 320.1 236.7C312.4 236.7 305.2 233 300.7 226.8L266.3 179.2C250.3 157.1 224.6 144 197.3 144C150.3 144 112.2 182.1 112.2 229.1C112.2 279 144.2 327.5 180.3 371.4C221.4 421.4 271.7 465.4 306.2 491.7C309.4 494.1 314.1 495.9 320.2 495.9C326.3 495.9 331 494.1 334.2 491.7C368.7 465.4 419 421.3 460.1 371.4C496.3 327.5 528.2 279 528.2 229.1C528.2 182.1 490.1 144 443.1 144zM335 151.1C360 116.5 400.2 96 442.9 96C516.4 96 576 155.6 576 229.1C576 297.7 533.1 358 496.9 401.9C452.8 455.5 399.6 502 363.1 529.8C350.8 539.2 335.6 543.9 320 543.9C304.4 543.9 289.2 539.2 276.9 529.8C240.4 502 187.2 455.5 143.1 402C106.9 358.1 64 297.7 64 229.1C64 155.6 123.6 96 197.1 96C239.8 96 280 116.5 305 151.1L320 171.8L335 151.1z"/></svg>
					</div>
					<div class="heart-fill display-none">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M305 151.1L320 171.8L335 151.1C360 116.5 400.2 96 442.9 96C516.4 96 576 155.6 576 229.1L576 231.7C576 343.9 436.1 474.2 363.1 529.9C350.7 539.3 335.5 544 320 544C304.5 544 289.2 539.4 276.9 529.9C203.9 474.2 64 343.9 64 231.7L64 229.1C64 155.6 123.6 96 197.1 96C239.8 96 280 116.5 305 151.1z"/></svg>
					</div>
				</div>
			</div>
			
			<div class="favorites-list-wrapper">
				<h4>Favorites</h4>
				<div id="favorites-list">
					<?php 
						$favorites_query = "SELECT * FROM {$wpdb->prefix}favorites";
	
						$favorites = $wpdb->get_results($favorites_query);
						
						foreach($favorites as $favorite) {
							echo "<div class='row'>";
							echo "<span class='font-name'>font: " . $favorite->font_name . "</span>";
							echo "<span class='color-name'>color: " . $favorite->background_color . "</span>";
							echo "<a class='favorite-link' href='https://krisstokes.com/sowhatpodcast?color=" . $favorite->background_color . "&font=" . $favorite->font_name . "'>link</a>";
							echo "</div>";
						}	
					?>
				</div>
			</div>
		</div>	
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

<script>		
	function getRandomElementExcept(arr, excludedString) {
	  // 1. Filter the array to exclude the specified string
	  const filteredArray = arr.filter(item => item !== excludedString);
	
	  // Handle cases where the filtered array might be empty
	  if (filteredArray.length === 0) {
	    return null; // Or throw an error, depending on desired behavior
	  }
	
	  // 2. Generate a random index within the filtered array's length
	  const randomIndex = Math.floor(Math.random() * filteredArray.length);
	
	  // 3. Select the element using the random index
	  return filteredArray[randomIndex];
	}
	 
	document.addEventListener('DOMContentLoaded', function () {
		let branding = document.getElementById('content');
		let colorsArr = ["azure", "celestial-blue", "tiffany-green", "copper", "melon"];
		let fontsArr = ["oswald", "caveat", "marker", "solway", "cutive"];
		const colorName = document.getElementById('color-name');
		const fontName = document.getElementById('font-name');
		let favoriteButton = document.getElementById('favorite-heart');
		let heartOutline = document.querySelector('.heart-outline');
		let heartFill = document.querySelector('.heart-fill');
		
		const urlParams = new URLSearchParams(window.location.search);
		console.log(urlParams);
		
		if (urlParams.size !== 0) {
			const colorParam = urlParams.get('color');
			const fontParam = urlParams.get('font');
			branding.classList.add('bg-' + colorParam);
			branding.classList.add('font-' + fontParam); 
			colorName.innerHTML = colorParam;
			fontName.innerHTML = fontParam;
		} else {
		
			let newColor = getRandomElementExcept(colorsArr, '');
			let newFont = getRandomElementExcept(fontsArr, '');
			
			branding.classList.add('bg-' + newColor);
			branding.classList.add('font-' + newFont); 
			colorName.innerHTML = newColor;
			fontName.innerHTML = newFont;
		}
		
		let contentBody = document.querySelector('#content');
		
		contentBody.addEventListener('click', function() {
			let brandingClassList = branding.classList;
			const currentColorClass = Array.from(branding.classList).find(className =>
	            className.startsWith('bg-')
	        );
			const currentFontClass = Array.from(branding.classList).find(className =>
	            className.startsWith('font-')
	        );
	        branding.className = '';
	        if (currentColorClass) {
	            const currentColor = currentColorClass.replace('bg-', '');
	            console.log(currentColor);
	            let newColor = getRandomElementExcept(colorsArr, currentColor);
	            branding.classList.add('bg-' + newColor);
				colorName.innerHTML = newColor;
	        }
	        if (currentFontClass) {
	            const currentFont = currentFontClass.replace('font-', '');
	            console.log(currentFont);
	            let newFont = getRandomElementExcept(fontsArr, currentFont);
	            branding.classList.add('font-' + newFont);
				fontName.innerHTML = newFont;
	        }
	        
	        if (favoriteButton.classList.contains('active')) {
				favoriteButton.classList.remove('active');
			}
			heartFill.classList.add('display-none');
			heartOutline.classList.remove('display-none');
		})
		
		favoriteButton.addEventListener('click', function(event) {
			event.preventDefault();
			
			if (favoriteButton.classList.contains('active')) {
				heartFill.classList.add('display-none');
				heartOutline.classList.remove('display-none');
				favoriteButton.classList.remove('active');
			} else {
				heartFill.classList.remove('display-none');
				heartOutline.classList.add('display-none');
				favoriteButton.classList.add('active');
			}
			
			let fontName = document.getElementById('font-name').innerHTML;
			let colorName = document.getElementById('color-name').innerHTML;
			
			const formData = new FormData();
		    formData.append("font_name", fontName);
		    formData.append("background_color", colorName);
		    formData.append("action", "add_favorite");
			
			fetch([soWhatAjax.url], { // use your ajax url
				method: "POST",
				credentials: "same-origin",
				body: formData // put your data into fetch body
			})
			.then((response) => response.text())
			.then((text) => {
				console.log(text);
			})
			.then((data) => {
				if (data) {
					console.log(data);
				}
			})
			.catch((error) => {
				console.log("[ OPS!! add_favorite ]");
				console.error(error);
			});
			
			let favoritesList = document.getElementById('favorites-list');
			const formDataz = new FormData();
		    formDataz.append("action", "read_favorites");
		    
			fetch([soWhatAjax.url], { // use your ajax url
				method: "POST",
				credentials: "same-origin",
				body: formDataz // put your data into fetch body
			})
			.then((response) => response.text())
			.then((text) => {
				console.log('test:' + text);
				favoritesList.innerHTML = text;
			})
			.then((data) => {
				if (data) {
					console.log(data);
				}
			})
			.catch((error) => {
				console.log("[ OPS!! read_favorites ]");
				console.error(error);
			});
		})
		
	}, false);	
</script>
