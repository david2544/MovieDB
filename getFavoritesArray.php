<?php
// Check if session already started
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 

// Only going further if this file was accessed by ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	// If user is logged in, we get all the movieId of the user from the favorite table and then return them to js.
	if (isset($_SESSION['username'])) {
		$db = pg_connect(getenv('DATABASE_URL'));
		$username = $_SESSION['username'];
		$sql = "SELECT movieid FROM favorites WHERE username='$username'";
		$result = pg_query($db, $sql);
		$moviesArray = pg_fetch_all($result);
		//ChromePhp::log($moviesArray);
		//ChromePhp::log(json_encode($moviesArray));
		echo json_encode($moviesArray);
	} else {
		echo 'false';
	}
}
