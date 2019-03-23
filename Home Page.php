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
<a href="Jobs.php">Jobs</a>
<a href="Companies.php">Companies</a>
<a href="Student-Housing.php">Student Housing</a>
<a href="Committee.php">Committees</a>

<body>
        <h1> Welcome </h1>

<?php
    echo "Number of students attending: ";
    echo $numStudents."<br>";
    
    echo "Number of professionals attending: ";
    echo $numPros."<br>";

    echo "Number of sponsors attending: ";
    echo $numSponsors;
?>
</body>
</html>
