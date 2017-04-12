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
        echo "There was some problem connecting to the database! Error: $e";
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
                echo "You cannot adopt the same animal twice!</br></br>";
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
    
    $selectedPet= $record['breed'];
    echo "<img width= '220px' src='img/$selectedPet.jpg' id= 'pet' alt='Adopted_Pet' /></br>";
    
    if($type=="dog" || $type=="cat"){
        echo "<strong>Name: </strong>". $record['name'] ."</br> ";
        echo "<strong>Breed: </strong>" . $selectedPet . "</br>";
        echo "<strong>Age: </strong>" . $record['age'] . " years old</br>";
    }
    else{
        echo "<strong>Species: </strong>" . $selectedPet . "</br>";
    }
    
    echo "<strong>Gender: </strong>";
    if ($record['gender']== 'M'){
        echo "Male </br> ";
    }
    else{
        echo "Female </br> ";
    }
    echo "<strong>Coloring: </strong>" . $record['color'] . "</br></br>";
}
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Shopping Cart </title>
    </head>
    <body>
        <h1>Adoption Cart</h1>
        
        <?php 
        //echo $_GET['petId'];
            if(isset($_GET['petId'])){
                addPet();
            }
            
            printCart();
        ?>

        <form action="main.php" >
            <input type="submit" value="Back to Main" />
        </form>
    </body>
</html>