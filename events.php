<!DOCTYPE html> 
<html>
<head>
    <link rel="stylesheet" href="Events.css" />
    <title> Events </title>
</head>

<body>
    <div class="tab_container"> 
        <form method="POST"> 
            <label> Day 1 </label>
            <input type="submit"  name="day1" />
        </form>
        <form method="POST"> 
            <label> Day 2 </label>
            <input type="submit"  name="day2" />
        </form>
    </div>
    <div class="events_table">
        <table > 
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
                // echo $sql;
            }

            else{
                $sql = $sql. " WHERE session_day='Day 1'";
                // echo $sql;
            }
            try{
                $db = new PDO("mysql:host=$servername;dbname=$databaseName", $username);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // query all data and return it 
                $data = $db->query($sql)->fetchAll();
                $eventID = 0;
                foreach($data as $row){
                    echo "<tr>";
                    echo "<td>". $row['speaker_first']. " " . $row['speaker_last'] . "</td>";
                    echo "<td> <span id='event$eventID'>" . $row['session']."</span> <button onClick=editHandler($eventID)> Edit Event</button> </td>";
                    echo "<td> " . $row['start_t'] ."</td>";
                    echo "<td> " . $row['end_t'] ."</td>";
                    echo "</tr>";
                    $eventID++;
                };
            }
            catch(PDOException $e){
                    echo "Connection failed: " . $e->getMessage();
            }
            // end connection
            $db = null;
            ?>
        </table>
    </div>

    <!-- Code for the modal. This is invisible til they get edited -->

    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3> Edit Event</h3>
            <form class="modal-form"> 
                <label> Session </label>
                <input type="text" id="sessionEditor" />
                <label> Day </label>
                <input type="text"  />
                <label> Start Time </label>
                <input type="text"  />
                <label> End Time </label>
                <input type="text"  />
            </form>
        </div>
    </div>

</body>
</html>


<script>
var modal = document.getElementById('myModal');
var sessionEditor = document.querySelector('#sessionEditor');
var closeModal = document.getElementsByClassName("close")[0]; 


editHandler = (eventID) =>{
    console.log("The event selected is: " + eventID);
    modal.style.display = "flex";
    sessionEditor.value = document.querySelector("#event" + eventID).innerHTML;    
};

closeModal.onclick = function() {
  modal.style.display = "none";
}

</script> 

