<?php
    $servername = "localhost";
    $username = "root";
    $conn = new PDO("mysql:host=$servername;dbname=conference_db", $username, "");
    $sql="select distinct company from jobs";
    $temp = "-- Select Company --";
    $company = "";
    try {
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $rows=$stmt->fetchAll();
    }
    catch(Exception $e){
        echo "Connection failed: " . $e->getMessage();
        die;
    }
    if(isset($_POST['company'])){
        $company = $_POST['company'];
        $temp = $company;
    }
?>


<!DOCTYPE html>
<html>
<!-- Jobs -->
    <head>
        <title> Jobs </title>
    </head>    
    <a href="Home Page.php">Home</a>
    
    <form method = "post">
    
    <body>
        <h1> Jobs </h1>
          
        <select name = 'company' id = 'company' onchange = "this.form.submit();">
            
            <?php
            //echo "<option>". $temp ."</option>";
            echo $company;
            echo "<option> -- Select Company -- </option>";
            echo "<option> All </option>";
                foreach ($rows as $output) {
                    echo " <option> " . $output['company'] . " </option> ";
                };
            ?>    
            </select>
        <table>
            <?php echo "<caption>". $company. " Jobs </caption>";?>
            <tr> 
                <th> Title </th>  
                <th> Pay </th> 
                <th> Location </th>
                <th> Company </th>
            </tr>
            
            <?php 
            $sql2="select * from jobs";
            if(isset($_POST['company'])){
                if ($company != "All"){
                    $sql2 = $sql2. " where company = '$company'";
                }                
            
            }
            
            try {
                $stmt2=$conn->prepare($sql2);
                $stmt2->execute();
                $rows2=$stmt2->fetchAll();
                foreach ($rows2 as $output){
                   
                    echo "<tr>";
                    echo "<td> ".  $output['title']. " </td> ";                        
                    echo "<td> ".  $output['pay']. " </td> ";                        
                    echo "<td> ".  $output['location'] . " </td> ";
                    echo "<td> ".  $output['company'] . " </td> ";
                    
                    echo "</tr>";
                }
            }
            catch(Exception $e){
                echo "Connection failed: " . $e->getMessage();
                die;
            } 
        
            ?>
        
        <table>
        
    </body>
    </form>

</html>


