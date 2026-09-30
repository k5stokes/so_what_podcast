<?php	  
	/* YouTube API */
	$youtube_episodes = [];
	$youtube_playlist_id = 'PLwcja8Y_R4ydyUCCk2NROLh8eFBuipORg';
	
	$youtube_episodes = get_youtube_podcast_episodes($youtube_playlist_id, $count = 10);
	$i = 0
	//print_r($youtube_episodes);
?>

<!-- <p style="text-align: center;">Episode feed is temporarily unavailable.</p> -->

<div class="grid grid-2-col">

<?php
	foreach ($youtube_episodes as $episode) {
        // Access specific properties of each episode object
        $episode_id = $episode['id'];
        $episode_name = $episode['title'];
        $episode_description = $episode['description'];
        $embed_url = $episode['embed_url'];
        $embed_code = '<iframe data-testid="embed-iframe" style="border-radius:12px" src="' . $embed_url . '" title="YouTube video player" width="100%" height="352" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen loading="lazy"></iframe>';
?>
<div class="grid-column spotify-episode">
	<h4 class="wp-block-heading"><?php echo $episode_name; ?></h4>
	<div class="spotify-episode">
		<?php echo $embed_code; ?>
		<h5 class="accordion-header">Episode Description</h5>
		<div class="spotify-episode-description accordion-content">
			<p><?php echo $episode_description; ?></p>
		</div>
	</div>
</div>
<?php 
	$i++;
	} // end foreach
	
	/*
	// SPOTIFY API
	$spotify_access_token = get_spotify_access_token();
	$podcastID = '5h2YRaqFsszCCwDL2CnuWd';
	$spotify_edisodes = get_spotify_episodes($podcastID, $spotify_access_token);
	//print_r($spotify_edisodes);
	
	if ( is_wp_error( $spotify_episodes ) ) {
	    error_log( 'Spotify API Error: ' . $spotify_episodes->get_error_message() );
	    $spotify_episodes = []; // Fallback to empty array
	}
		
if ( ! empty( $spotify_episodes ) && is_array( $spotify_episodes ) ) {

	$spotify_edisodes = $spotify_edisodes['items'];
		$spotify_edisodes = array_reverse($spotify_edisodes); // Go from oldest to newest
		$i = 0;
		
		//echo "spotify episode IDs:<br> ";
		//echo "<pre>";
		//print_r($spotify_edisodes);
		//echo "</pre>";
		//$episode_description = get_spotify_episode_description($episode_id, $spotify_access_token);
		//echo "Count: " . count($spotify_edisodes['items']);
?>
<div class="grid grid-2-col">
<?php

	foreach ($spotify_edisodes as $episode) {
        // Access specific properties of each episode object
        $episode_id = $episode['id'];
        $episode_name = $episode['name'];
        $episode_duration = $episode['duration_ms'];
        $episode_description = $episode['html_description'];
        
		//echo "Episode ID: " . $episode_id;
		
		$spotify_embed_code = '<iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/episode/' . $episode_id . '?utm_source=generator" width="100%" height="352" frameborder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>';

?>
<div class="grid-column spotify-episode">
	<h4 class="wp-block-heading">Episode <?php echo $i; ?></h4>
	<div class="spotify-episode">
		<?php echo $spotify_embed_code; ?>
		<h5 class="accordion-header">Episode Description</h5>
		<div class="spotify-episode-description accordion-content">
			<?php echo $episode_description; ?>
		</div>
	</div>
</div>
<?php 
	$i++;
	} // end foreach
} else {
?>
<div class="warning">
	<p>Spotify episode feed is temporarily unavailable.</p>
</div>
<?php } 
*/
?>

</div> <!-- close columns -->