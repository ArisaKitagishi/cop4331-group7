<?php
	// COP 4331 Group 7
	// John Balbuza, Fernando Bilbao, Arisa Kitagishi, Imahd Khan, Susan Long,
	// Sarah Thompson, Jonathan White
	
	// Get file contents
	$inData = json_decode(file_get_contents('php://input'), true);

	// Take data from front-end
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

	// Database login
	$hostname = 'localhost';
	$databaseName = 'contactManager';
	$username = 'root';
	$password = 'contactmanager7';

	// Set up connection
	$conn = new mysqli($hostname, $username, $password, $databaseName);

	// Check for connection error
	if ($conn->connect_error)
	{
		error($conn->connect_error);
	}
	// Interact with database
	else
	{
 
		$check = "SELECT friendID, firstName, lastName, workNumber, homeNumber, mobileNumber, address1, address2, zip, email FROM Contacts";

		// Check if the info has made its way into the database.
		$result = $conn->query($check);
    
		// going through all rows to check if we already have the EXACT same contact
		if ($result->num_rows > 0)
   {
     while($row = $result->fetch_assoc()) 
     {
     if(	
         $id === $row["friendID"] &&
         (empty($firstName) ? (empty($firstName) === empty($row["firstName"])) : ($firstName === $row["firstName"])) &&
         (empty($lastName) ? (empty($lastName) === empty($row["lastName"])) : ($lastName === $row["lastName"])) &&
         (empty($workPhone) ? (empty($workPhone) === empty($row["workNumber"])) : ($workPhone === $row["workNumber"])) &&
         (empty($homePhone) ? (empty($homePhone) === empty($row["homeNumber"])) : ($homePhone === $row["homeNumber"])) &&
         (empty($cellPhone) ? (empty($cellPhone) === empty($row["mobileNumber"])) : ($cellPhone === $row["mobileNumber"])) &&
         (empty($address1) ? (empty($address1) === empty($row["address1"])) : ($address1 === $row["address1"])) &&
         (empty($address2) ? (empty($address2) === empty($row["address2"])) : ($address2 === $row["address2"])) &&
         (empty($zip) ? (empty($zip) === empty($row["zip"])) : ($zip === $row["zip"])) &&
         (empty($email) ? (empty($email) === empty($row["email"])) : ($email === $row["email"]))
        )
        {  
        	// Close connection
           $conn->close();
        }
     }
   }       
		// Create row in Contacts table
		$sql = "INSERT INTO Contacts (friendID, firstName, lastName, workNumber, homeNumber, mobileNumber, address1, address2, zip, email) VALUES
									   ('$id',
									    '$firstName',
										'$lastName',
										'$workPhone',
										'$homePhone',
										'$cellPhone',
										'$address1',
										'$address2',
										'$zip',
										'$email')";
		// Contact added
    	$resultCheck = "Added contact!";
		// Check if the info has made its way into the database.
		if($result = $conn->query($sql) != TRUE)
		{
    		$resultCheck = "Error"; 
			error("Insert Invalid");
		}

		// Close the connection
		$conn->close();
    
	}

	// Error functions
	function error ($err)
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
?>
