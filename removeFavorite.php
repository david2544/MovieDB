<?php 
// Check if session already started
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 

// Check if the call is from ajax and it passed the data we are expecting

if(isset($_POST['movieId']) && !empty($_POST['movieId'])) {
	// If yes, and the user is logged in, take data received from ajax , search the db for that value and remove it.
	if (isset($_SESSION['username'])) {
		$db = pg_connect(getenv('DATABASE_URL'));
		$movieid = $_POST['movieId'];
		$username = $_SESSION['username'];
		$sql = "DELETE FROM favorites WHERE username='$username' AND movieid='$movieid'";
		pg_query($db, $sql);
		echo 'true';
	} else {
		echo 'false';
	}
}
