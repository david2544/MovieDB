<?php

// Check if session alrady strted
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
// Check if ajax passed the data we are expecting
if(isset($_POST['movieId']) && !empty($_POST['movieId'])) {
	// If the user is logged in we check the db if the user already favored this item before
	if (isset($_SESSION['username'])) {
		$db = pg_connect("host=ec2-54-225-96-191.compute-1.amazonaws.com dbname=d5atvkjal9m2rg user=rvbzxlyjcbahyp password=c708d42e52c77f93c9db9913be5ea52ed8647289510622ec6e464799d4b706e5");
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
		// if he did, we do nothing
		} else {
			echo 'false';
			die();
		}	
	} else {
		echo 'false';
		die();
	}
}