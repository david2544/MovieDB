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
		$movieid = pg_escape_string($_POST['movieId']);
		$username = $_SESSION['username'];
		// $sql = "DELETE FROM favorites WHERE username= $1 AND movieid= $2";
		pg_query_params($db, 'DELETE FROM favorites WHERE username= $1 AND movieid= $2', array("$username", "$movieid"));
		echo 'true';
	} else {
		echo 'false';
	}
}
