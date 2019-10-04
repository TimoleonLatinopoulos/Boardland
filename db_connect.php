<?php

// Connect to database
//$servername = "localhost";
//$username = "root";
//$password = "";
//$dbname = "pspi";
$servername = "webpagesdb.it.auth.gr";
$username = "timoleon";
$password = "Pe2u%u70";
$dbname = "tic-jar-toe";
$conn = @mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    echo '<p>Database error <br>';  
    echo 'Error code: ' . mysqli_connect_errno() . '<br>'; 
    echo 'The error was: ' . mysqli_connect_error() . '<br>'; 
    echo 'Please try again.</p>';
    exit(); 
}
mysqli_query($conn,"SET NAMES 'utf8'");
mysqli_query($conn,"SET CHARACTER SET 'utf8'");


?>
