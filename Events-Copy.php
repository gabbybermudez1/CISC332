<!DOCTYPE html> 
<html>
<head>
    <link rel="stylesheet" href="Events.css" />
    <link rel="stylesheet" href="./tingle/src/tingle.css">

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
                    echo "<td> <span id='event$eventID'>" . $row['session']."</span> <a onclick='editHandler($eventID)'><img src='./assets/edit_icon.png' style='height:10%;width:10%;margin-left:10px;'/> </a></td>";
                    echo "<td> " . $row['start_t'] ."</td>";
                    echo "<td> " . $row['end_t'] ."</td>";
                    echo "</tr>";
                    $eventID++;
                };
            }
            catch(PDOException $e){
                echo "<h1 class='error-message'>Connection to the database failed: " . $e->getMessage() . "</h1>";
            }
            ?>
        </table>
    </div>

</body>
</html>

<!-- PHP code for the form inside the modal-->
<?php 

// helper function that allows us to split the name of a user
function splitName($fullName){
    $nameArray = preg_split("~\s~",$fullName);
    return $nameArray;
}

if(isset($_POST["event-changes"])){

    //variables named the same way they are in the database
    $session = $_POST['session-input'];
    $session_day = "Day ". $_POST['day-input'];
    $start_t =date("h:i:s" , strtotime($_POST['start-time-input']));
    $end_t = date("h:i:s" , strtotime($_POST['end-time-input']));
    $speaker_first = splitName($_POST['name-input'])[0];
    $speaker_last = splitName($_POST['name-input'])[1];
  
    // code containing error handling 
    if( ($session_day != "Day 1" and $session_day != "Day 2" ) or (!isset($speaker_last) ) ) {
        echo "You've entered invalid information. Nothing was updated in the database. Please try again";
    
    }
    else{
        $editSql = "UPDATE sessions SET  session='$session', session_day='$session_day', start_t='$start_t', end_t='$end_t', speaker_first='$speaker_first',speaker_last='$speaker_last'  WHERE session='$session'";
    
        try{
            $stmt = $db->prepare($editSql);
            $stmt->execute();
            echo "sql successfully sent!!!!!!";
        }
        catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
        $db = null;
    }
}

?>

<script src="./tingle/src/tingle.js"></script>
<script>
let modalContent = `
                <form class="modal-form" method="POST"> 
                <div class='modal-content'>
                        <h3 style='align-self:center;'> Edit Event</h3>
                        <label> Speaker Name (First and Last) </label>
                        <input type="text" name="name-input"  />
                        <label> Session </label>
                        <input type="text" id="session-editor" name="session-input" />
                        <label> Day </label>
                        <input type="text" name="day-input" />
                        <label> Start Time </label>
                        <input type="text" name="start-time-input"  />
                        <label> End Time </label>
                        <input type="text"  name="end-time-input"/>
                        <input type=submit name="event-changes" class='submit-form' style='display:none;'/>
                </div>
                </form>
                `;

// instanciate new modal
var formModal = new tingle.modal({
    footer: true,
    stickyFooter: false,
    closeMethods: ['overlay', 'button', 'escape'],
    closeLabel: "Close",
    cssClass: ['custom-class-1', 'custom-class-2'],
    onOpen: function() {
        console.log('modal open');
    },
    onClose: function() {
        console.log('modal closed');
    },
    beforeClose: function() {
        // here's goes some logic
        // e.g. save content before closing the modal
        return true; // close the modal
        return false; // nothing happens
    }
});

formModal.addFooterBtn('Submit', 'tingle-btn tingle-btn--primary', function() {
    document.querySelector('.submit-form').click();
});

// set content
formModal.setContent(modalContent);

const editHandler = (eventID) =>{
    var sessionEditor = document.querySelector('#session-editor');
    formModal.open();
    sessionEditor.value = document.querySelector("#event" + eventID).innerHTML;
}

</script> 

