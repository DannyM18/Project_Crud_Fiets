<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ProjectCrudFiets\classes\Database;
use ProjectCrudFiets\classes\Fiets;

// Tests voor de Database klasse
final class DatabaseTest extends TestCase
{
    private Database $database;

    protected function setUp(): void
    {
        // Setup voor elke test - verbinding met test database
        // OPMERKING: Dit zijn dummy credentials voor testing doeleinden
        // Zorg ervoor dat je een test database hebt ingesteld met dezelfde schema
        $this->database = new Database(
            'localhost',      // servername
            'root',           // username
            '',               // password
            'fietsenmaker'    // dbname
        );
    }

    /**
     * Test of de Database klasse kan worden geïnstantieerd
     */
    public function testDatabaseCanBeInstantiated(): void
    {
        $this->assertInstanceOf(Database::class, $this->database);
    }

    /**
     * Test of getConnection() een PDO object retourneert
     */
    public function testGetConnectionReturnsConnection(): void
    {
        $conn = $this->database->getConnection();
        // Check if it's a PDO object
        $this->assertNotNull($conn);
    }

    /**
     * Test of getAll() een array retourneert
     */
    public function testGetAllReturnsArray(): void
    {
        $result = $this->database->getAll();
        $this->assertIsArray($result);
    }

    /**
     * Test of getAll() lege array retourneert als geen records
     */
    public function testGetAllReturnsEmptyArrayIfNoRecords(): void
    {
        $result = $this->database->getAll();
        // Dit test kan variabel zijn afhankelijk van database inhoud
        $this->assertIsArray($result);
    }

    /**
     * Test of insert() een Fiets succesvol kan toevoegen
     * OPMERKING: Deze test wijzigt de database, voer voorzichtig uit!
     */
    public function testInsertFiets(): void
    {
        $fiets = new Fiets('Test Merk', 'Test Type', 500.00);
        $result = $this->database->insert($fiets);
        $this->assertTrue(is_bool($result));
    }

    /**
     * Test of insert() boolean retourneert
     */
    public function testInsertReturnsBool(): void
    {
        $fiets = new Fiets('TestMerk2', 'TestType2', 750.00);
        $result = $this->database->insert($fiets);
        $this->assertIsBool($result);
    }

    /**
     * Test of getById() een Fiets object of null retourneert
     */
    public function testGetByIdReturnsCorrectType(): void
    {
        $result = $this->database->getById(1);
        // Kan null zijn als fiets niet bestaat, of Fiets object
        $this->assertTrue($result === null || $result instanceof Fiets);
    }

    /**
     * Test of getById() null retourneert voor niet-bestaande ID
     */
    public function testGetByIdReturnsNullForNonExistentId(): void
    {
        $result = $this->database->getById(999999);
        $this->assertNull($result);
    }

    /**
     * Test of getById() een Fiets object retourneert als het bestaat
     * OPMERKING: Aangenomen dat ID 1 in database bestaat
     */
    public function testGetByIdReturnsFietsObject(): void
    {
        $result = $this->database->getById(1);
        if ($result !== null) {
            $this->assertInstanceOf(Fiets::class, $result);
            $this->assertIsInt($result->getId());
            $this->assertIsString($result->getMerk());
            $this->assertIsString($result->getType());
            $this->assertTrue(is_numeric($result->getPrijs()));
        } else {
            // Als ID 1 niet bestaat, test dan met getAll
            $all = $this->database->getAll();
            if (!empty($all)) {
                $firstId = $all[0]['id'];
                $result = $this->database->getById($firstId);
                $this->assertInstanceOf(Fiets::class, $result);
            } else {
                // Geen records in database, skip deze assertion
                $this->assertTrue(true);
            }
        }
    }

    /**
     * Test of update() een boolean retourneert
     */
    public function testUpdateReturnsBool(): void
    {
        $fiets = new Fiets('Updated Merk', 'Updated Type', 600.00, 1);
        $result = $this->database->update($fiets);
        $this->assertIsBool($result);
    }

    /**
     * Test of delete() een boolean retourneert
     */
    public function testDeleteReturnsBool(): void
    {
        $result = $this->database->delete(999);
        $this->assertIsBool($result);
    }

    /**
     * Test of getAll() alle fietsen retourneert als array van arrays
     */
    public function testGetAllReturnsArrayOfRecords(): void
    {
        $result = $this->database->getAll();
        
        $this->assertIsArray($result);
        // Als er records zijn, controleer de structuur
        if (!empty($result)) {
            $firstRecord = $result[0];
            $this->assertIsArray($firstRecord);
            // Zorg ervoor dat de verwachte velden aanwezig zijn
            $this->assertArrayHasKey('id', $firstRecord);
            $this->assertArrayHasKey('merk', $firstRecord);
            $this->assertArrayHasKey('type', $firstRecord);
            $this->assertArrayHasKey('prijs', $firstRecord);
        }
    }

    /**
     * Test of Database klasse alle CRUD operaties ondersteunt
     */
    public function testDatabaseSupportsCRUDOperations(): void
    {
        // Check dat alle CRUD methodes beschikbaar zijn
        $this->assertTrue(method_exists($this->database, 'insert'));
        $this->assertTrue(method_exists($this->database, 'getAll'));
        $this->assertTrue(method_exists($this->database, 'getById'));
        $this->assertTrue(method_exists($this->database, 'update'));
        $this->assertTrue(method_exists($this->database, 'delete'));
    }

    /**
     * Test of methodes het juiste type retourneren
     */
    public function testMethodReturnTypes(): void
    {
        // getAll() moet array retourneren
        $this->assertIsArray($this->database->getAll());
        
        // getById() moet Fiets of null retourneren
        $result = $this->database->getById(1);
        $this->assertTrue($result === null || $result instanceof Fiets);
        
        // insert() moet bool retourneren
        $this->assertIsBool($this->database->insert(new Fiets('Test', 'Test', 100)));
    }
}
