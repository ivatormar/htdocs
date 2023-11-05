<?php

/**
 * @author Ivan Torres Marcos
 * @version 1.3
 * @description Clase para generar Rider
 *
 */


class Rider extends Person
{
    private $number;

    /**
     * Constructor de la clase Rider.
     *
     * @param string $name     El nombre del piloto.
     * @param int    $birthday La fecha de nacimiento del piloto.
     * @param int    $number   El número del piloto.
     */
    public function __construct(string $name, int $birthday, int $number)
    {
        parent::__construct($name, $birthday);
        $this->number = $number;
    }

    /**
     * Devuelve una representación en forma de cadena de la información del piloto.
     *
     * @return string Representación en forma de cadena de la información del piloto.
     */
    public function __toString()
    {
        return parent::__toString() . '  Dorsal: ' . $this->number;
    }

    
    public function __set($property, $value)
    {
        if (isset($this->$property)) {
            return $this->$property = $value;
        }
    }

    
    public function __get($property)
    {
        if (isset($this->$property)) {
            return $this->$property;
        }
    }
}