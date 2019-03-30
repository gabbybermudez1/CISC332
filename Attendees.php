<?php
    $servername = "localhost";
    $username = "root";
    $conn = new PDO("mysql:host=$servername;dbname=conference_db", $username, "");
   
    $attendees = $_GET['attendees'];
    
    function getRms($someArray){
        $newVar = "[";
        foreach($someArray as $rows){
            $newVar = $newVar . $rows['room_number'].", "; 
        }
        $newVar = $newVar . "]";
        return $newVar;
    }
?>

<!DOCTYPE html>
<head>
        <link rel="stylesheet" href="Companies.css"/>
        <link rel="stylesheet" href="./tingle/src/tingle.css"/>
        <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
        <a href="Home Page.php">Home</a>
</head>
<body>
    <?php 
        $servername = "localhost";
        $databaseName = "conference_db";
        $username = "root";

        // Set up a connection to the mysql database
        try{
            echo '<title>'. 'All Attendees'. '</title>';
            echo '<img src="./assets/add_icon.png" class = "add-icon" onclick = "formModal.open()">';
            $db = new PDO("mysql:host=$servername;dbname=$databaseName", $username);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($attendees == "all"){
                echo '<h1>'. 'All Attendees' .'</h1>';
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
                echo '<br>';
                echo '</table>';
                $rooms= "SELECT room_number FROM rooms where spots_taken<spots";
                $stmt = $db->prepare($rooms);
                $stmt->execute();
                $rmNum  = $stmt->fetchAll();
                $holdRms = getRms($rmNum);
                echo "<script> var rooms = " . $holdRms . "</script>";
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
</html>
<script src="./tingle/src/tingle.js"> 
</script>

<script>

var formModalContent =`
    <form method='POST' class='modal-form' action='Attendees.php'>
        <div class='modal-content'> 
            <h3 style='align-self:center;'> Edit Event</h3>
            <label> First Name </label>
            <input type="text" name="first"  />
            <label> Last Name </label>
            <input type="text" name="last"  />
            <label> Attendee </label>
            <select  name="attendee_type" onchange='changeHandler()' >
                <option> Sponsor </option>
                <option> Professional </option>
                <option> Student </option>
             </select>
             <div class='add-something'> </div>
            <input type='submit' class='submit-info' name='submit-info' style='display:none;'>
        </div>
    </form>
`

// Form modal 
var formModal = new tingle.modal({
    footer: true,
    stickyFooter: false,
    closeMethods: ['overlay', 'button', 'escape'],
    closeLabel: "Close",
    cssClass: ['custom-class-1', 'custom-class-2']
});
formModal.setContent(formModalContent);
formModal.addFooterBtn('Submit', 'tingle-btn tingle-btn--primary', function() {
    document.querySelector('.submit-info').click();
});


var errorModal = new tingle.modal({
    footer: true,
    stickyFooter: false,
    closeMethods: ['overlay', 'button', 'escape'],
    closeLabel: "Close",
    cssClass: ['custom-class-1', 'custom-class-2'],
});
errorModal.setContent('<h1>We encountered an error connecting to the database </h1>');
errorModal.addFooterBtn('Refresh', 'tingle-btn tingle-btn--danger', function() {
    location.reload();
});

if (typeof connectionFailed !== 'undefined'){
    if(connectionFailed){
    errorModal.open()
    }
}


if(typeof incorrectInput !== 'undefined'){
    if (incorrectInput){
        alert('You submitted incomplete or incorrect information. Your sql was not sent to the database');
     }

     else{
         alert("SQL successfully sent");
     }
}
function changeHandler(){
        
    if (event.target.value == "Student"){ 
         var newHTML = `<label> Room Number </label>
        <select>`
        for(var i=0; i < rooms.length ; i++){
            newHTML = newHTML + "<option>" + rooms[i] + "</option>"
        }
        newHTML = newHTML + "</select>"
        document.querySelector('.add-something').innerHTML = newHTML;
    }
    else {
        document.querySelector('.add-something').innerHTML = ""
    }
}


</script>

