<!-- browseInClass.php

	CP476 Final Project

	Author 1:  David Moreno-Bautista
	ID 1:      151925580
	Email 1:   more5580@mylaurier.ca

	Author 2:  Xiang Ke
	ID 2:	   150617130
	Email 2:   kexx7130@mylaurier.ca

	Version  2019-03-02
	-->

<?php
	session_start();
	include 'include/functions.php';

	$db = getDB();

	date_default_timezone_set('America/New_York');
	$timeRn = date("g:i A");

	// ----------------------------------------------- update chat log with not paying attention message
	$fp = fopen("chats/".$_SESSION['logLocation'], 'a');
	fwrite($fp,'<div class="container" style="text-align:center">'
			   .'<div class="row pl-3" style="font-size:0.8em;font-weight:bold"><i>'.$_SESSION['userName'].' is not paying attention</i></div>'
			   .'<div class="row pl-3" style="font-size:0.8em"><i>'.$timeRn.'</i></div></div>'
			   .'<div style="clear:both"></div>');
	fclose($fp);
	// ----------------------------------------------- alert the other user in session that this user is not paying attention in class
	$query = "SELECT * FROM chat WHERE SessionID = ? AND UserID != ?";
	if ($statement = mysqli_prepare($db, $query)) {
		mysqli_stmt_bind_param($statement, 'ii', $_SESSION['classID'], $_SESSION['userId']);
		mysqli_stmt_execute($statement);

		$result = mysqli_stmt_get_result($statement);
		$row = mysqli_fetch_array($result);
		if($row){
			$logName = $row[3];

			$fp = fopen("chats/".$logName, 'a');
			fwrite($fp,'<div class="container" style="text-align:center">'
					   .'<div class="row pl-3" style="font-size:0.8em;font-weight:bold"><i>'.$_SESSION['userName'].' is not paying attention</i></div>'
					   .'<div class="row pl-3" style="font-size:0.8em"><i>'.$timeRn.'</i></div></div>'
					   .'<div style="clear:both"></div>');
			fclose($fp);
		}
	}

if ($_GET["page"] == "landing_home") {
	header("Location: landing_home.php");
}
else if ($_GET["page"] == "help") {
	header("Location: help.php");
}
else if ($_GET["page"] == "profile") {
	header("Location: profile.php");
}
else if ($_GET["page"] == "logout") {
	session_destroy();
	header("Location: landing_login_signup.php");
}
else{
	header("Location: whiteboard.php");
}
?>
