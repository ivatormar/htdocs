<?php


/**
 * @author Ivan Torres Marcos
 * @version 1.2
 * @description Clase para generar Person
 *
 */

include_once(__DIR__ . '/TraitCalcAge.inc.php');

class Person
{
    use Age; // Utiliza el trait Age

    private $name;
    private $birthday;

    /**
     * Constructor de la clase Person.
     *
     * @param string $name     El nombre de la persona.
     * @param int    $birthday La fecha de nacimiento de la persona.
     */
    public function __construct(string $name, int $birthday)
    {
        $this->name = $name;
        $this->birthday = $birthday;
    }

    /**
     * Devuelve una representación en forma de cadena de la información de la persona.
     *
     * @return string Representación en forma de cadena de la información de la persona.
     */
    public function __toString()
    {
        $age = $this->calcAge(); // Llama al método calcAge del trait usando $this
        return $this->name . ' - ' . $age . ' años';
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