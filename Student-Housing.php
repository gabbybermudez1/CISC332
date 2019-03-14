<?php
    $servername = "localhost";
    $username = "root";
    $conn = new PDO("mysql:host=$servername;dbname=conference_db", $username, "");
    $sql="select room_number from rooms";
    $rm = null;
    try {
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $rows=$stmt->fetchAll();
    }
    catch(Exception $e){
        echo "Connection failed: " . $e->getMessage();
        die;
    }
    if(isset($_POST['rm_num'])){
        $rm = $_POST['rm_num'];
        echo "The room number chosen is: $rm";
    }
?>


<!DOCTYPE html>
<html>
<!-- Student Housing -->
    <head>
        <title> Student Housing </title>
    </head>
    <form method = "post">
    <body>
        <h1> Student Housing </h1>
        <!--$rm = $_POST['room_number'];?>-->
        <select name = 'rm_num' id = 'rm_num' onchange = "this.form.submit();">
        <!--<input type="submit" name = "submit" value = "Get selected value"/>   -->
            <option> -- Select Room Number -- </option>
            <?php 
                foreach ($rows as $output) {
                    echo " <option> " . $output["room_number"] . " </option> ";
                };
            ?>    
            </select>
        <table>
            <tr> 
                <th> Room </th> 
                <th> Students </th> 
            </tr>
            <?php 
            if(isset($_POST['rm_num'])){
                $sql2="select * from students where room_number = '$rm'";
                try {
                    $stmt2=$conn->prepare($sql2);
                    $stmt2->execute();
                    $rows2=$stmt2->fetchAll();
                    foreach ($rows2 as $output){
                        echo "<tr>";
                        echo "<td> lol </td> ";
                        echo " <td>  lol</td>";
                        echo "</tr>";
                    }
                }
                catch(Exception $e){
                    echo "Connection failed: " . $e->getMessage();
                    die;
                } 
            }
            ?>
        
        <table>
        
    </body>
    </form>

</html>


