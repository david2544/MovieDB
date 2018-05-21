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
		$db = pg_connect("host=ec2-54-225-96-191.compute-1.amazonaws.com dbname=d5atvkjal9m2rg user=rvbzxlyjcbahyp password=c708d42e52c77f93c9db9913be5ea52ed8647289510622ec6e464799d4b706e5");
		$movieid = $_POST['movieId'];
		$username = $_SESSION['username'];
		$sql = "DELETE FROM favorites WHERE username='$username' AND movieid='$movieid'";
		pg_query($db, $sql);
		echo 'true';
	} else {
		echo 'false';
	}
}
