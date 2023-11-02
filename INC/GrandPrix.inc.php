<?php

/**
 * @author Tu Nombre
 * @version 1.0
 * @description Descripción del código
 *
 */
class GrandPrix
{
    private $date;
    private $circuit;
    private $riders;

    /**
     * Constructor de la clase GrandPrix.
     *
     * @param int     $date    La fecha del Gran Premio.
     * @param Circuit $circuit El circuito donde se lleva a cabo el Gran Premio.
     */
    public function __construct(int $date, Circuit $circuit)
    {
        $this->riders = [];
        $this->date = $date;
        $this->circuit = $circuit;
    }

    /**
     * Devuelve una representación en forma de cadena de la información del Gran Premio.
     *
     * @return string Representación en forma de cadena de la información del Gran Premio.
     */
    public function __toString()
    {
        return "Información circuito: " . $this->circuit . " - Fecha de realización: " . date('d/m/Y', $this->date);
    }

    /**
     * Agrega un piloto y su posición en el Gran Premio.
     *
     * @param Rider $rider     El piloto a agregar.
     * @param int   $position  La posición del piloto en la carrera.
     */
    public function addRider(Rider $rider, int $position)
    {
        $position = count($this->riders) + 1; // Obtener el número actual de resultados como posición
        $this->riders[$position] =  $rider;
    }

    /**
     * Obtiene los resultados de la carrera en forma de cadena.
     *
     * @return string Resultados de la carrera.
     */
    public function results()
    {
        $resultString = '';
        foreach ($this->riders as $position => $rider) {
            $resultString .= 'Puesto: ' . $position . ': ' . $rider . '<br>';
        }

        return $resultString;
    }

    
    public function __set($property, $value)
    {
        if (isset($this->$property)) {
            $this->$property = $value;
        }
    }

    
    public function __get($property)
    {
        if (isset($this->$property)) {
            return $this->$property;
        }
    }
}
