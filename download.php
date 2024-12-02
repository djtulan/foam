<?php
 	$filename = $_GET["filename"];
  header("Content-Disposition: attachment; filename=\"$filename\"");

	include 'includes/callAPI.php';

 	$uid = $_GET["uid"];
 	$type = $_GET["type"];

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);
	$auth=$hshake['auth'];

  $get_data = downloadSongAPI($auth, $uid, $type);

  echo $get_data;
?>
