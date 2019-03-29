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

$company = $_GET['company'];

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="Company.css" />
    <title> Company </title>
</head>
<body>
<div class="body-container" > 
    <a href="Home Page.php">Home</a>
    <h2> <?php echo $company; ?></h2>   
    <a href="Companies.php">Back to List of companies</a>
    <h4> Available Positions </h4>
    <table>
        <tr>
            <th> Job Title </th>
            <th> Location </th>
            <th> Salary </th>
        </tr>
    <?php 
        if (isset($_GET['company'])){
            $sql = "SELECT * from jobs WHERE company='$company'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row){
                echo "<tr>";
                echo "<td> ".  $row['title'] . " </td>";
                echo "<td> ".  $row['location'] . " </td>";
                echo "<td> " . $row['pay'] . " </td>";
                echo "</tr>";
            }
        }

        else{
            echo "404 NOT FOUND";
        }
    ?>
    </table>

</div>
</body>


</html>
