<?php
    // functie: formulier en database insert fiets
    // auteur: Vul hier je naam in

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once 'config.php';

    use ProjectCrudFiets\classes\Database;
    use ProjectCrudFiets\classes\Fiets;

    $db = new Database(SERVERNAME, USERNAME, PASSWORD, DATABASE);

    // Test of er op de insert-knop is gedrukt 
    if(isset($_POST) && isset($_POST['btn_ins'])){
        // Maak een nieuw Fiets object
        $fiets = new Fiets($_POST['merk'], $_POST['type'], $_POST['prijs']);

        // test of insert gelukt is
        if($db->insert($fiets)){
            echo "<script>alert('Fiets is toegevoegd')</script>";
        } else {
            echo "<script>alert('Fiets is NIET toegevoegd')</script>";
        }
    }
?>

<h1>Insert Fiets</h1>
<html>
    <body>
        <form method="post">

        <label for="merk">Merk:</label>
        <input type="text" id="merk" name="merk" required><br>

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" required><br>

        <label for="prijs">Prijs:</label>
        <input type="number" id="prijs" name="prijs" required><br>

        <button type="submit" name="btn_ins">Insert</button>
        </form>
        
        <br><br>
        <a href='index.php'>Home</a>
    </body>
</html>
