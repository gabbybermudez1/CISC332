<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="Companies.css" />
    <title> Companies </title>
</head>
<body>
    <h1>List of Companies </h1>
    <table>
        <tr>
            <th> Company Name</th>
            <th> Rank </th>
        </tr> 
        <?php 
            $servername = "localhost";
            $databaseName = "conference_db";
            $username = "root";

            // Set up a connection to the mysql database
            try{
                $db = new PDO("mysql:host=$servername;dbname=$databaseName", $username);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT * FROM companies ORDER BY company";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $data  = $stmt->fetchAll();
                foreach($data as $row){
                    echo "<tr><form method='GET'>";
                    echo "<td><a name='company-name' onclick='this.form.submit()' href='Company.php?company=" . $row['company'] . "'>" . $row["company"] ."</a></td>";
                    echo "<td>" . $row["sponsor_rank"] . "</td>";
                    echo "</form></tr>";
                }
                
            }
            catch(PDOException $e){
                echo "Connection failed: " . $e->getMessage();
            }

            $db = null;
        ?>
    </table>

</body>



</html>


