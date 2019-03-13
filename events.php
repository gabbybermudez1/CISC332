<!DOCTYPE html> 
<html>
<head>
    <link rel="stylesheet" href="events.css" />
    <title> Events </title>
</head>

<body>
    
    <form> 
        <label> Day1 </label>
        <input type="submit"  name="day1" method="GET"/>
    </form>
    <form> 
        <label> Day 2 </label>
        <input type="submit"  name="day2" method="GET"/>
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
        $day = null;
        $sql = "SELECT * FROM SESSIONS";

        // if either day1 or day2 was selected
        if ( isset($_GET["day1"]) or isset($_GET["day2"]) ){ 
            if(isset($_GET["day1"])){
                $sql = $sql. " WHERE session_day='Day 1'";
                echo $sql;
            }
            // if day 1 was not selected, but something is set,  then it is day 2 
            else{
                $sql = $sql. " WHERE session_day='Day 2'";
                echo $sql;
            };

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
        }
        ?>
    </table>
</body>
</html>
