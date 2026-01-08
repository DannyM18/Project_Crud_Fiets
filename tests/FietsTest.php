<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ProjectCrudFiets\classes\Fiets;

// Tests voor de Fiets klasse
final class FietsTest extends TestCase
{
    private Fiets $fiets;

    protected function setUp(): void
    {
        // Setup voor elke test
        $this->fiets = new Fiets('Trek', 'FX 3', 899.99, 1);
    }

    // Tests voor constructor
    public function testFietsConstructorWithId(): void
    {
        $fiets = new Fiets('Giant', 'Escape 3', 599.99, 5);
        $this->assertInstanceOf(Fiets::class, $fiets);
        $this->assertEquals(5, $fiets->getId());
        $this->assertEquals('Giant', $fiets->getMerk());
        $this->assertEquals('Escape 3', $fiets->getType());
        $this->assertEquals(599.99, $fiets->getPrijs());
    }

    public function testFietsConstructorWithoutId(): void
    {
        $fiets = new Fiets('Specialized', 'Rockhopper', 749.99);
        $this->assertNull($fiets->getId());
        $this->assertEquals('Specialized', $fiets->getMerk());
    }

    // Tests voor Getters
    public function testGetId(): void
    {
        $this->assertEquals(1, $this->fiets->getId());
    }

    public function testGetMerk(): void
    {
        $this->assertEquals('Trek', $this->fiets->getMerk());
    }

    public function testGetType(): void
    {
        $this->assertEquals('FX 3', $this->fiets->getType());
    }

    public function testGetPrijs(): void
    {
        $this->assertEquals(899.99, $this->fiets->getPrijs());
    }

    // Tests voor Setters
    public function testSetMerk(): void
    {
        $this->fiets->setMerk('Cannondale');
        $this->assertEquals('Cannondale', $this->fiets->getMerk());
    }

    public function testSetType(): void
    {
        $this->fiets->setType('Synapse');
        $this->assertEquals('Synapse', $this->fiets->getType());
    }

    public function testSetPrijs(): void
    {
        $this->fiets->setPrijs(1299.99);
        $this->assertEquals(1299.99, $this->fiets->getPrijs());
    }

    // Tests voor toArray methode
    public function testToArray(): void
    {
        $array = $this->fiets->toArray();
        
        $this->assertIsArray($array);
        $this->assertEquals(1, $array['id']);
        $this->assertEquals('Trek', $array['merk']);
        $this->assertEquals('FX 3', $array['type']);
        $this->assertEquals(899.99, $array['prijs']);
    }

    public function testToArrayWithoutId(): void
    {
        $fiets = new Fiets('Scott', 'Aspect', 649.99);
        $array = $fiets->toArray();
        
        $this->assertNull($array['id']);
        $this->assertEquals('Scott', $array['merk']);
    }

    // Tests voor meerdere setters
    public function testMultipleSetters(): void
    {
        $this->fiets->setMerk('BMC');
        $this->fiets->setType('Alpenchallenge');
        $this->fiets->setPrijs(1050.00);

        $this->assertEquals('BMC', $this->fiets->getMerk());
        $this->assertEquals('Alpenchallenge', $this->fiets->getType());
        $this->assertEquals(1050.00, $this->fiets->getPrijs());
    }

    // Edge case tests
    public function testPrijsCanBeZero(): void
    {
        $fiets = new Fiets('Test', 'Model', 0);
        $this->assertEquals(0, $fiets->getPrijs());
    }

    public function testPrijsCanBeNegative(): void
    {
        $fiets = new Fiets('Test', 'Model', -50);
        $this->assertEquals(-50, $fiets->getPrijs());
    }

    public function testEmptyStringsAllowed(): void
    {
        $fiets = new Fiets('', '', 100);
        $this->assertEquals('', $fiets->getMerk());
        $this->assertEquals('', $fiets->getType());
    }
}
