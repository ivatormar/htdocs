<?php

/**
 *
 * @author Ivan Torres Marcos
 * @version V1.4
 * @description Clase para crear circuitos 
 *
 */
class Circuit
{
    
    private $name;
   
    private $country;
    
   
    private $laps;

    /**
     * Constructor de la clase Circuit.
     *
     * @param string $name    El nombre del circuito.
     * @param string $country El país en el que se encuentra el circuito.
     * @param int    $laps    El número de vueltas del circuito.
     */
    public function __construct(string $name, string $country, int $laps)
    {
        $this->name = $name;
        $this->country = $country;
        $this->laps = $laps;
    }

    /**
     * Devuelve una representación en forma de cadena del circuito.
     *
     * @return string Representación en forma de cadena del circuito.
     */
    public function __toString()
    {
        return "Circuito: " . $this->name . " - País: " . $this->country . " - Número de vueltas: " . $this->laps;
    }
}
