<?php
    $servername = "localhost";
    $username = "root";
    $conn = new PDO("mysql:host=$servername;dbname=conference_db", $username, "");
   
    $attendees = $_GET['attendees'];
?>

<!DOCTYPE html>
<head>
        
        <a href="Home Page.php">Home</a>
</head>
<body>
    <?php 
        $servername = "localhost";
        $databaseName = "conference_db";
        $username = "root";

        // Set up a connection to the mysql database
        try{
            echo '<h1>'. 'All Attendees' .'</h1>';
            echo '<title>'. 'All Attendees'. '</title>';
            $db = new PDO("mysql:host=$servername;dbname=$databaseName", $username);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($attendees == "all"){
                $students = "SELECT * FROM attendees where attendee_type = 'Student'";
                $stmt = $db->prepare($students);
                $stmt->execute();
                $studentNames  = $stmt->fetchAll();
                
                $pros = "SELECT * FROM attendees where attendee_type = 'Professional'";
                $stmt = $db->prepare($pros);
                $stmt->execute();
                $proNames  = $stmt->fetchAll();
                
                $sponsors = "SELECT * FROM attendees where attendee_type = 'Sponsor'";
                $stmt = $db->prepare($sponsors);
                $stmt->execute();
                $sponsorNames  = $stmt->fetchAll();
                
                echo '<table>';
                echo '<th>'.'Sponsors'.'</th>';
                foreach($sponsorNames as $row){
                    echo "<tr>";
                    echo "<td> ".$row['first_name']." ".$row['last_name']."</td>";
                    echo "</tr>";
                }
                echo '</table>';
                echo '<br>';
                
                echo '<table>';
                echo '<th>'.'Professionals'.'</th>';
                foreach($proNames as $row){
                    echo "<tr>";
                    echo "<td> ".$row['first_name']." ".$row['last_name']."</td>";
                    echo "</tr>";
                }
                echo '</table>';
                echo '<br>';
                
                echo '<table>';
                echo '<th>'.'Students'.'</th>';
                foreach($studentNames as $row){
                    echo "<tr>";
                    echo "<td> ".$row['first_name']." ".$row['last_name']."</td>";
                    echo "</tr>";
                }
                echo '</table>';
                echo '<br>';
                
            }
            else{
                echo '<h1>'. $attendees .'</h1>';
                echo '<title>'. $attendees. '</title>';
                $sql = "SELECT * FROM attendees where attendee_type = '$attendees'";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $data  = $stmt->fetchAll();
                echo '<table>';
                echo '<th>'.'Name'.'</th>';
                foreach($data as $row){
                    echo "<tr>";
                    echo "<td> ".$row['first_name']." ".$row['last_name']."</td>";
                    echo "</tr>";
                }
                echo '</table>';
            }
        }
        catch(PDOException $e){
            $errorMessage = $e->getMessage();
            echo "<script>var connectionFailed = true;</script>";
        }

        $db = null;
    ?>

</body>
