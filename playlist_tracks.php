<?php
	include 'includes/callAPI.php';

	$uid = $_GET["uid"];

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake['auth'];

	$get_data = playlistAPI($auth, $uid);
	$playlist_results = json_decode($get_data, true);

	$get_data = playlistsongsAPI($auth, $uid);
	$song_results = json_decode($get_data, true);

	include 'includes/header_iframe.php';
?>
<script>
parent.activeMenu(0); // Call js function in parent to highlight the correct active menu item -->
parent.list = []; // Clean out the old list before we build a new one

// Function to hide star and elipse on track listing row
function hideicon(num) {
		if (document.getElementById("hiddenstar"+num).className !== "blue star icon") {
    	document.getElementById("hiddenstar"+num).setAttribute("style", "opacity:0 !important");
		}
    document.getElementById("hiddenelipse"+num).setAttribute("style", "opacity:0 !important");
}
// Function to reveal star and elipse on track listing row
function revealicon(num) {
    document.getElementById("hiddenstar"+num).setAttribute("style", "opacity:1 !important");
    document.getElementById("hiddenelipse"+num).setAttribute("style", "opacity:1 !important");
}
</script>
<body style="overflow:hidden">
			  <div class="ui inverted space segment">
					<?php
						echo '<div class="ui one column grid">'; //Two columns - first column just for spacing.

							// Left column for stats
							echo '<div class="ui four wide column">';
								echo '<br>';
								echo '<strong>' . $playlist_results['name'] . '</strong>';
								echo '<br>(Playlist)';
								echo '<br>' . $playlist_results['items'] . ' songs';
							echo '</div>'; // End of 1st column

							// Right column for album songs in table
							echo '<div class="ui twelve wide column">';
								echo '<div class="ui huge smoke header">' . $playlist_results['name'] . '</div>';
								echo '<button class="ui tiny grey button" id="playb"><i class="play icon"></i>PLAY</button>';
								echo '&nbsp;<button class="ui tiny grey button" id="shufb"><i class="random icon"></i>SHUFFLE</button>';
								echo '&nbsp;<div class="ui inline dropdown"><i class="ellipsis vertical icon"></i>';
								echo '	<div class="menu" id="albumMenu">';
								echo '	<div class="item">Play next</div>';
								echo '	<div class="item">Add to queue</div>';
								echo '</div></div>';
								// Make a listener for clicking on the play button
								echo "<script>playb.addEventListener('click', function() {";
								echo "  parent.newQueue('0');";
								echo '});</script>';

								// Make a listener for clicking on the shuffle button
								echo "<script>shufb.addEventListener('click', function() {";
								echo "  parent.shuffle('0');";
								echo '});</script>';

								//Let's make the table for the song list
								echo '<table class="ui selectable inverted black table">';
								echo '<thead><tr>';
								echo '<th>Title</th><th>Artist</th><th></th><th>Time</th><th>DL</th>';
								echo '</tr></thead>';
								echo '<tbody>';
								$cnt = $playlist_results['items']; //Set counter to number of songs in the playlist

								//Loop through the songs to display each on a table row
								for ($i = 0; $i < $cnt; $i++){
									echo '<tr id="row' . $i . '">'; // Start of the track listing row
										echo '<td id="trk' . ($i + 1) . '"><strong>' . $song_results['song'][$i]['title'] . '</strong></td>';
										echo '<td><a href="artist_albums.php?uid=' . $song_results['song'][$i]['artist']['id'] . '">';
										echo $song_results['song'][$i]['artist']['name'] . '</a></td>';

											// hidden star and elipse reveal on mouseover row (see listeners below)
											// some code here to test if song is flagged or not (favourite = blue star)
											$fav = $song_results['song'][$i]['flag'];
											if ($fav == true) {
												$favi = "blue star icon";
											} else {
												$favi = "hidden star outline icon";
											}

											echo '<td><i class="' . $favi . '" id="hiddenstar' . $i . '"></i>&nbsp';
											echo '<div class="ui inline dropdown"><i class="hidden ellipsis vertical icon" id="hiddenelipse' . $i . '"></i>';
											echo '	<div class="menu" id="albumMenu">';
											echo '		<div class="item" id="playNext' . $i . '">Play next</div>';
											echo '		<div class="item" id="addT2Q' . $i . '">Add to queue</div>';
											echo '		<div class="item">Go to album</div>';
											echo '		<div class="item">Go to artist</div>';
											echo '	</div>';
											echo '</div></td>';

										// Calculate song length from seconds
										$result = sec2mins($song_results['song'][$i]['time']);
										echo '<td>' . $result['minutes'] . ':' . sprintf("%02d", $result['seconds']) . '</td>';
										echo '<td><a href="' . $song_results['song'][$i]['url'] . '"><i class="download icon"></i></a></td>';
									echo '</tr>'; // End of the row but theres some other stuff still to do in this loop

									// Let's add this entry to our js 'list' array in case it becomes a new playlist or queue
									echo '<script>';
									echo 'parent.list[' . $i . '] = [];';
									echo 'parent.list[' . $i . '][0] = "' . $song_results['song'][$i]['title'] . '";';
									echo 'parent.list[' . $i . '][1] = "' . $song_results['song'][$i]['artist']['name'] . '";';
									echo 'parent.list[' . $i . '][2] = "' . $result['minutes'] . ':' . sprintf("%02d", $result['seconds']) . '";';
									echo 'parent.list[' . $i . '][3] = "' . $song_results['song'][$i]['art'] . '";';
									echo 'parent.list[' . $i . '][4] = "' . $song_results['song'][$i]['url'] . '";';
									echo '</script>';

									// Make a listener for clicking on this track title
									echo "<script>trk" . ($i + 1) . ".addEventListener('click', function() {";
									echo "  parent.newQueue('" . $i . "');";
									echo '});</script>';

									// Make a listener for hovering over a row to make star and elipse visible
									echo "<script>row" . $i . ".addEventListener('mouseover', function() {";
									echo "	revealicon('" . $i . "');";
									echo "});</script>";

									// Make a listener for moving off a row to make star and elipse invisible
									echo "<script>row" . $i . ".addEventListener('mouseout',  function() {";
									echo "	hideicon('" . $i . "');";
									echo "});</script>";

									// Make a listener for add track to queue (addT2Q) menu item
									echo "<script>addT2Q" . $i . ".addEventListener('click',  function() {";
									echo "	parent.addT2Q('" . $i . "');";
									echo "});</script>";

									// Make a listener for playNext menu item
									echo "<script>playNext" . $i . ".addEventListener('click',  function() {";
									echo "	parent.playNext('" . $i . "');";
									echo "});</script>";

								}//End of row loop

								echo '</tbody></table>';
							echo '</div>'; // End of 2nd column

						echo '</div>'; //End of content grid.
					?>
			  </div>
<!-- JS to initialise dropdowns-->
<script>
$('.ui.dropdown')
  .dropdown()
;
</script>
</body>
</html>