<?php
	// COP 4331 Group 7
	// John Balbuza, Fernando Bilbao, Arisa Kitagishi, Imahd Khan, Susan Long,
	// Sarah Thompson, Jonathan White
	
	// Start session
    session_start();

	// Get file contents
	$inData = json_decode(file_get_contents('php://input'), true);

	// Prepare variables to be filled.
	$id = 0;
	$firstName = "";
	$lastName = "";

	// To send messages
	$msg = "";
 
	// Set up connection
	$hostname = 'localhost';
	$databaseName = 'contactManager';
	$username = 'root';
	$password = 'contactmanager7';

	// Connect to database
	$conn = new mysqli($hostname, $username, $password, $databaseName);

	// Check for connection error.
	if ($conn->connect_error)
	{
		error($conn->connect_error);
	}


	// Interact with database
	else
	{
		// Get username and password from passed in JSON
		$username = $inData['username'];
		$password = $inData['password'];

		// Write sql select statement
		$sql = "SELECT ID, firstName, lastName, password FROM Users where username = '$username'";

		// Perform query and check if the info has made its way into the database.
		$result = $conn->query($sql);

		// If we have results
		if ($result->num_rows > 0)
		{
			// Fetch the associated information in the row.
			$row = $result->fetch_assoc();
			if(password_verify($password, $row['password']))
            {
                $_SESSION['u_id'] = $row['ID'];
				        $_SESSION['u_first'] = $row['firstName'];
				        $_SESSION['u_last'] = $row['lastName'];
				        $_SESSION['u_username'] = $row['username'];
				        $_SESSION['u_pass'] = $row['password'];
                // Fill empty variables
                $firstName = $row["firstName"];
                $lastName = $row["lastName"];
                $id = $row["ID"];
            }
		}
		else
		{
			// Query found nothing.
			error( "No Records Found" );
		}
		$conn->close();
	 }

	// Return information to the front end
	returnWithInfo($firstName, $lastName, $id);

	// Error functions
	function error( $err )
	{
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo( $firstName, $lastName, $id )
	{
     	$retValue = '{"id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""}';
     	sendResultInfoAsJson( $retValue );
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
?>
