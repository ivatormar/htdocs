<?php
class GrandPrix {
    private $date;
    private $circuit;
    private $riders = [];
    private $results = [];

    public function __construct(int $date, Circuit $circuit) {
        $this->date = $date;
        $this->circuit = $circuit;
    }

    public function __toString() {
        return "Información circuito: " . $this->circuit . " - Fecha de realización: " . date('d/m/Y', $this->date);
    }

    public function addRider(Rider $rider, int $position) {
        if (!isset($this->results[$position])) {
            $this->results[$position] = $rider;
        }
    }

    public function results() {
        ksort($this->results); // Ordenar por posición

        $resultString = "Resultados del Gran Premio:\n";
        foreach ($this->results as $position => $rider) {
            $resultString .= "Puesto " . $position . ": " . $rider . "\n";
        }

        return $this->__toString() . "\n" . $resultString;
    }
    public function __set($property,$value){
        if(isset($this->$property))
        return $this->$property=$value;
    }
    public function __get($property){
        if(isset($this->$property))
        return $this->$property;
    }
}

