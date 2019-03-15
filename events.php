<!DOCTYPE html> 
<html>
<head>
    <link rel="stylesheet" href="events.css" />
    <title> Events </title>
</head>

<body>
    <form method="POST"> 
        <label> Day 1 </label>
        <input type="submit"  name="day1" />
    </form>
    <form method="POST"> 
        <label> Day 2 </label>
        <input type="submit"  name="day2" />
    </form>
    <table> 
        <tr> 
            <th> Speaker </th>
            <th> Session Name</th>
            <th> Start Time </th>
            <th> End Time </th>
        </tr>
        <?php 
        // Set up a connection to the mysql database
        $databaseName = "conference_db";
        $username = "root";
        $servername = "localhost";
        $sql = "SELECT * FROM SESSIONS";

        // if either day1 or day2 was selected
        if (isset($_POST["day2"]) ){ 
            $sql = $sql. " WHERE session_day='Day 2'";
            echo $sql;
        }

        else{
            $sql = $sql. " WHERE session_day='Day 1'";
            echo $sql;
        }
        try{
            $db = new PDO("mysql:host=$servername;dbname=$databaseName", $username);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // query all data and return it 
            $data = $db->query($sql)->fetchAll();
            foreach($data as $row){
                echo "<tr>";
                echo "<td>". $row['speaker_first']. " " . $row['speaker_last'] . "</td>";
                echo "<td> " . $row['session']."</td>";
                echo "<td> " . $row['start_t'] ."</td>";
                echo "<td> " . $row['end_t'] ."</td>";
                echo "</tr>";
            };
        }
        catch(PDOException $e){
                echo "Connection failed: " . $e->getMessage();
        }
        // end connection
        $db = null;
        ?>
    </table>
</body>
</html>
