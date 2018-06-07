<?php
	// COP 4331 Group 7
	// John Balbuza, Fernando Bilbao, Arisa Kitagishi, Imahd Khan, Susan Long,
	// Sarah Thompson, Jonathan White
	
	// Get file contents
	$inData = json_decode(file_get_contents('php://input'), true);
  
	// Set up variables to be filled.
	$searchResults = "";
	$searchCount = 0;

  // Take data from front end
	$searchItem = $inData["search"];
  $userId = $inData["userId"];
  //echo var_dump($inData);

	// Set up connection
	$hostname = 'localhost';
	$databaseName = 'contactManager';
	$username = 'root';
	$password = 'contactmanager7';

	$conn = new mysqli($hostname, $username, $password, $databaseName);

	// Check for connection error.
	if($conn->connect_error)
	{
		error( $conn->connect_error );
	}
	// Interact with database
	else
	{
		// Search
    	$searchfirstName = "SELECT * FROM Contacts WHERE 
      	((firstName LIKE '%" . $searchItem . "%') OR
      	(lastName LIKE '%" . $searchItem . "%') OR 
      	(workNumber LIKE '%" . $searchItem . "%') OR
      	(homeNumber LIKE '%" . $searchItem . "%') OR
      	(mobileNumber LIKE '%" . $searchItem . "%') OR
      	(address1 LIKE '%" . $searchItem . "%')  OR
      	(address2 LIKE '%" . $searchItem . "%') OR
      	(zip LIKE '%" . $searchItem . "%') OR
      	(email LIKE '%" . $searchItem . "%'))
      	AND friendID=" . intval($userId) . "
    	";
		$searchlastName = "SELECT lastName FROM Contacts WHERE lastName LIKE '%" . $searchItem . "%'";

		$firstNameResult = $conn->query($searchfirstName);
		$lastNameResult = $conn->query($searchlastName);

    	$retArray = array();
    
		// Check and display first name results.
		if($firstNameResult->num_rows > 0)
		{
			// Fetch the information from the row.
			while($row = $firstNameResult->fetch_assoc())
			{
				// Increment the number of rows that have been found.
				$searchCount++;
				// Tack on the first name in that row to the search results.
				$arr = array(
          		"firstName" => $row["firstName"],
          		"lastName" => $row["lastName"],
          		"workPhone" => $row["workNumber"],
          		"homePhone" => $row["homeNumber"],
          		"mobilePhone" => $row["mobileNumber"],
          		"address1" => $row["address1"],
          		"address2" => $row["address2"],
          		"zip" => $row["zip"],
          		"email" => $row["email"]
        );
        $retArray[] = $arr;
			}
		}
   
    // Encode search results as JSON
    $searchResults = json_encode($retArray);
    // Close the connection
	$conn->close();
	}

	// Return the info found.
  	sendResultInfoAsJson($searchResults);

  	// Error functions
	function error( $err )
	{
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo( $searchResults )
	{
		$retValue = '{"results":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson( $retValue );
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
?>
