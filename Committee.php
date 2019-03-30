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
    $temp = "\n"

?>


<!DOCTYPE html>
<html>
<head>

    <a href="Home Page.php">Home</a>
    <link rel="stylesheet" href="Committee.css" />
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <title> Committees </title>
</head>
<body>

<form method='GET'>
    <select name="committee-input" onchange="this.form.submit()"> 
        <option> -- Select Sub-Comittee -- </option>
        <?php 
            $sql = "SELECT subcommittee_name FROM organizing_committee";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach($data as $row){
                echo "<option>" . $row['subcommittee_name'] . "</option>"; 
            }
        ?>
    </select>     
</form>

<table>
    <tr>
        <th> Committee Name</th>
        <th> Member Name</th>
    </tr>
    <?php 
    if (isset($_GET['committee-input'])){
        $subcommittee_name = $_GET['committee-input'];
        $temp = $subcommittee_name;
        $sql2 = "SELECT subcommittee_name, first_name, last_name FROM subcommittee_members WHERE subcommittee_name='$subcommittee_name'";
        $stmt2 = $db->prepare($sql2);
        $stmt2->execute();
        $data2 = $stmt2->fetchAll();
        foreach($data2 as $row){
            echo "<tr>";
            echo "<td>" . $row['subcommittee_name'] . "</td>";
            echo "<td> " . $row['first_name']. " " . $row['last_name']  .  "</td>";
            echo "</tr>";
        }
        
        echo $temp;
    }
    ?>
</table>
</body>

</html>


