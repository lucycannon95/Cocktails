<?php 
session_start();

// Checking to see if session variable is set to find out if it came from feeling lucky or normal search
if(isset($_SESSION["luckyCocktail"])) 
{
// Setting variable to the session variable sent from feeling lucky
$cocktailName  = $_SESSION["luckyCocktail"];

// unsetting the session variable again
unset($_SESSION['luckyCocktail']);
}

else 
{
// Setting to the variable sent from search results as this is the other possible method
$cocktailName  = $_GET['chosenCocktail'];
} 

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
    
</head>
<body>

<?php

// Connecting to database
$serverName = "tcp:cocktails.database.windows.net,1433";
$connectionInfo = array( "Database"=>"Cocktails", "UID"=>"jsb13146", "PWD"=>"Orange123");
$conn = sqlsrv_connect( $serverName, $connectionInfo );

if ($conn) 
{
    // Retrieving the row from the database that contains the chosen cocktail 
    $query = sprintf("SELECT * from cocktails where name = '$cocktailName'");
    $stmt = sqlsrv_query($conn, $query);
    
    if ($stmt === false) 
    {
        die(print_r(sqlsrv_errors(), true));
    }

   while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
    	// Getting exact title from database 
    	$title = $row['name'];
    	// Seperating the ingredient elements from database by comma, putting in array
    	$ingredients = $row['ingredients'];
    	$newIngredients = explode(',', $ingredients);
    	
    	// Seperating the instruction steps from database by fullstop, putting in array
    	$instructions = $row['instructions'];
    	$newInstructions = explode('.', $instructions);
		
		
		?> 
		<center><h2> <?php echo $title; ?> </h2></center> <br>
		<center><h3> You will need: </h3> <?php
		// Printing each ingredient element 
		foreach($newIngredients as $item) {
   		?>  <center><p class = 'display' ><?php echo $item; ?></p>  <?php
   		 
    }
       
        ?> <br> <h3> Method: </h3> <?php 
        // Printing each instruction step
        foreach($newInstructions as $item) {
   		?>  <center><p class = 'display' ><?php echo $item; ?> </p> <?php
   		 
    } 
    }

    sqlsrv_free_stmt($stmt);
}

?> 
</body>
</html>