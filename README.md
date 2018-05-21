# Welcome to MovieDB

### Project built for CS50 final challenge
###### (ctrl/cmd + click to open in a new tab)
[CS50 Final project description](https://docs.cs50.net/2018/x/project/project.html)

### Instructions to run my project:
###### (ctrl/cmd + click to open in a new tab)
* Just follow this link: [MovieDB](https://safe-forest-75535.herokuapp.com/index.php)

### It's all hosted on heroku so you don't have to set anything up. But if you really want to run it locally:
###### (can't promise that it will work)
* Clone my repo in a folder of your wish
```
git clone https://github.com/davidcoroian/MovieDB.git
```
* Make sure you have php installed: `php -v`
* Navigate to the folder `cd MovieDB` 
* Run server on localhost: 
```
php -S localhost:8888
```

Visit `localhost:8888/index.php` in your browser and realize it doens't work yet.(you will see the error message on the top of the page) Since it's connected to a Postgres Db from heroku, you wont be able to access it!

To get it working, you should set up a database on your local machine, change the db credentials in my code and create two tables in your new database:

* one table called users which will have 4 columns: `id` as primary key, and `username`, `email`, `password` of type `text`;
* one table called favorites which will have 3 columns: `id` as primary key, and `username` and `movieid` of type text.

######Once you are connected to your local db and you set up the tables, you should be up and running!


#### I also made a short video that walks you through the website.
[Link to youtube video](https://www.youtube.com/watch?v=a6w_m5bdSqQ&t)

