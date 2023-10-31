<?php
class Circuit
{
    private $name;
    private $country;
    private $laps;


    public function __construct(string $name, string $country, int $laps)
    {
        $this->name = $name;
        $this->country = $country;
        $this->laps = $laps;
    }

    public function __toString()
    {
        return "Circuito: " . $this->name . " - País: " . $this->country . " - Número de vueltas: " . $this->laps;
    }
    public function __set($property, $value)
    {
        if (isset($this->$property))
        return   $this->$property = $value;
    }
    public function __get($property)
    {
        if (isset($this->$property))
        return  $this->$property;
    }
}
