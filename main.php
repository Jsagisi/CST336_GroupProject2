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
$dogSql = "SELECT * from dog";
$catSql = "SELECT * from cat";
$fishSql = "SELECT * from fish";




    if (isset($_GET['alpha'])){
        $dogSql = $dogSql . " ORDER BY ";
        $catSql = $catSql . " ORDER BY ";
        $fishSql = $fishSql . " ORDER BY ";
        if($_GET['alpha'] =='gender'){
            $dogSql.= "gender";
            $catSql.= "gender";
            $fishSql.= "gender";
        }
        else{
             $dogSql.="breed";
             $catSql.="breed";
             $fishSql.="breed";
        }
        if(isset($_GET['age']))
        {
            $dogSql.= ", age";
            $catSql.= ", age";
        }
    }
    else
    {
        $dogSql = $dogSql . " ORDER BY ";
        $catSql = $catSql . " ORDER BY ";
        if(isset($_GET['age']))
        {
            $dogSql.= " age";
            $catSql.= " age";
        }
        
    }
    
   
    //  else{
    //      $dogSql.="ORDER BY breed";
    //      $catSql.="ORDER BY breed";
    //      $fishSql.="ORDER BY breed";
    //  }



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
    global $dogs, $cats, $fishs, $conn;
    
   
 
     
    if ($animal == 'fish')
    {
        echo "<table class= 'speciesTable'>";
        echo "<tr>";
        echo "<th>Species</th>";
        echo "<th>Gender</th>";
        echo "</tr>";
        foreach($fishs as $record)
        {
            echo "<tr>";
            $petId = "fish_".$record['fishid'];
            
            echo "<form action='cart.php'>";
           
           echo "<td> <a href='description.php?fishid=" . $record['fishid'] . "'>". $record['breed']."</td><td>".$record['gender']."</td>"; 
           echo "<td>";
            echo "<input type='hidden' name='petId' value='".$petId."'>";                
            echo "<input type='submit' value='Add to Cart'>";
            echo "</form>";
            echo "</td>";
            
            echo "</tr>";
        }
        echo "</table>";
    }
    else if ($animal == 'dog')
        {
        echo "<table class= 'speciesTable'>";
        echo "<tr>";
        echo "<th>Name</th>";
        echo "<th>Breed</th>";
        echo "<th>Gender</th>";
        echo "<th>Age (Years)</th>";
        echo "</tr>";
        foreach($dogs as $record)
        {
            echo "<tr>";
            $petId = "dog_".$record['dogid'];
            
            echo "<form action='cart.php'>";
            
            echo "<td> <a href='description.php?dogid=" . $record['dogid'] . "'>" .$record['name']."</a></td><td>".$record['breed']."</td><td>".$record['gender']."</td><td>".$record['age']."</td>";
            
            echo "<td>";
            echo "<input type='hidden' name='petId' value='".$petId."'>";                
            echo "<input type='submit' value='Add to Cart'>";
            echo "</form>";
            echo "</td>";
            
            echo "</tr>";
        }
        echo "</table><hr></br>";
    }
    else if ($animal == 'cat')
        {
        echo "<table class= 'speciesTable'>";
        echo "<tr>";
        echo "<th>Name</th>";
        echo "<th>Breed</th>";
        echo "<th>Gender</th>";
        echo "<th>Age (Years)</th>";
        echo "</tr>";
        foreach($cats as $record)
        {
            echo "<tr>";
            $petId = "cat_".$record['catid'];
            
            echo "<form action='cart.php'>";

            echo "<td> <a href='description.php?catid=" . $record['catid'] . "'>".$record['name']."</td><td>".$record['breed']."</td><td>".$record['gender']."</td><td>".$record['age']."</td>";
            
            echo "<td>";
            echo "<input type='hidden' name='petId' value='".$petId."'>";                
            echo "<input type='submit' value='Add to Cart'>";
            echo "</form>";
            echo "</td>";
            
            echo "</tr>";
        }
        echo "</table><hr> </br>";
    }

}



?>
<!DOCTYPE html>
<html>
    <head>
        <title> Animal Shelter </title>
    </head>
    
         <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
     
    <style> @import url("styles.css") </style>
    
    <body>
        <div id= "wrapper">
        <h1>
            Pet Adoption
        </h1>
        <hr>
        
        <form action="cart.php">
            <input type="submit" value="Adoption Cart" class= "cartButton">
        </form>
            
            </br>
        <form>
            <br><br>
            Search: <input type = "text" name="breed"/>
            <input type ="submit" value="Search" />
            <br><br>
            Sort: <input type = "radio"name="alpha" id="alpha" value="breed"/>
            <label for="alpha" > Alphabetical</label>
            <input type="radio" name="alpha" id="gender" value = "gender"/>
            <label for="gender"> Gender</label>
            <input type="checkbox" name="age" id="age"/>
            <label for="age"> Age </label>
            <input type ="submit" value="Go" />
        </form>
        
        <h2>Dogs</h2>
        <?=printOut(dog)?>
        <h2>Cats</h2>
        <?=printOut(cat)?>
        <h2>Fish</h2>
        <?=printOut(fish)?>
        </div>
    </body>
</html>