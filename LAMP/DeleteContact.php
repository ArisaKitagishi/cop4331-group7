<?php
	// COP 4331 Group 7
	// John Balbuza, Fernando Bilbao, Arisa Kitagishi, Imahd Khan, Susan Long,
	// Sarah Thompson, Jonathan White
	$inData = getRequestInfo();


	// Get input data
	$id = $inData["userID"];
	$firstName = $inData["firstName"];
	$lastName = $inData["lastName"];
	$workPhone = $inData["workPhone"];
	$homePhone = $inData["homePhone"];
	$cellPhone = $inData["mobilePhone"];
	$address1 = $inData["address1"];
	$address2 = $inData["address2"];
	$zip = $inData["zip"];
	$email = $inData["email"];

	$hostname = 'localhost';
	$databaseName = 'contactManager';
	$username = 'root';
	$password = 'contactmanager7';

  	// Connect to database
	$conn = new mysqli($hostname, $username, $password, $databaseName);
	// Connection failed
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	// Connection succesful, delete the contacts now
	else
	{	
		// Delete from database
		$sql = "DELETE FROM Contacts WHERE friendID = '$id' AND firstName = '$firstName' AND lastName = '$lastName' AND workNumber = '$workPhone' AND homeNumber = '$homePhone' AND mobileNumber = '$cellPhone' AND address1 = '$address1' AND address2 = '$address2' AND zip = '$zip' AND email = '$email'";
		// Error, unable to delete
		if( $result = $conn->query($sql) != TRUE )
		{
			returnWithError( $conn->error );
		}
		// Close connection
		$conn->close();
	}

	// Error functions
	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}

	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

?>