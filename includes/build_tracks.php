<?php
 // print_r($song_results);

								//Let's make the table for the song list
								echo "\r\n" . '<table class="ui selectable inverted black table">' . "\r\n";
								echo '<thead><tr>';
								if ($trknum == true) echo '<th>#</th>';
								echo '<th>Title</th>';
								if ($albnam == true) {		// If we want to display album name or artist name
									echo '<th>Album</th>';
								} else {
									echo '<th>Artist</th>';
								}
								echo '<th></th><th>Genre</th><th>Time</th><th>DL</th></tr></thead>' . "\r\n";
								echo '<tbody>' . "\r\n";
								$cnt = $main_results['album'][0]['songcount']; //Set counter to total number of songs on album

								//Loop through the songs to display each on a table row
								for ($i = 0; $i < $cnt; $i++) {
									echo "\r\n" . '<tr class="albm-row" id="row' . $i . '">' . "\r\n"; // Start of the track listing row
										if ($trknum == true) echo '<td id="tno' . ($i + 1) . '">' . $song_results['song'][$i]['track'] . '</td>' . "\r\n";
										echo '<td id="trk' . ($i + 1) . '"><strong>' . $song_results['song'][$i]['title'] . '</strong></td>' . "\r\n";

										if ($albnam == true) {				// If we want to display album name or artist name
											echo '<td><a href="album_view.php?uid=' . $song_results['song'][$i]['album']['id'] . '">';
											echo $song_results['song'][$i]['album']['name'] . '</a></td>' . "\r\n";
										} else {
											echo '<td><a href="artist_albums.php?uid=' . $song_results['song'][$i]['artist']['id'] . '">';
											echo $song_results['song'][$i]['artist']['name'] . '</a></td>' . "\r\n";
										}
										// hidden star and elipse reveal on mouseover row (see listeners below)
										// some code here to test if song is flagged or not (favourite = blue star)
										$fav = $song_results['song'][$i]['flag'];
										if ($fav == true) {
											$favi = "blue star icon"; // Blue star if it's a fav
										} else {
											$favi = "hidden star outline icon";  // Hidden star outline if not fav
										}
										echo '<td><i class="' . $favi . '" id="hiddenstar' . $i . '"></i>&nbsp;' . "\r\n";

										// Here's the code for the hidden drop down menu that appears on each track row under vertical elipsis
										echo '<div class="ui inline dropdown"><i class="hidden ellipsis vertical icon" id="hiddenelipse' . $i . '"></i>' . "\r\n";
										echo '	<div class="menu" id="albumMenu">' . "\r\n";
										echo '		<div class="item" id="addT2Q' . $i . '">Add to queue</div>' . "\r\n";
										echo '		<div class="item" id="playNext' . $i . '">Play next</div>' . "\r\n";
										echo '		<div class="item" id="playOnly' . $i . '">Play only</div>' . "\r\n";
                    if ($plylst == true) echo '		<div class="item" id="remTFP' . $i . '">Remove from playlist</div>' . "\r\n";
										echo '		<div class="item" id="addT2P' . $i . '">Add to playlist' . "\r\n";
										echo '      <div class="menu">' . "\r\n";  // Add to playlist spawns another submenu
										echo '        <div class="item" id="newplaylist' . $i . '"><center><button class="ui tiny basic button">NEW</button></center></div>' . "\r\n";
										// Loop to add all our known playlists to the sub menu
										$j = 0;
										foreach ($playlists_results['playlist'] as $playlist) {
											echo '      <div class="item" id="playlist' . $i . "_" . $j . '">' . $playlist['name'] . '</div>' . "\r\n";
											$j++;
										}
										echo '      </div>' . "\r\n";
										echo '    </div>' . "\r\n";
										echo '		<div class="item"><a class="icn" href="album_view.php?uid=' . $song_results['song'][$i]['album']['id'] . '">Go to album</a></div>' . "\r\n";
										echo '		<div class="item"><a class="icn" href="artist_albums.php?uid=' . $song_results['song'][$i]['artist']['id'] . '">Go to artist</a></div>' . "\r\n";
										echo '	</div>' . "\r\n";
										echo '</div></td>' . "\r\n";

										echo '<td>' . $song_results['song'][$i]['genre'][0]['name'] . '</td>' . "\r\n";

										// Calculate song length from seconds
										$result = sec2mins($song_results['song'][$i]['time']);

										echo '<td>' . (($result['hours'] > 0) ? $result['hours'].':' : '') .  $result['minutes'] . ':' . sprintf("%02d", $result['seconds']) . '</td>' . "\r\n";

										// echo '<td><a href="' . $song_results['song'][$i]['url'] . '"><i class="download icon"></i></a></td>' . "\r\n";
										echo '<td><a href="download.php?uid=' . $song_results['song'][$i]['id'] . '&type=song&filename=' . $song_results['song'][$i]['filename']  . '"><i class="download icon"></i></a></td>' . "\r\n";

									echo '</tr>' . "\r\n"; // End of the row but theres some other stuff still to do in this loop

									// Let's add this entry to our js 'list' array in case it becomes a new playlist or queue
									$safeTitle = addslashes($song_results['song'][$i]['title']);  // escapes any quotes in the title
									echo "\r\n" . '<script>' . "\r\n";
									echo ' parent.list[' . $i . '] = [];' . "\r\n";
									echo ' parent.list[' . $i . '][0] = "' . $safeTitle . '";' . "\r\n";
									echo ' parent.list[' . $i . '][1] = "' . $song_results['song'][$i]['artist']['name'] . '";' . "\r\n";
									echo ' parent.list[' . $i . '][2] = "' . $result['minutes'] . ':' . sprintf("%02d", $result['seconds']) . '";' . "\r\n";
                  echo ' parent.list[' . $i . '][3] = "' . $song_results['song'][$i]['art'] . '";' . "\r\n";
									echo ' parent.list[' . $i . '][4] = "' . $song_results['song'][$i]['url'] . '";' . "\r\n";
									echo ' parent.list[' . $i . '][5] = "' . $song_results['song'][$i]['album']['id'] . '";' . "\r\n";
									echo ' parent.list[' . $i . '][6] = "' . $song_results['song'][$i]['id'] . '";' . "\r\n";
									echo '</script>' . "\r\n";

									// ** TEMP NOTE ** Remove these duplicate functions and create single named functions for better performance
									// Make a listener for clicking on this track title
									echo "<script>trk" . ($i + 1) . ".addEventListener('click', function() {";
									echo "  parent.newQueue('" . $i . "');";
									echo '});</script>' . "\r\n";

									// Make a listener for clicking the favourite star
									echo "<script>hiddenstar" . $i . ".addEventListener('click',  function() {";
									echo '	if (document.getElementById("hiddenstar' . $i . '").className !== "blue star icon") {';
									echo '   	  document.getElementById("hiddenstar' . $i . '").className = "blue star icon";';
									echo '	    $.get("includes/favAPI.php?type=song&id=' . $song_results['song'][$i]['id'] . '&flag=1");';
									echo '	} else { ';
									echo '			document.getElementById("hiddenstar' . $i . '").className = "hidden star outline icon";';
									echo '	    $.get("includes/favAPI.php?type=song&id=' . $song_results['song'][$i]['id'] . '&flag=0");';
									echo '	}';
									echo '});</script>' . "\r\n";

									// Make a listener for add track to queue (addT2Q) menu item
									echo "<script>addT2Q" . $i . ".addEventListener('click',  function() {";
									echo "	parent.addT2Q('" . $i . "');";
									echo '});</script>' . "\r\n";

									// Make a listener for playNext menu item
									echo "<script>playNext" . $i . ".addEventListener('click',  function() {";
									echo "	parent.playNext('" . $i . "');";
									echo '});</script>' . "\r\n";

									// Make a listener for playOnly menu item
									echo "<script>playOnly" . $i . ".addEventListener('click',  function() {";
									echo "	parent.newSingle('" . $i . "');";
									echo '});</script>' . "\r\n";

									if ($trknum == true) {
										// Make a listener for clicking on this track number
										echo "<script>tno" . ($i + 1) . ".addEventListener('click', function() {";
										echo "  parent.newQueue('" . $i . "');";
										echo '});</script>' . "\r\n";
									}

                  if ($plylst == true)  {
  									// Make a listener for clicking the remove from playlist menu item
  									echo "<script>remTFP" . $i . ".addEventListener('click',  function() {";
  									echo '	    $.get("includes/playlistAPI.php?action=remove&filter=' . $uid . '&song=' . $song_results['song'][$i]['id'] . '");';
  									echo '      location.reload();';  // Do a reload so we can see the change
  									echo '});</script>' . "\r\n";
                  }

									// Make a listener for clicking the add to playlist menu item - we need a loop to create 1 for each playlist
									$j = 0;
									foreach ($playlists_results['playlist'] as $playlist) {
										echo "<script>playlist" . $i . "_" . $j . ".addEventListener('click',  function() {";
										echo '	    $.get("includes/playlistAPI.php?action=add&filter=' . $playlist['id'] . '&song=' . $song_results['song'][$i]['id'] . '");';
										echo '});</script>' . "\r\n";
										$j++;
									}

									// Make a listener for clicking new playlist menu item
									echo "<script>newplaylist" . $i . ".addEventListener('click',  function() {";
									echo "	$('.ui.modal')";
									echo "    .modal({";
									echo "       onApprove : function() {";
									echo "         var nn = document.getElementById('newname').value;";
									echo '         $.get("includes/playlistAPI.php?action=new&filter=" + nn + "&song=' . $song_results['song'][$i]['id'] . '");';
									echo "         location.reload();";  // Do a reload so we can see the change"
									echo "       }";
									echo "     })";
									echo "    .modal('show')";
									echo "  ;";
									echo '});</script>' . "\r\n";

								} //End of row loop

								echo '</tbody></table>' . "\r\n"; //End of the table

?>
