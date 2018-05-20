
// Getting input from search bar and calling the getMovies function.
$(document).ready(() => {
	$('#searchForm').on('submit', (e) => {
		let searchText = $('#searchText').val();
		getMovies(searchText);
		e.preventDefault();
	});
});

// Displaying all search results
function getMovies(searchText){
	// Making a request to OMDb api using axios and saving the response;
	axios.get('http://www.omdbapi.com?s='+ searchText+'&apikey=thewdb')
	.then((response) => {
		console.log(response);
		// Accessing the movie search results that were passed back from OBdb api
		let movies = response.data.Search;
		let output = '';
		// Iterating through each result and displaying it
		// console.log(checkAuth());
		if (checkAuth()) {
			$.each(movies, (index, movie) => {
				output += `
				<div class="card mb-3 col-md-3">
				<div class="well text-center">
				<img src="${movie.Poster}">
				<h5>${movie.Title}</h5>
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
				<div class="well text-center">
				<img src="${movie.Poster}">
				<h5>${movie.Title}</h5>
				<a onclick="movieSelected('${movie.imdbID}')" class="btn btn-primary movieCardBtn" href="#">Movie Details</a>
				</div>
				</div>`;
			});
		}
		$('#movies').html(output);
	})
	.catch((err) => {
		console.log(err);
	});
}

function getFavorites() {
	let moviesData = getFavoritesArray()
	let movies = JSON.parse(moviesData);
	//console.log(movies);
	//console.log(moviesData);
	if (checkAuth()) {
		let output = '';
		$.each(movies, (key, movie) => {
			axios.get('http://www.omdbapi.com?i='+movie.movieid+'&apikey=thewdb')
			.then((response) => {
				console.log(response);
				let movie = response.data;
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
				<a href="http://imdb.com/title/${movie.imdbID}" target="_blank" class="btn btn-primary">View IMDB</a>
				<a href="index.php" class="btn btn-outline-info">Go Back To Search</a>
				<button type="button" class="btn btn-outline-danger">&#x1f494;</button>
				</div>
				</div>
				</div>
				`;
				$('#favoriteMovies').html(output);
			});
		})

	} else {
		console.log('user not logged in');
		// TODO , redirect to register.
	}
}

// Getting the selected movie id and opening the movie.html view;
function movieSelected(id) {
	sessionStorage.setItem('movieId', id);
	window.location = 'movie.php';
	return false;
}

// Displaying information about the user selected movie 
function getMovie(){
	// Making a request to OMDb api using axios and saving the response to get the selected movie information;
	let movieId = sessionStorage.getItem('movieId');
	axios.get('http://www.omdbapi.com?i='+movieId+'&apikey=thewdb')
	// Displaying info about the selected movie in the movie.html view
	.then((response) => {
		console.log(response);
		let movie = response.data;
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
	})
	.catch((err) => {
		console.log(err);
	});
}

function checkAuth() {
	var isLogged;
	// console.log('BeforeAjax');
	// console.log(isLogged);
	$.ajax({ 
		url: 'isUserLoggedIn.php',
		data: {action: 'test'},
		type: 'post',
		dataType: "text", 
		async: false,
		success: function(result) {
			// console.log(result);
			if (result == 'true') {
				console.log('user logged in');
				isLogged = true;
			} else {
				console.log('user not logged in');
				isLogged = false;
			}
		}
	}); 
	 // console.log('AfterAjax');
	 // console.log(isLogged);
	 return isLogged;
	//console.log(logged);
}

function getFavoritesArray () {
	let isLogged;
	$.ajax({ 
		url: 'getFavoritesArray.php',
		type: 'post',
		dataType: "text", 
		async: false,
		success: function(result) {
			//console.log(result);
			isLogged = result;
		}
	}); 
	return isLogged;
}

function addFavorite(id) {
	favoredItem = id;
	console.log(favoredItem);
	let isLogged;
	$.ajax({ 
		url: 'addToFavorites.php',
		data: {movieId: favoredItem},
		type: 'post',
		dataType: "text", 
		async: false,
		success: function(result) {
			if (result == 'true') {
				console.log('added to favorites');
				isLogged = true;
			} else {
				console.log('already a favorite');
				isLogged = false;
			}
		}
	}); 
}
