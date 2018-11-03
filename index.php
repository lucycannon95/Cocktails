<?php 
session_start();
$cocktailResults = $_SESSION['cocktailResults'];
?>
<html>


<head>

  <title>Cocktail recipes</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>

<center><h1> Cocktail Recipes</h1>

<script>
  function luckySearch()
  {
  	var cocktailName = document.getElementById('cocktailSearch').value; 
  	
  	if (document.getElementById('cocktailSearch').value === "")
  	{
  	alert("Please type something before searching!");
  	}
  	else{
  	document.cookie = "cocktailCookie="+cocktailName;
  
  	window.location.href = "FeelingLucky.php";
  	}

}
 function Search()
  {

	var cocktailName = document.getElementById('cocktailSearch').value; 
	if (document.getElementById('cocktailSearch').value === "")
  	{
  	alert("Please type something before searching!");
  	}
  	else{
	document.cookie = "searchTerm="+cocktailName;
 	window.location.href = "SearchResults.php";
 	}


}
  </script> 
<a href = 'ViewAll.php' id = 'browse'> Browse all recipes </a> <br><br>
<br><br><br><br><br><br><br>

<center>
<input type="text" name="name" id="cocktailSearch" placeholder='Search...' > 
<button type="button" class = 'buttons' id = "searchButton" onclick="Search()">
Search</button>
<button type="button" class = 'buttons' id = "luckyButton" onclick="luckySearch()">
I'm feeling lucky</button>

<br><br><br>
<br><br><br><br><br>
<p class = "randomText">
Or.. <br> 

<a href = 'Random.php' id = 'random'>  Choose a recipe for me! </a> <br><br>
</p>

</center>
</body>
</html> 
<?php

?> 