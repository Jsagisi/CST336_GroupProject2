<?php

session_start();

$host = "localhost";
    $dbname = "pet_store";
    $username = "web_user";
    $password = "s3cr3t";

    try{
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    }
    catch (PDOException $e) {
        echo "<span class='errorMSG'>There was some problem connecting to the database! Error: $e</span>";
        exit();
    }

function addPet(){
    global $conn;
    $petId = $_GET['petId'];
    
    if(!isset($_SESSION['shopCart'])){
        $_SESSION['shopCart']=array();
    }
    else{
        foreach($_SESSION['shopCart'] as $key => $value) {
            if($value==$petId){
                echo "<span class='errorMSG'>Error: You cannot adopt the same animal twice!</span></br></br>";
                return;
            }
        }
    }

        $pieces= explode("_", $petId);
        $type=$pieces[0];
        $id=$pieces[1];
    
        if($type== "dog"){
            $sql = "SELECT * from dog WHERE dogid= :id";
        }
        else if($type== "cat"){
            $sql = "SELECT * from cat WHERE catid= :id";
        }
        else if($type== "fish"){
            $sql = "SELECT * from fish WHERE fishid= :id";
        }

    $namedParameters[':id'] = $id;
    $statement = $conn->prepare($sql);
    $statement->execute($namedParameters);
    $record = $statement->fetch(PDO::FETCH_ASSOC);
    
    $_SESSION['shopCart'][]= $petId;
    
    if($type=="dog" || $type=="cat"){
        echo $record['name'] ." the ";
    }
    echo $record['breed'] ." has successfully been added to your cart!</br>";
}

function printCart(){
    global $conn;

    if(!isset($_SESSION['shopCart'])){
        echo "</br>Your shopping cart is empty!</br></br>";
    }
    
    foreach($_SESSION['shopCart'] as $key => $value) {
        //echo $value . '<br />';
        $pieces= explode("_", $value);
        $type=$pieces[0];
        $id=$pieces[1];

        if($type== "dog"){
            $sql = "SELECT * from dog WHERE dogid= :id";
            $rowHeight=6;
        }
        else if($type== "cat"){
            $sql = "SELECT * from cat WHERE catid= :id";
            $rowHeight=6;
        }
        else if($type== "fish"){
            $sql = "SELECT * from fish WHERE fishid= :id";
            $rowHeight=4;
        }

    $namedParameters[':id'] = $id;
    $statement = $conn->prepare($sql);
    $statement->execute($namedParameters);
    $record = $statement->fetch(PDO::FETCH_ASSOC);
    
    echo "<table id= 'cartTable'>";
    $selectedPet= $record['breed'];
    
    $types= $type."s";
    
    echo "<tr>";
    echo "<td rowspan='$rowHeight'><img src='img/$types/$id.jpg' id= 'petIMG' alt='Adopted_Pet' /></td>";

    if($type=="dog" || $type=="cat"){
        echo "<td><strong>Name: </strong></td><td>". $record['name'] ."</td></tr> ";
        echo "<tr><td><strong>Breed: </strong></td><td>" . $selectedPet . "</td></tr>";
        echo "<tr><td><strong>Age: </strong></td><td>" . $record['age'] . " year-old</td></tr>";
    }
    else{
        echo "<tr><td><strong>Species: </strong></td><td>" . $selectedPet . "</td></tr>";
    }
    
    echo "<tr><td><strong>Gender: </strong></td><td>";
    if ($record['gender']== 'M'){
        echo "Male";
    }
    else{
        echo "Female";
    }
    echo "</td></tr>";
    echo "<tr><td><strong>Coloring: </strong></td><td>" . $record['color'] . "</td></tr>";
    echo "</table></br>";
}
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Shopping Cart </title>
    </head>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
     
    <style> @import url("styles.css"); </style>
    
    <body>
        <div id= "wrapper">
        <h1>Adoption Cart</h1>
        <hr>
        <?php 
        //echo $_GET['petId'];
            if(isset($_GET['petId'])){
                addPet();
            }
            
            printCart();
        ?>
        
        <form action="main.php" >
            <input type="submit" value="Back to Main" class= "backButton"/>
        </form>
        </br></br>
        </div>
    </body>
</html>