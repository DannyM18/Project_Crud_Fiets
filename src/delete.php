<?php
// auteur: Vul hier je naam in
// functie: verwijder een fiets op basis van de id

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'config.php';

use ProjectCrudFiets\classes\Database;

// Haal fiets uit de database
if(isset($_GET['id'])){
    $db = new Database(SERVERNAME, USERNAME, PASSWORD, DATABASE);

    // test of verwijderen gelukt is
    if($db->delete($_GET['id']) == true){
        echo '<script>alert("Fietscode: ' . $_GET['id'] . ' is verwijderd")</script>';
        echo "<script> location.replace('index.php'); </script>";
    } else {
        echo '<script>alert("Fiets is NIET verwijderd")</script>';
    }
}
?>

