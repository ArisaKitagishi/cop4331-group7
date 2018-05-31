<?php
	// Get file contents
	$inData = json_decode(file_get_contents('php://input'), true);

	// Prepare variables to be filled.
	$id = 0;
	$firstName = "";
	$lastName = "";
 
	// Set up connection
	$hostname = 'localhost';
	$databaseName = 'contactManager';
	$username = 'root';
	$password = 'contactmanager7';

	$conn = new mysqli($hostname, $username, $password, $databaseName);

	// Check for connection error.
	if ($conn->connect_error)
	{
		error($conn->connect_error);
	}

	// Interact with database
	else
	{
		// Select row from User table associated with the user logging in
		$sql = "SELECT ID,firstName,lastName FROM Users where Username ='" . $inData["username"] . "' and Password ='" . $inData["password"] . "'";

		// Check if the info has made its way into the database.
		$result = $conn->query($sql);

		// If we have results
		if ($result->num_rows > 0)
		{
			// Fetch the associated information in the row.
			$row = $result->fetch_assoc();

			// Fill empty variables
			$firstName = $row["firstName"];
			$lastName = $row["lastName"];
			$id = $row["ID"];
		}
		else
		{
			// Query found nothing.
			error( "No Records Found" );
		}
		$conn->close();
	 }

	// Send empty error.
	// error("");

	// Return information to the front end
	 returnWithInfo($firstName, $lastName, $id);


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
