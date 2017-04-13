<?php

    session_start();
    function getDBConnection($dbname) {
    $host = "localhost";
    //$dbname = "tech_checkout";
    $username = "web_user";
    $password = "s3cr3t";
    
    try {
        //Creating database connection
        $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Setting Errorhandling to Exception
        $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    }
    catch (PDOException $e) {
        
        echo "<span class='errorMSG'>There was some problem connecting to the database! Error: $e</span>";
        exit();
        
    }
    
    return $dbConn;
    
}

    $conn = getDBConnection("pet_store");
    $dogSql = "SELECT * from dog where dogid = " . $_GET['dogid'];
    $catSql = "SELECT * from cat where catid = " . $_GET['catid'];
    $fishSql = "SELECT * from fish where fishid = " . $_GET['fishid'];


    if (isset($_GET['dogid']))
    {
        $statement = $conn->prepare($dogSql);
        $statement->execute();
        $dogs = $statement->fetch(PDO::FETCH_ASSOC); //dogs
        
        echo "<br><br><br><br><div id='wrapper'>";
        
        echo "<h1>Pet Information</h1><hr>";

        
        echo "<table class= 'speciesTable'>";
        echo "<tr>";
        echo "<td rowspan=6><img src='img/dogs/" . $dogs[dogid] . ".jpg' id= 'petIMG' alt='Adopted_Pet' /></td>";
        echo "<th>Name</th>";
        echo "<th>Breed</th>";
        echo "<th>Gender</th>";
        echo "<th>Age (Years)</th>";
        echo "<th>Color</th>";
        echo "<th> Description</th>";
        echo "</tr>";
        
        echo "<td>".$dogs['name']."</td> <td>".$dogs['breed']."</td> <td>".$dogs['gender']."</td> <td>".$dogs[age]."</td> <td>".$dogs['color']."</td> <td>".$dogs['description'];
    }
    else if (isset($_GET['catid']))
    {
        $statement = $conn->prepare($catSql);
        $statement->execute();
        $cats = $statement->fetch(PDO::FETCH_ASSOC); // cats
        
        echo "<br><br><br><br><div id='wrapper'>";
        echo "<h1>Pet Information</h1><hr>";

        echo "<table class= 'speciesTable'>";
        echo "<tr>";
        echo "<td rowspan=6><img src='img/cats/" . $cats[catid] . ".jpg' id= 'petIMG' alt='Adopted_Pet' /></td>";
        echo "<th>Name</th>";
        echo "<th>Breed</th>";
        echo "<th>Gender</th>";
        echo "<th>Age (Years)</th>";
        echo "<th>Color</th>";
        echo "<th> Description</th>";
        echo "</tr>";
        
        echo "<td>".$cats['name']."</td> <td>".$cats['breed']."</td> <td>".$cats['gender']."</td> <td>".$cats[age]."</td> <td>".$cats['color']."</td> <td>".$cats['description'];
    }
    else if (isset($_GET['fishid']))
    {
        $statement = $conn->prepare($fishSql);
        $statement->execute();
        $fishs = $statement->fetch(PDO::FETCH_ASSOC); // fish
        
        echo "<br><br><br><br><div id='wrapper'>";
        echo "<h1>Pet Information</h1><hr>";

        echo "<table class= 'speciesTable'>";
        echo "<tr>";
        echo "<td rowspan=6><img src='img/fishs/" . $fishs[fishid] . ".jpg' id= 'petIMG' alt='Adopted_Pet' /></td>";
        echo "<th>Breed</th>";
        echo "<th>Gender</th>";
        echo "<th>Color</th>";
        echo "<th> Description</th>";
        echo "</tr>";
        
        echo "<td>".$fishs['breed']."</td> <td>".$fishs['gender']."</td> <td>".$fishs['color']."</td> <td>".$fishs['description'];
    }
    echo "</div>";
    
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Description </title>
        <style>
            @import url("styles.css");
        </style>
    </head>
    <body>

    </body>
</html>