<?php
// Verify login info for Ampache API and set cookies.
// If remember me was selected make cookie permanent otherwise limit lifespan with time().

	/*
	$curl = curl_init();

  //Build the handshake string to get auth key

  $time = time();
  $key = hash('sha256', $_POST["pass"]);
  $passphrase = hash('sha256',$time . $key);
  $url = $_POST["host"].'/server/json.server.php?action=handshake&auth='.$passphrase.'&timestamp='.$time.'&user='.$_POST["name"];

  // CURL options.
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
  ));

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

  //Execute
  $result = curl_exec($curl);
  if(!$result){die("Connection Failure");}
  curl_close($curl);
	*/


	if(!empty($_POST["remember"])) {
		setcookie ("host",$_POST["host"],time()+ 3600);
		setcookie ("name",$_POST["name"],time()+ 3600);
		setcookie ("pass",$_POST["pass"],time()+ 3600);
		echo "Cookies Set Successfully";
	} else {
		setcookie ("host",$_POST["host"],0);
		setcookie ("name",$_POST["name"],0);
		setcookie ("pass",$_POST["pass"],0);
		echo "Cookies expire at end of session";
	}

	header ('Location: index.php');

?>
