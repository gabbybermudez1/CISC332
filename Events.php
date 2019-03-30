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

// Helper function
function splitName($fullName){
    $nameArray = preg_split("~\s~",$fullName);
    return $nameArray;
}
?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="Events.css" />
    <link rel="stylesheet" href="center.css" />
    <link rel="stylesheet" href="./tingle/src/tingle.css"/>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <title> Events </title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">CISC 332 Conference</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="Home Page.php">Home </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Jobs.php">Jobs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Companies.php">Companies</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Student-Housing.php">Student Housing</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Committee.php">Committee</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Events <span class="sr-only">(current)</span></a>
            </li>
            </ul>
        </div>
    </nav>
<div class='body-container' >
    <div class="tab-container"> 
        <form method="POST"> 
            <!-- <button class='btn btn-primary' onclick="day1Submit()"> Day 1 </button> -->
            <input type="submit"  class="day1" value="Day 1"  name="day1"/>
        </form>
        <form method="POST"> 
            <!-- <button class='btn btn-primary' onclick="console.log('hello');"> Day 2 </button> -->
            <input type="submit"  class="day2" value="Day 2" name="day2" />
        </form>
    </div>
    <?php 
        if (isset($_POST['event-changes'])){
            $session = $_POST['session-input'];
            $session_day = "Day ". $_POST['day-input'];
            $start_t =date("h:i:s" , strtotime($_POST['start-time-input']));
            $end_t = date("h:i:s" , strtotime($_POST['end-time-input']));
            $speaker_first = splitName($_POST['name-input'])[0];
            $speaker_last = splitName($_POST['name-input'])[1];

            if( ($session_day != "Day 1" and $session_day != "Day 2" ) or (!isset($speaker_last) ) ) {
                echo "You've entered invalid information. Nothing was updated in the database. Please try again";
            }

            else{
                $editSql = "UPDATE sessions SET  session='$session', session_day='$session_day', start_t='$start_t', end_t='$end_t', speaker_first='$speaker_first',speaker_last='$speaker_last'  WHERE session='$session'";
                $stmt2 = $db->prepare($editSql);
                $stmt2->execute();
            }
        }
    ?>
    <table class='table'>
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
        $stmt = $db->prepare($sql);
        $stmt->execute(); 
        $data = $stmt->fetchAll();
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
    ?>
    </table>
</div>
</body>

<script src="./tingle/src/tingle.js"></script>


<script>
let modalContent = `
                <form class="modal-form" name='modal-form' method="POST" action='Events.php'  > 
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
        return true; // close the modal
    }
});

formModal.addFooterBtn('Submit', 'tingle-btn tingle-btn--primary', function() {
    document.querySelector('.submit-form').click();
});

formModal.setContent(modalContent);

const editHandler = (eventID) =>{
    var sessionEditor = document.querySelector('#session-editor');
    formModal.open();
    sessionEditor.value = document.querySelector("#event" + eventID).innerHTML;
}


function day1Submit(){
    document.querySelector('.day1').click();
}



</script> 



</html>


