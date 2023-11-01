<?php
class GrandPrix
{
    
    private $date;
    private $circuit;
    private $riders = [];
    private $results = [];

    public function __construct(int $date, Circuit $circuit)
    {
        $this->date = $date;
        $this->circuit = $circuit;
    }

    public function __toString()
    {
        return "Información circuito: " . $this->circuit . " - Fecha de realización: " . date('d/m/Y', $this->date);
    }

    public function addRider(Rider $rider, int $position)
    {
        $position = count($this->results)+1; // Obtener el número actual de resultados como posición
        $this->results[$position] =  $rider;
    }

    public function results()
    {
       
        return $this->results;
    }

    public function __set($property, $value)
    {
        if (isset($this->$property))
            return $this->$property = $value;
    }
    public function __get($property)
    {
        if (isset($this->$property))
            return $this->$property;
    }
}
