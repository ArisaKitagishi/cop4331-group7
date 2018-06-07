<?php
	// COP 4331 Group 7
	// John Balbuza, Fernando Bilbao, Arisa Kitagishi, Imahd Khan, Susan Long,
	// Sarah Thompson, Jonathan White
	
    // Get file contents.
    $inData = json_decode(file_get_contents('php://input'), true);

    // Take data from front end
    $username = $inData["username"];
    $password = $inData["password"];
    $firstName = $inData["firstName"];
    $lastName = $inData["lastName"];

    // Set up connection
    $hostname = 'localhost';
    $databaseName = 'contactManager';
    $databaseUsername = 'root';
    $databasePassword = 'contactmanager7';

    // Get connection to server
    $conn = new mysqli($hostname, $databaseUsername, $databasePassword, $databaseName);

    // Check for connection error
    if ($conn->connect_error)
    {
        error($conn->connect_error);
    }
    //Interact with database
    else
    {
        // Hash the password
        $hash = password_hash($password, PASSWORD_DEFAULT);


        // Get info from database
        $sql = "SELECT FROM Users WHERE firstName = '$firstName' AND lastName = '$lastName' AND username = '$username' AND password = '$password'";

        $result = $conn->query($sql);

        // Check if username exists
        if ($result->num_rows > 0)
        {
            returnWithError("This username already exists!");
        }
        else
        {
            // Add to database
            $sql = "INSERT INTO Users (firstName, lastName, username, password) VALUES
                       ('$firstName',
                        '$lastName',
                        '$username',
                        '$hash')";

            $conn->query($sql);

    
            if ($result->num_rows > 0)
            {
                $id = $row["ID"];
            }
            else
            {
               error("Record not found");
            }
        }

        // Close connection.
        $conn->close();
     }

    // return
    returnWithInfo($firstName, $lastName, $id);
    // Send empty error.
    error("");


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

    function returnWithInfo( $firstName, $lastName, $id )
    {
        $retValue = '{"id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""}';
        sendResultInfoAsJson( $retValue );
    }
?>
