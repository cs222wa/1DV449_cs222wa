# Mashup Project 1DV449_cs222wa

##Initial Idea
The general idea of my project is to create an application which fetches tweets from twitter, based on a list of twitter accounts provided by the application user. The Twitter accounts in this project will be concentrated to the cast of a specific TV series called "Supernatural", for starters.
Once the tweets has been fetched the application user should be able to click on a specific hash-tag in the tweet and then the application will search Instagram
for the x number of recent posts posted with that specific hash-tag, displaying them on the page. If no images could be found, then an error message will be displayed.

If there is time the user should also be able to alter the list of twitter accounts (CRUD) to fetch from and also potentially be able to add more than one list, providing the user with the ability to switch between tweets belonging to the cast of several TV-shows or movies.

##Requirements
The application should
* Fetch and display the x most recent tweets of twitter user accounts, specified by list.
* Fetch and display the x most recent Instagram-posts corresponding with a specific hash-tag of a specific tweet. (alternately fetch all posts, using pagination to display x posts at a time.)
* Have a CRUD functionality for the list of specified twitter accounts and the posts therein. 

##Techniques.
The application will be written in PHP, using JavaScript, JSON and XML. 
Not that changes to this might occur since I still need to read up on the Instagram and Twitter API services.
