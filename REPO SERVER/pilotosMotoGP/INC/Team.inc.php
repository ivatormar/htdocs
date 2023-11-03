<?php
/**
 * @author Ivan Torres Marcos
 * @version 1.3
 * @description Clase para generar Team
 *
 */
class Team
{
    
    private $name;
    private $country;
    private $riders = [];
    private $mechanics = [];

    /**
     * Constructor de la clase Team.
     *
     * @param string $name    El nombre del equipo.
     * @param string $country El país del equipo.
     */
    public function __construct(string $name, string $country)
    {
        $this->name = $name;
        $this->country = $country;
    }

    /**
     * Devuelve una representación en forma de cadena de la información del equipo.
     *
     * @return string Representación en forma de cadena de la información del equipo.
     */
    public function __toString()
    {
        $teamInfo = 'Nombre del equipo: ' . $this->name . '<br>País: ' . $this->country . "<br>";

        $ridersInfo = 'Pilotos:' . '<br>';
        foreach ($this->riders as $rider) {
            $ridersInfo .= $rider . '<br>';
        }

        $mechanicsInfo = 'Mecánicos:' . '<br>';
        foreach ($this->mechanics as $mechanic) {
            $mechanicsInfo .= $mechanic . '<br>';
        }

        return $teamInfo . $ridersInfo . $mechanicsInfo;
    }

    /**
     * Añade un piloto al equipo.
     *
     * @param Rider $rider El piloto a añadir.
     */
    public function addRider(Rider $rider)
    {
        $this->riders[] = $rider;
    }

    /**
     * Añade un mecánico al equipo.
     *
     * @param Mechanic $mechanic El mecánico a añadir.
     */
    public function addMechanic(Mechanic $mechanic)
    {
        $this->mechanics[] = $mechanic;
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