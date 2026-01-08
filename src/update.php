<?php
    // functie: update fiets
    // auteur: Vul hier je naam in

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once 'config.php';

    use ProjectCrudFiets\classes\Database;
    use ProjectCrudFiets\classes\Fiets;

    $db = new Database(SERVERNAME, USERNAME, PASSWORD, DATABASE);

    // Test of er op de wijzig-knop is gedrukt 
    if(isset($_POST['btn_wzg'])){
        // Maak een Fiets object met de gewijzigde gegevens
        $fiets = new Fiets($_POST['merk'], $_POST['type'], $_POST['prijs'], $_POST['id']);

        // test of update gelukt is
        if($db->update($fiets)){
            echo "<script>alert('Fiets is gewijzigd')</script>";
        } else {
            echo '<script>alert("Fiets is NIET gewijzigd")</script>';
        }
    }

    // Test of id is meegegeven in de URL
    if(isset($_GET['id'])){  
        // Haal alle info van de betreffende id $_GET['id']
        $id = $_GET['id'];
        $fiets = $db->getById($id);
        
        if ($fiets === null) {
            echo "Fiets niet gevonden<br>";
            exit;
        }
    } else {
        echo "Geen id opgegeven<br>";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Wijzig Fiets</title>
</head>
<body>
  <h2>Wijzig Fiets</h2>
  <form method="post">
    
    <input type="hidden" id="id" name="id" required value="<?php echo $fiets->getId(); ?>"><br>
    <label for="merk">Merk:</label>
    <input type="text" id="merk" name="merk" required value="<?php echo htmlspecialchars($fiets->getMerk()); ?>"><br>

    <label for="type">Type:</label>
    <input type="text" id="type" name="type" required value="<?php echo htmlspecialchars($fiets->getType()); ?>"><br>

    <label for="prijs">Prijs:</label>
    <input type="number" id="prijs" name="prijs" required value="<?php echo $fiets->getPrijs(); ?>"><br>

    <button type="submit" name="btn_wzg">Wijzig</button>
  </form>
  <br><br>
  <a href='index.php'>Home</a>
</body>
</html>

