<!-- Boilerplate code that we can copy and paste for multiple projects -->
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="Events.css" />
    <title> Title </title>
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
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

$db = null;
?>