<?php 
session_start();

// Retrieve search term from user via cookie 
$cocktailCookie = $_COOKIE['cocktailCookie'];

// Connecting to database
$serverName = "tcp:cocktails.database.windows.net,1433";
$connectionInfo = array( "Database"=>"Cocktails", "UID"=>"jsb13146", "PWD"=>"Orange123");
$conn = sqlsrv_connect( $serverName, $connectionInfo );

 if ($conn) 
{	// Retrieve row from database if the user types in exact match for a cocktail name
	$exactMatchQuery = sprintf("SELECT * from cocktails WHERE name = '$cocktailCookie'");
	$stmt1 = sqlsrv_query($conn, $exactMatchQuery);
	
    if ($stmt1 === false) 
    {
        die(print_r(sqlsrv_errors(), true));
    } 
    
    // Creating array to store any possible results for feeling lucky
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
    $noSpaceQuery = sprintf("SELECT * from cocktails WHERE REPLACE(name, ' ', '') = '$cocktailCookie'");
	$stmtSpace = sqlsrv_query($conn, $noSpaceQuery);
    if ($stmtSpace === false) 
    {
        die(print_r(sqlsrv_errors(), true));
        
    } 
    
 	// Adding results to array 
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
    SOUNDEX(REPLACE('$cocktailCookie', ' ', ''))");
	$stmtSound = sqlsrv_query($conn, $soundsLikeQuery);
    if ($stmtSound === false) 
    {
        die(print_r(sqlsrv_errors(), true));
    } 
    
 	// Adding any resuls to array 
    while ($row = sqlsrv_fetch_array($stmtSound, SQLSRV_FETCH_ASSOC)) 
    {
   	 	if(!in_array($row['name'], $resultsArray))
    {
       $resultsArray[] = $row['name'];
	}
    }
    
    // Check if the user's search is contained anywhere within the cocktail names in database (cosmo = cosmopolitan) 
    $containsQuery = sprintf("SELECT * FROM cocktails WHERE CHARINDEX('$cocktailCookie', name) > 0");
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
    
    // Set a session variable to the first element of the results array to display 'top result'
    $_SESSION['luckyCocktail'] = $resultsArray[0];  
    
}
	// Redirect page to the display recipe page
	header("Location: Display.php");
   	exit;
?> 









