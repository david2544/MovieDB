<?php

if(isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST['action'];
	switch($action) {
		case 'isUserLoggedIn' : test();break;
		case 'test' : blah();break;
        // ...etc...
	}
}

function test () {
	if (isset($_SESSION['username'])) {
		return true;
	} else {
		return false;
	}
}

function blah () {
	if (isset($_SESSION['username'])) {
		return true;
	} else {
		return false;
	}
}