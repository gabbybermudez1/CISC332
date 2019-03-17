<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="Companies.css" />
    <title> Companies </title>
</head>
<body>

</body>



</html>


<?php 
$servername = "localhost";
$databaseName = "conference_db";
$username = "root";

// Set up a connection to the mysql database
try{
    $db = new PDO("mysql:host=$servername;dbname=$databaseName", $username);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
}
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

$db = null;
?>