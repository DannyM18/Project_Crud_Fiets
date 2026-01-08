<?php
    namespace ProjectCrudFiets\classes;
// auteur: Vul hier je naam in
// functie: Fiets modelklasse

class Fiets {
    private $id;
    private $merk;
    private $type;
    private $prijs;

    public function __construct($merk, $type, $prijs, $id = null) {
        $this->id = $id;
        $this->merk = $merk;
        $this->type = $type;
        $this->prijs = $prijs;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getMerk() {
        return $this->merk;
    }

    public function getType() {
        return $this->type;
    }

    public function getPrijs() {
        return $this->prijs;
    }

    // Setters
    public function setMerk($merk) {
        $this->merk = $merk;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setPrijs($prijs) {
        $this->prijs = $prijs;
    }

    // Converteer naar array
    public function toArray() {
        return [
            'id' => $this->id,
            'merk' => $this->merk,
            'type' => $this->type,
            'prijs' => $this->prijs
        ];
    }
}
?>
