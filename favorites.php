<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Movie Search</title>
	<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet"> -->
	<link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/solar/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	
</body>
</html>

			<div class="card mb-3 col-md-3">
				<div class="well text-center">
					<img src="${movie.Poster}">
					<h5>${movie.Title}</h5>

					<?php 
				if (isset($_SESSION['username'])) {
					echo '
					<a onclick="movieSelected('${movie.imdbID}')" class="btn btn-success movieCardBtn" href="#">Movie Details</a>
					<button type="button" class="btn btn-outline-danger">&#9825;</button>';
				} else {
					echo '
						<a onclick="movieSelected('${movie.imdbID}')" class="btn btn-primary movieCardBtn" href="#">Movie Details</a>';
				}
				?>
				</div>
			</div>