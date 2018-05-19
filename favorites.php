<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>MovieInfo</title>
	<link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/solar/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php">MovieInfo</a>
			</div>
		</div>
	</nav>

	<div class="container">
		<div id="movie" class="well"></div>
	</div>

	<script
	src="https://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	crossorigin="anonymous"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<script src="js/main.js"></script>
	<script>
		getMovie();
	</script>
</body>
</html>

