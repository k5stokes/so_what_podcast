<?php
	$spotify_embed_code = get_field('spotify_embed_code');
	
	// Get SRC from embed code
	preg_match('/<iframe[^>]+src="([^"]+)"/i', $spotify_embed_code, $matches);
	
	if (isset($matches[1])) {
	    $iframe_src = $matches[1];
		$pattern = '/spotify\.com\/embed\/episode\/([a-zA-Z0-9]{22})/';
	    if (preg_match($pattern, $iframe_src, $match)) {
	      $episode_id = $match[1];
		  
		  $spotify_access_token = get_spotify_access_token();
		  $episode_description = get_spotify_episode_description($episode_id, $spotify_access_token);
	    }
	}
?>
<div class="spotify-episode">
	<?php echo $spotify_embed_code; ?>
	<h5 class="accordion-header">Episode Description</h5>
	<div class="spotify-episode-description accordion-content">
		<?php echo $episode_description; ?>
	</div>
</div>