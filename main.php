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
            echo $record['breed'].str_repeat('&nbsp;', 10).$record['gender'];
            echo "<br>";
        }
    }
    else if ($animal == 'dog')
        {
        foreach($dogs as $record)
        {
            echo $record['name'].str_repeat('&nbsp;', 8-strlen($record['name'])).$record['breed'].str_repeat('&nbsp;', 10).$record['gender'].str_repeat('&nbsp;', 10).$record['age'];
            echo "<br>";
        }
        echo "<hr> <br>";
    }
    else if ($animal == 'cat')
        {
        foreach($cats as $record)
        {
            echo $record['name'].str_repeat('&nbsp;', 8-strlen($record['name'])).$record['breed'].str_repeat('&nbsp;', 10).$record['gender'].str_repeat('&nbsp;', 10).$record['age'];
            echo "<br>";
        }
        echo "<hr> <br>";
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title> Pet Store </title>
    </head>
    <body>
        <h1>
            Pets
        </h1>
        <br>
        <form>
            <input type = 'radio'>
        <h1>Dogs</h1>
        <?=printOut(dog)?>
        <h1>Cats</h1>
        <?=printOut(cat)?>
        <h1>Fish</h1>
        <?=printOut(fish)?>
        
        
        </form>
    </body>
</html>