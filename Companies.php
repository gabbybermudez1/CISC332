<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="Companies.css" />
    <link rel="stylesheet" href="./tingle/src/tingle.css">
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
                $errorMessage = $e->getMessage();
                echo "<script>var connectionFailed = true;</script>";
            }

            $db = null;
        ?>
    </table>

</body>



</html>


<script src="./tingle/src/tingle.js">
</script>

<script>

console.log(connectionFailed);


var modal = new tingle.modal({
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

// set content
modal.setContent('<h1>We encountered an error</h1>');

// add a button
modal.addFooterBtn('Button label', 'tingle-btn tingle-btn--primary', function() {
    // here goes some logic
    modal.close();
});

// add another button
modal.addFooterBtn('Dangerous action !', 'tingle-btn tingle-btn--danger', function() {
    // here goes some logic
// modal.close();
});

// // open modal
// modal.open();
if(connectionFailed){
    modal.open()
}
</script>



