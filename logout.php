<?php
	// On the click of the log out button, the user will be logged out and redirected to index.php
// Check if session already started
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
session_destroy();
unset($_SESSION['username']);
header("location: index.php");