<?php
// Check if session already started
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
// Here we simply check if the user is logged in or not, and return that to js. We only go further from here
// if this route was accessed by ajax and has the data we expect.
if(isset($_POST['action']) && !empty($_POST['action'])) {

	if (isset($_SESSION['username'])) {
		echo 'true';
	} else {
		echo 'false';
	}
}