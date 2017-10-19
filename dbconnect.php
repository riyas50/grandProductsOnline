<?php

global $conn;

if (isset($conn))
    return;

//function dbConn() {
        $servername = "localhost";
        $username = "root";
        $password = '$$almoe$$';
        $dbname = "grandOnline";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        
/*         // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
 */
        if (mysqli_connect_errno())
        {
            die(sprintf("Connect failed: %s\n",mysqli_connect_errorno()));
        }

//        return $conn;
//}
?>