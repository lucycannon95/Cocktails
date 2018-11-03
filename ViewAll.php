<?php 

// Connecting to database 
$serverName = "tcp:cocktails.database.windows.net,1433";
$connectionInfo = array( "Database"=>"Cocktails", "UID"=>"jsb13146", "PWD"=>"Orange123");
$conn = sqlsrv_connect( $serverName, $connectionInfo );

if ($conn) 
{
	// Retrieve all cocktails from the database
	$query = sprintf("SELECT * from cocktails");
	$stmt = sqlsrv_query($conn, $query);
    if ($stmt === false) 
    {
        die(print_r(sqlsrv_errors(), true));
        
    }
    
    // Creating array to store cocktail names 
    $resultsArray = array(); 
    	
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
    	// Add each cocktail name to the array 
   		if(!in_array($row['name'], $resultsArray))
    	{
      	 $resultsArray[] = $row['name'];
		}   	 	
    }
}

?> 

<html>
<head>
<title>All Recipes</title>
  
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
<center><h1>All recipes </h1>


<?php 
// Sort array to ascending order
sort($resultsArray);
// Loop through each element in array, display as clickable links to each cocktail recipe, pass name value through href
foreach($resultsArray as $cocktail){  ?>
     <td><a href='Display.php?chosenCocktail=<?=$cocktail?> ' role="button" class="btn"><?php echo $cocktail;?></a></td><br>
  <?php  }   ?> 

</body> 
</html>
