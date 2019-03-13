<!DOCTYPE html>


<?php
    function echoName(){
        if(isset($_GET['nameInput'])){
            echo $_GET["nameInput"];
        };
    }; 
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="./homepage.css">
    <title> Test Page </title>
</head>
<body>
    <h1> Simple page</h1>
    <p class="styledPHP">
        <?php 
            $firstVar = 23;
            echo "The first variable I've ever declared: $firstVar " ;
        ?>
    </p>
    <form method="GET">  
        <p> Name </p>
        <input type="text" name="nameInput"/>
        <input type="submit"/>

    </form>
    
</body>
</html>

<?php 
    echoName()
?>
