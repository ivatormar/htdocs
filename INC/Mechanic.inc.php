<?php
 /**
  * @author Ivan Torres Marcos
  * @version 1.3
  * @description Clase para generar Mechanic
  *
  */
class Mechanic extends Person
{
    private $speciality;

    /**
     * Constructor de la clase Mechanic.
     *
     * @param string $name       El nombre del mecánico.
     * @param int    $birthday   La fecha de nacimiento del mecánico.
     * @param string $speciality La especialidad del mecánico.
     */
    public function __construct(string $name, int $birthday, string $speciality)
    {
        parent::__construct($name, $birthday);
        $this->speciality = $speciality;
    }

    /**
     * Devuelve una representación en forma de cadena de la información del mecánico.
     *
     * @return string Representación en forma de cadena de la información del mecánico.
     */
    public function __toString()
    {
        return parent::__toString() . ' Especialidad: ' . $this->speciality;
    }

   
    public function __set($property, $value)
    {
        if (isset($this->$property)) {
            return $this->$property = $value;
        }
    }

   
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null; // O puedes lanzar una excepción si lo prefieres
    }
}