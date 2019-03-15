<?php
    $servername = "localhost";
    $username = "root";
    $conn = new PDO("mysql:host=$servername;dbname=conference_db", $username, "");
    $student="select count(id) as num from attendees where attendee_type = 'Student'";
    $pro = "select count(id) as num from attendees where attendee_type = 'Professional'";
    $sponsor="select count(id) as num from attendees where attendee_type = 'Sponsor'";
    try {
        $stmt=$conn->prepare($student);
        $stmt->execute();
        $numStudents=$stmt->fetchColumn(0);
        $stmt=$conn->prepare($pro);
        $stmt->execute();
        $numPros=$stmt->fetchColumn(0);
        $stmt=$conn->prepare($sponsor);
        $stmt->execute();
        $numSponsors=$stmt->fetchColumn(0);
    }
    catch(Exception $e){
        echo "Connection failed: " . $e->getMessage();
        die;
    }
?>

<!DOCTYPE html>
<head>
        <title> Home </title>
</head>
<body>
        <h1> Student Housing </h1>

<?php
    echo "Students: ";
    echo $numStudents."<br>";
    
    echo "Pros: ";
    echo $numPros."<br>";

    echo "Sponsors: ";
    echo $numSponsors;
?>
</body>
</html>
