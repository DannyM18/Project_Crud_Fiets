    <!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php
    // functie: Programma CRUD fietsen
    // auteur: Vul hier je naam in   

    // Initialisatie
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once 'config.php';

    use ProjectCrudFiets\classes\Database;

    // Main
    $db = new Database(SERVERNAME, USERNAME, PASSWORD, DATABASE);
    $fietsen = $db->getAll();
    ?>
    <h1>Crud Fietsen</h1>
    <nav>
        <a href='insert.php'>Toevoegen nieuwe fiets</a>
    </nav><br>
    <?php
    // Print tabel
    printFietsenTable($fietsen);
    
    function printFietsenTable($fietsen) {
        if (empty($fietsen)) {
            echo "<p>Geen fietsen gevonden</p>";
            return;
        }

        $table = "<table>";
        
        // Header
        $headers = array_keys($fietsen[0]);
        $table .= "<tr>";
        foreach($headers as $header) {
            $table .= "<th>" . htmlspecialchars($header) . "</th>";   
        }
        $table .= "<th colspan=2>Actie</th>";
        $table .= "</tr>";

        // Rijen
        foreach ($fietsen as $row) {
            $table .= "<tr>";
            foreach ($row as $cell) {
                $table .= "<td>" . htmlspecialchars($cell) . "</td>";  
            }
            
            $table .= "<td>
                <form method='post' action='update.php?id=" . htmlspecialchars($row['id']) . "' >       
                    <button>Wijzig</button>	 
                </form></td>";

            $table .= "<td>
                <form method='post' action='delete.php?id=" . htmlspecialchars($row['id']) . "' >       
                    <button>Verwijder</button>	 
                </form></td>";

            $table .= "</tr>";
        }
        $table .= "</table>";

        echo $table;
    }
    ?>

</body>
</html>



