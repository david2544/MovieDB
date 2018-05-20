
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
		if (checkAuth() == true) {
			$.each(movies, (index, movie) => {
				output += `
				<div class="card mb-3 col-md-3">
				<div class="well text-center">
				<img src="${movie.Poster}">
				<h5>${movie.Title}</h5>
				<a onclick="movieSelected('${movie.imdbID}')" class="btn btn-success movieCardBtn" href="#">Movie Details</a>
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
				<a onclick="movieSelected('${movie.imdbID}')" class="btn btn-default movieCardBtn" href="#">Movie Details</a>
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

// Getting the selected movie id and opening the movie.html view;
function movieSelected(id){
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
    var logged = (function() {
        var isLogged = null;
        $.ajax({
            'async': false,
            'global': false,
            'url': 'localhost:8888/function.php',
            'success': function(resp) {
                isLogged = (resp === "1");
            }
        });
        return isLogged;
    })();
    console.log(logged);
    return logged;
}