<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 

if(isset($_POST['action']) && !empty($_POST['action'])) {

	if (isset($_SESSION['username'])) {
		echo 'true';
	} else {
		echo 'false';
	}
}