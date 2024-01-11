<?php

$database = "u516712768_linkorto";
$username = "u516712768_admin";
$password = "0#umNLzl&qoR";
$host     = "193.203.166.111";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Your SQL query and further code here...

// Close the connection
$conn->close();
?>