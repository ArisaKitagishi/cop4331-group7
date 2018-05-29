<?php
    // Get file contents.
    $inData = json_decode(file_get_contents('php://input'), true);

    // Take data from front end
    $firstName = $inData["firstName"];
    $lastName = $inData["lastName"];
    $username = $inData["username"];
    $password = $inData["password"];

    // Set up connection
    $hostname = 'localhost';
    $databaseName = 'contactManager';
    $databaseUsername = 'root';
    $databasePassword = 'contactManager7';

    $conn = new mysqli($hostname, $databaseUsername, $databasePassword, $databaseName);

    // Check for connection error
    if ($conn->connect_error)
    {
        error($conn->connect_error);
    }
    // Interact with database
    else
    {
        $sql = "SELECT FROM Users WHERE firstName = '$firstName' AND lastName = '$lastName' AND username = '$username' AND password = '$password'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            returnWithError("This username and password already exist");
        }
        else
        {
            // Create new row in User table.
            $sql = "INSERT INTO Users (firstName, lastName, username, password)VALUES
                       ('$firstName',
                        '$lastName',
                        '$username',
                        '$password')";

            // Check if info made it into the database
            $sql = "SELECT ID FROM Users WHERE
                                        firstName = '$firstName' AND
                                        lastName = '$lastName' AND
                                        username = '$userUsername' AND
                                        password = '$userPassword'";

            $result = $conn->query($sql);

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
