<?php 
session_start();
// Getting user's search term via cookie
$searchTerm = $_COOKIE['searchTerm'];

// Connecting to database
$serverName = "tcp:cocktails.database.windows.net,1433";
$connectionInfo = array( "Database"=>"Cocktails", "UID"=>"jsb13146", "PWD"=>"Orange123");
$conn = sqlsrv_connect( $serverName, $connectionInfo );

if ($conn) 
{
	// Getting cocktail from database that matches user search exactly 
	$exactMatchQuery = sprintf("SELECT * from cocktails WHERE name = '$searchTerm'");
	$stmt1 = sqlsrv_query($conn, $exactMatchQuery);
	
    if ($stmt1 === false) 
    {
        die(print_r(sqlsrv_errors(), true));
    }  
    
    // Creating array to store all results
    $resultsArray = array(); 
    
    // Adding results to array	
    while ($row = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)) 
    {	
   	 	if(!in_array($row['name'], $resultsArray))
    {
       $resultsArray[] = $row['name'];
	} 	 	
    }
    
    // Retrieve row from database if it matches the users search, without taking white space into account
    $noSpaceQuery = sprintf("SELECT * from cocktails WHERE REPLACE(name, ' ', '') = '$searchTerm'");
	$stmtSpace = sqlsrv_query($conn, $noSpaceQuery);
	
    if ($stmtSpace === false) 
    {
        die(print_r(sqlsrv_errors(), true));
    } 
    
 	// Add results to array
    while ($row = sqlsrv_fetch_array($stmtSpace, SQLSRV_FETCH_ASSOC)) 
    {
   	 	if(!in_array($row['name'], $resultsArray))
    {
       $resultsArray[] = $row['name'];
	}
    }
    
    // Retrieving any rows from database that sound like the users search, also taking away white space from the
    // users search and from the database cocktail names
    $soundsLikeQuery = sprintf("SELECT * from cocktails WHERE SOUNDEX(REPLACE(name, ' ', '')) =
    SOUNDEX(REPLACE('$searchTerm', ' ', ''))");
	$stmtSound = sqlsrv_query($conn, $soundsLikeQuery);
    if ($stmtSound === false) 
    {
        die(print_r(sqlsrv_errors(), true));   
    } 
    
 	// Adding results to array
    while ($row = sqlsrv_fetch_array($stmtSound, SQLSRV_FETCH_ASSOC)) 
    {
   	 	if(!in_array($row['name'], $resultsArray))
    {
       $resultsArray[] = $row['name'];
	} 	
    }
    
    // Check if the user's search is contained anywhere within the cocktail names in database (cosmo = cosmopolitan) 
    $containsQuery = sprintf("SELECT * FROM cocktails WHERE CHARINDEX('$searchTerm', name) > 0");
    $stmtContains = sqlsrv_query($conn, $containsQuery);
    if ($stmtContains === false) 
    {
        die(print_r(sqlsrv_errors(), true)); 
    } 
    
    // Add results to array
    while ($row = sqlsrv_fetch_array($stmtContains, SQLSRV_FETCH_ASSOC)) 
    {
    if(!in_array($row['name'], $resultsArray))
    {
       $resultsArray[] = $row['name'];
	}
    }   

}

?> 

<html>
<head>
<title>Search Results</title>
  
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
<center><h1>Search Results </h1>

<div>
<?php 
// Displaying message for no results 
if (empty($resultsArray)) 
{
    echo "No results found, please search again!"; 
}
else
{
// Displaying all results in a clickable link that takes user to recipe page for chosen cocktail
foreach($resultsArray as $cocktail)
	{  
      ?> 
     <td><a href='Display.php?chosenCocktail=<?=$cocktail?> ' role="button" class="btn"><?php echo $cocktail;?></a></td><br>
  <?php 
	}
}  ?>
</div>
</body> 

</html>

