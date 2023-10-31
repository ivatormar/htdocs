<?php

class Mechanic extends Person
{
    private $speciality;

    public function __construct(string $name, int $birthday, string $speciality)
    {
        parent::__construct($name, $birthday);
        $this->speciality = $speciality;
    }
    public function __toString()
    {
        return parent::__toString().' '. $this->speciality;
    }
    public function __set($property,$value){
        if(isset($this->$property))
         return $this->$property=$value;
    }
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null; // O puedes lanzar una excepción si lo prefieres
    }

}
