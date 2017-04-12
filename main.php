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
        
        echo "There was some problem connecting to the database! Error: $e";
        exit();
        
    }
    
    return $dbConn;
    
}

$conn = getDBConnection("pet_store");
$dogSql = "SELECT * from dog";
$catSql = "SELECT * from cat";
$fishSql = "SELECT * from fish";

$statement = $conn->prepare($dogSql);
$statement->execute();
$dogs = $statement->fetchAll(PDO::FETCH_ASSOC); //dogs

$statement = $conn->prepare($catSql);
$statement->execute();
$cats = $statement->fetchAll(PDO::FETCH_ASSOC); // cats

$statement = $conn->prepare($fishSql);
$statement->execute();
$fishs = $statement->fetchAll(PDO::FETCH_ASSOC); // fish

//print_r($records);

function printOut($animal)
{
    global $dogs, $cats, $fishs;
    if ($animal == 'fish')
    {
        foreach($fishs as $record)
        {
            $petId = "fish_".$record['fishid'];
            
            echo "<form action='cart.php'>";
           
            echo $record['breed'].str_repeat('&nbsp;', 10).$record['gender'].str_repeat('&nbsp;', 10); 
           
            echo "<input type='hidden' name='petId' value='".$petId."'>";                
            echo "<input type='submit' value='Add to Cart'>";
            echo "</form>";
            
            echo "</br>";
        }
    }
    else if ($animal == 'dog')
        {
        foreach($dogs as $record)
        {
            $petId = "dog_".$record['dogid'];
            
            echo "<form action='cart.php'>";
            
            echo $record['name'].str_repeat('&nbsp;', 8-strlen($record['name'])).$record['breed'].str_repeat('&nbsp;', 10).$record['gender'].str_repeat('&nbsp;', 10).$record['age'].str_repeat('&nbsp;', 10);
            
            echo "<input type='hidden' name='petId' value='".$petId."'>";                
            echo "<input type='submit' value='Add to Cart'>";
            echo "</form>";
            
            echo "</br>";
        }
        echo "<hr> </br>";
    }
    else if ($animal == 'cat')
        {
        foreach($cats as $record)
        {
            $petId = "cat_".$record['catid'];
            
            echo "<form action='cart.php'>";

            echo $record['name'].str_repeat('&nbsp;', 8-strlen($record['name'])).$record['breed'].str_repeat('&nbsp;', 10).$record['gender'].str_repeat('&nbsp;', 10).$record['age'].str_repeat('&nbsp;', 10);
            
            echo "<input type='hidden' name='petId' value='".$petId."'>";                
            echo "<input type='submit' value='Add to Cart'>";
            echo "</form>";
            
            echo "</br>";
        }
        echo "<hr> </br>";
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title> Animal Shelter </title>
    </head>
    <body>
        <h1>
            Pets
        </h1>
        
        <form action="cart.php">
            <input type="submit" value="Adoption Cart">
        </form>
            
            </br>
        <form>
            <input type = 'radio'>
        </form>
        
        <h2>Dogs</h2>
        <?=printOut(dog)?>
        <h2>Cats</h2>
        <?=printOut(cat)?>
        <h2>Fish</h2>
        <?=printOut(fish)?>
        
    </body>
</html>