<?php
include 'isUserLoggedIn.php';
include 'addToFavorites.php';
include 'getFavoritesArray.php';
include 'removeFavorite.php';
// Check if session already started
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 

//connect to db
$db = pg_connect("host=ec2-54-225-96-191.compute-1.amazonaws.com dbname=d5atvkjal9m2rg user=rvbzxlyjcbahyp password=c708d42e52c77f93c9db9913be5ea52ed8647289510622ec6e464799d4b706e5");

// If the user tried to log in, we check the users table in the db, if the user exists and passwords match, we log in the user. If not, we throw him an alert.
if (isset($_POST['login_btn'])) {
	$username = pg_escape_string($_POST['username']);
	$password = pg_escape_string($_POST['password']);

	$password = md5($password);
	$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
	$result = pg_query($db, $sql);

	if (pg_num_rows($result) == 1) {
		$_SESSION['message'] = "You are logged in";
		$_SESSION['username'] = $username;
		header("location: index.php");
	} else {
		echo '
		<div class="container">
		<div class="alert alert-dismissible alert-warning">
		<h4 class="alert-heading">Warning!</h4>
		<p class="mb-0">Wrong username/password combination or user not registered</p>
		</div>
		</div>';
		$_SESSION['message'] = "Username and/or password incorrect";

	}
}
?>
<!-- Rendering the page -->
<!DOCTYPE html>
<html>
<head>
	<title>Movie Search</title>
	<link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/solar/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark">
		<div class="container">
			<a class="navbar-brand" href="index.php">The Movies DB</a>
			<div class="collapse navbar-collapse" id="navbarColor02">
				<!-- Again we have dynamic content (here the nav bar) based on the user status: logged in or anonymous -->
				<?php 
				if (isset($_SESSION['username'])) {
					echo '
					<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
					<a class="nav-link" href="favorites.php">Favorites<span class="sr-only">(current)</span></a>
					</li>
					</ul>';
				} else {
					echo '
					<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
					<a class="nav-link" href="register.php">Register <span class="sr-only">(current)</span></a>
					</li>
					</ul>';
				}
				?>
				<?php 
				if (isset($_SESSION['username'])) {
					echo "<p class='navUserWelcome'>Welcome <strong>{$_SESSION['username']}</strong>.</p>

					<div>
					<a href='logout.php' class='btn btn-success logout_btn'>Log out</a>
					</div>
					";
				} else {
					echo '
					<form method="POST" class="form-inline my-2 my-lg-0" action="index.php">
					<div class="form-group login-form">
					<input type="text" class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
					</div>
					<div class="form-group login-form">
					<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
					</div>
					<button class="btn btn btn-primary my-2 my-sm-0" name="login_btn" type="submit">Login</button>
					</form>';
				}
				?>
			</div>
		</div>
	</nav>

	<!-- The search form -->
	<div class="container">
		<div class="jumbotron">
			<h3 class="text-center">Search your movie or tv show here</h3>
			<form id="searchForm">
				<input type="text" class="form-control" id="searchText" placeholder="Search Movies...">
				<button type="submit" class="btn btn-secondary searchBtn" id="searchTextBtn">Search Movies</button>
			</form>
		</div>
	</div>

	<!-- Alerts will be inserted here -->
	<div class="container" id="favoredAlert"></div>

	<!-- Results after the search will be inserted here -->
	<div class="container">
		<div id="movies" class="row"></div>
	</div>

	<!-- Adding jquery, axios for OMDB api call and our js file -->
	<script
	src="https://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	crossorigin="anonymous"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<script src="js/main.js"></script>
</body>
</html>

