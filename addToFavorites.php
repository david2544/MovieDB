<?php

// Check if session already started
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
// Check if ajax passed the data we are expecting
if(isset($_POST['movieId']) && !empty($_POST['movieId'])) {
	// If the user is logged in we check the db if the user already favored this item before
	if (isset($_SESSION['username'])) {
		$db = pg_connect(getenv('DATABASE_URL'));
		$movieid = $_POST['movieId'];
		$username = $_SESSION['username'];
		$sql = "SELECT * FROM favorites WHERE username='$username' AND movieid='$movieid'";
		$result = pg_query($db, $sql);
		// If he didnt, we add it to the db
		if (pg_num_rows($result) == 0) {
			$sql = "INSERT INTO favorites(username, movieid) VALUES('$username', '$movieid')";
			pg_query($db, $sql);
			echo 'true';
			die();
		// if he did, we return false and js will dispaly an alert
		} else {
			echo 'false';
			die();
		}	
	} else {
		echo 'false';
		die();
	}
}