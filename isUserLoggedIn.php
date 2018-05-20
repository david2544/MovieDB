<?php
session_start();
include 'ChromePhp.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
	if (isset($_SESSION['username'])) {
		echo 'true';
	} else {
		echo 'false';
	}
}


