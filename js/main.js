// ##############################################################
// #########     Start of code highly inspired from   ###########
// #########  https://github.com/bradtraversy/movieinfo  ########
// ##############################################################

// Getting input from search bar and calling the getMovies function.
$(document).ready(() => {
	$('#searchForm').on('submit', (e) => {
		let userTextInput = $('#userTextInput').val();
		getMovies(userTextInput);
		e.preventDefault();
	});
});

// Displaying all search results
function getMovies(userTextInput){
	// Making a request to OMDb api using axios and saving the response;
	axios.get('//www.omdbapi.com?s='+ userTextInput+'&apikey=thewdb')
	.then((response) => {
		// Accessing the movie search results that were passed back from OBdb api
		let movies = response.data.Search;
		let output = '';
		// Iterating through each result and displaying it 
		// We will display the content slightly different if the user is anonymous or logged in. If user is logged in,
		// buttons will have a different color and there will be a favorite button too.
		if (checkAuth()) {
			// Build the output
			$.each(movies, (index, movie) => {
				output += `
				<div class="card border-success mb-3 col-md-3">
				<div class="text-center movieCard">
				<h5 class="cardTitle">${movie.Title}</h5>
				<img src="${movie.Poster}">
				<a onclick="movieSelected('${movie.imdbID}')" class="btn btn-success movieCardBtn" href="#">Movie Details</a>
				<button type="button" onclick="addFavorite('${movie.imdbID}')" class="btn btn-outline-danger movieCardBtn" href="#">&#9825;</button>
				</div>
				</div>
				`;
			});
		} else {
			$.each(movies, (index, movie) => {
				output += `
				<div class="card mb-3 col-md-3">
				<div class="text-center">
				<h5 class="cardTitle">${movie.Title}</h5>
				<img src="${movie.Poster}">
				<a onclick="movieSelected('${movie.imdbID}')" class="btn btn-primary movieCardBtn" href="#">Movie Details</a>
				</div>
				</div>`;
			});
		}
		// Display the output
		$('#movies').html(output);
	})
}

function getFavorites() {
	// We call the getFavoritesArray which will return us an array of movies favored by the current user
	let moviesData = getFavoritesArray()
	let movies = JSON.parse(moviesData);
	// Checking if the user is logged in since we will display the content based on this.
	if (checkAuth()) {
		let output = '';
		/* For each of the movie Id inside the array we received from getFavoritesArray() we will use the OMDB api
		to get the data we need in order to display more information about each movie
		*/ 
		$.each(movies, (key, movie) => {
			axios.get('//www.omdbapi.com?i='+movie.movieid+'&apikey=thewdb')
			.then((response) => {
				console.log(response);
				let movie = response.data;
				// Building the output
				output += `
				<div class= "top-buffer card border-success">
				<div class="row">
				<div class="col-md-3">
				<img src="${movie.Poster}" class="thumbnail">
				</div>
				<div class="col-md-8">
				<h2>${movie.Title}</h2>
				<ul class="list-group">
				<li class="list-group-item"><strong>Genre:</strong> ${movie.Genre}</li>
				<li class="list-group-item"><strong>Released:</strong> ${movie.Released}</li>
				<li class="list-group-item"><strong>Rated:</strong> ${movie.Rated}</li>
				<li class="list-group-item"><strong>IMDB Rating:</strong> ${movie.imdbRating}</li>
				<li class="list-group-item"><strong>Director:</strong> ${movie.Director}</li>
				<li class="list-group-item"><strong>Writer:</strong> ${movie.Writer}</li>
				<li class="list-group-item"><strong>Actors:</strong> ${movie.Actors}</li>
				</ul>
				</div>
				</div>
				<div class="row">
				<div class="well">
				<h3>Plot</h3>
				${movie.Plot}
				<hr>
				<a href="http://imdb.com/title/${movie.imdbID}" target="_blank" class="btn btn-success">View IMDB</a>
				<a href="index.php" class="btn btn-outline-info">Go Back To Search</a>
				<button type="button" onclick="removeFavorite('${movie.imdbID}')" class="btn btn-outline-danger" href="#">&#x1f494;</button>
				</div>
				</div>
				</div>
				`;
				// Displaying the output
				$('#favoriteMovies').html(output);
			});
		})
	} else {
		console.log('user not logged in');
		window.location = 'register.php';
	}
}

// Getting the selected movie id and opening the movie.php view;
function movieSelected(id) {
	sessionStorage.setItem('movieId', id);
	window.location = 'movie.php';
	return false;
}

// Displaying information about the user selected movie 
function getMovie(){
	// Making a request to OMDb api using axios and saving the response to get the selected movie information;
	let movieId = sessionStorage.getItem('movieId');
	axios.get('//www.omdbapi.com?i='+movieId+'&apikey=thewdb')
	// Displaying info about the selected movie in the movie.php view 
	.then((response) => {
		let movie = response.data;
		// Here we check as well if the user is logged in or not and display content accordingly
		if (checkAuth()) {
			let output =`
			<div class="row favMovies">
			<div class="col-md-3">
			<img src="${movie.Poster}" class="thumbnail">
			</div>
			<div class="col-md-8">
			<h2>${movie.Title}</h2>
			<ul class="list-group">
			<li class="list-group-item"><strong>Genre:</strong> ${movie.Genre}</li>
			<li class="list-group-item"><strong>Released:</strong> ${movie.Released}</li>
			<li class="list-group-item"><strong>Rated:</strong> ${movie.Rated}</li>
			<li class="list-group-item"><strong>IMDB Rating:</strong> ${movie.imdbRating}</li>
			<li class="list-group-item"><strong>Director:</strong> ${movie.Director}</li>
			<li class="list-group-item"><strong>Writer:</strong> ${movie.Writer}</li>
			<li class="list-group-item"><strong>Actors:</strong> ${movie.Actors}</li>
			</ul>
			</div>
			</div>
			<div class="row">
			<div class="well">
			<h3>Plot</h3>
			${movie.Plot}
			<hr>
			<a href="http://imdb.com/title/${movie.imdbID}" target="_blank" class="btn btn-success">View IMDB</a>
			<a href="index.php" class="btn btn-outline-info">Go Back To Search</a>
			<button type="button" onclick="addFavorite('${movie.imdbID}')" class="btn btn-outline-danger" href="#">&#9825;</button>
			</div>
			</div>
			`;
			$('#movie').html(output);
		} else {
			let output =`
			<div class="row favMovies">
			<div class="col-md-3">
			<img src="${movie.Poster}" class="thumbnail">
			</div>
			<div class="col-md-8">
			<h2>${movie.Title}</h2>
			<ul class="list-group">
			<li class="list-group-item"><strong>Genre:</strong> ${movie.Genre}</li>
			<li class="list-group-item"><strong>Released:</strong> ${movie.Released}</li>
			<li class="list-group-item"><strong>Rated:</strong> ${movie.Rated}</li>
			<li class="list-group-item"><strong>IMDB Rating:</strong> ${movie.imdbRating}</li>
			<li class="list-group-item"><strong>Director:</strong> ${movie.Director}</li>
			<li class="list-group-item"><strong>Writer:</strong> ${movie.Writer}</li>
			<li class="list-group-item"><strong>Actors:</strong> ${movie.Actors}</li>
			</ul>
			</div>
			</div>
			<div class="row">
			<div class="well">
			<h3>Plot</h3>
			${movie.Plot}
			<hr>
			<a href="http://imdb.com/title/${movie.imdbID}" target="_blank" class="btn btn-primary">View IMDB</a>
			<a href="index.php" class="btn btn-default">Go Back To Search</a>
			</div>
			</div>
			`;
			$('#movie').html(output);
		}
	})
	.catch((err) => {
		console.log(err);
	});
}

// ##############################################################
// #########     End of code highly inspired from     ###########
// #########  https://github.com/bradtraversy/movieinfo  ########
// ##############################################################

//	This function will make a call using ajax to the server and get back a reply as TRUE (if the user is logged in)
//	or FALSE (if the user is not logged in). The content on most of the pages is rendered differently based 
//	on this. For example. we can't offer a favorite movie button if the user is not logged in because it
//	doesn't make sense.
function checkAuth() {
	var isLogged;
	$.ajax({ 
		url: 'isUserLoggedIn.php',
		data: {action: 'test'},
		type: 'post',
		dataType: "text", 
		async: false,
		success: function(result) {
			if (result == 'true') {
				isLogged = true;
			} else {
				isLogged = false;
			}
		}
	}); 
	return isLogged;
}

//	This function will call the server and will receive back an array which contains
//	all the movieId that have been saved as favorites by the user.
function getFavoritesArray () {
	let favArray;
	$.ajax({ 
		url: 'getFavoritesArray.php',
		type: 'post',
		dataType: "text", 
		async: false,
		success: function(result) {
			favArray = result;
		}
	}); 
	return favArray;
}

/* This function, receives a movieId after a user clicked the favorite button
	and sends it via ajax to the server where it will be added to the database.
	If the item was successfully added, the user will get a notification. However
	if the movie was already added to favorites before, the user will get a notification
	about this too. 
*/
function addFavorite(id) {
	favoredItem = id;
	let output = '';
	$('#favoredAlert').show();
	$.ajax({ 
		url: 'addToFavorites.php',
		data: {movieId: favoredItem},
		type: 'post',
		dataType: "text", 
		async: false,
		success: function(result) {
			if (result == 'true') {
				output = `
				<div class="alert alert-dismissible alert-danger sticky">
				Movie added to favorites!
				</div>`;
				$('#favoredAlert').html(output);
				alertDismiss();
				async function alertDismiss() {
					await sleep(2000);
					$('#favoredAlert').hide();
				}
			} else {
				output = `
				<div class="alert alert-dismissible alert-info sticky">
				Already a favorite movie!
				</div>`;
				$('#favoredAlert').html(output);
				alertDismiss();
				async function alertDismiss() {
					await sleep(2000);
					$('#favoredAlert').hide();
				}
			}
		}
	}); 
}

//	removeFavorite will get a movieId once the user clicks the unfavorite button for a movie 
//	from his list of favorite movies, and sends it to the server using ajax. On the server side,
//	the movie will be removed from the db and no longer be shown in the users favorite view.
//	Again, we receive a notification that the movie was successfully removed.
function removeFavorite (id) {
	movieId = id;
	$('#removedFavorite').show();
	$.ajax({ 
		url: 'removeFavorite.php',
		data: {movieId : movieId},
		type: 'post',
		dataType: "text", 
		async: false,
		success: function(result) {
			if (result == 'true') {
				output = `
				<div class="alert alert-dismissible alert-danger sticky">
				Movie removed from favorites. Refresh the page if you want to update the list.
				</div>`;
				$('#removedFavorite').html(output);
				alertDismiss();
				async function alertDismiss() {
					await sleep(2000);
					$('#removedFavorite').hide();
				}

			} else {
				output = `
				<div class="alert alert-dismissible alert-info sticky">
				Hmm, there was a problem somewhere.
				</div>`;
				$('#removedFavorite').html(output);
				alertDismiss();
				async function alertDismiss() {
					await sleep(2000);
					$('#removedFavorite').hide();
				}
			}
		}
	}); 
}

// ##############################################################
// #########     Following function taken from here   ###########
// #########    https://stackoverflow.com/a/39914235     ########
// ##############################################################
// Function used to hide alerts after 2 seconds.
function sleep(ms) {
	return new Promise(resolve => setTimeout(resolve, ms));
}