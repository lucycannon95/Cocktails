<html>

<head>

  <title>Mystery cocktail</title>
  
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
    // Retrieve all rows from database
    $queryCount = sprintf("SELECT * from cocktails");
    $stmtCount = sqlsrv_query($conn, $queryCount);
    
    if ($stmtCount === false) 
    {
        die(print_r(sqlsrv_errors(), true));
        
    }
    
    // Counting all of the rows in databae
    while ($row = sqlsrv_fetch_array($stmtCount, SQLSRV_FETCH_ASSOC)) 
    {
   		$count = $count + 1; 
    }
    
    // Setting min and max values for random function 
     $min = 1; 
     $max = $count;
      
     // getting random number between 1 and total number of cocktails in database 
     $random = rand($min, $max);
    
    // Retrieving random cocktail from database using the ID 
    $query = sprintf("SELECT * from cocktails where id = '$random'");
    $stmt = sqlsrv_query($conn, $query);
    
    if ($stmt === false) 
    {
        die(print_r(sqlsrv_errors(), true));
        
    }
    
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
    	$cocktailName = $row['name'];
    	?> <center><h2> <?php echo $cocktailName; ?> </h2></center> <br>
    	<?php
    	// Seperating ingredients by comma and adding to array
    	$ingredients = $row['ingredients'];
    	$newIngredients = explode(',', $ingredients);
    	
    	// Seperating instructions by fullstop and adding to array
    	$instructions = $row['instructions'];
    	$newInstructions = explode('.', $instructions);
		
		
		?> 
		
		<center><h3>You will need: </h3> <?php
		// Printing out ingredients 
		foreach($newIngredients as $item) {
   		?>  <center><p class = 'display'><?php  echo $item; ?> </p> <?php
   		 
    }
       
        ?> <br> <h3> Method: </h3>  <?php 
        // Printing out instructions
        foreach($newInstructions as $item) {
   		?>  <center><p class = 'display'><?php echo $item; ?> </p><?php
   		 
    }    
    }

    sqlsrv_free_stmt($stmt);
}
?> 
</body>
</html>