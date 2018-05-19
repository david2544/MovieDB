<?php
//session_start();

	//connect to db
$db = mysqli_connect("localhost", "root", "", "authentication");

if (isset($_POST['register_btn'])) {
	session_start();
	$username = $db->real_escape_string($_POST['username']);
	$email = $db->real_escape_string($_POST['email']);
	$password = $db->real_escape_string($_POST['password']);
	$password2 = $db->real_escape_string($_POST['password2']);

	if ($password == $password2) {
		$sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
		$result = mysqli_query($db, $sql);

		if (mysqli_num_rows($result) == 0) 	{
			// create user
			//hash password before storing to db
			$password = md5($password); 
			$sql = "INSERT INTO users(username, email, password) VALUES('$username', '$email', '$password')";
			mysqli_query($db, $sql);
			$_SESSION['message'] = "You are now logged in";
			$_SESSION['username'] = $username;
			header("location: index.php");
		} else {
			echo '
			<div class="container">
			<div class="alert alert-dismissible alert-warning">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<h4 class="alert-heading">Warning!</h4>
  				<p class="mb-0">Username or email taken. Please pick a different username or email.</p>
			</div>
			</div>';
			$_SESSION['message'] = "Username or password taken";
		}

	} else {
		$_SESSION['message'] = "The two passwords did not match";	
	}
}
?>

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
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
		<form method="POST" action="register.php">
			<fieldset>
				<legend>Register</legend>
				<div class="form-group form-width">
					<label for="exampleInputEmail1">Username</label>
					<input type="text" name="username" class="form-control" placeholder="Enter username">
				</div>
				<div class="form-group form-width">
					<label for="exampleInputEmail1">Email address</label>
					<input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
					<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
				</div>
				<div class="form-group form-width">
					<label for="exampleInputPassword1">Password</label>
					<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
				</div>
				<div class="form-group form-width">
					<label for="exampleInputPassword1">Repeat Password</label>
					<input type="password" name="password2" class="form-control" id="exampleInputPassword1" placeholder="Password">
				</div>
				<button class="btn btn btn-primary my-2 my-sm-0" type="submit" name="register_btn">Login</button>
			</fieldset>
		</form>
	</div>

</body>
</html>

