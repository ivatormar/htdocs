<?php
class GrandPrix
{

    private $date;
    private $circuit;
    private $riders = [];//* y tambien esto no se tiene que hacer asi
    

    public function __construct(int $date, Circuit $circuit)
    {
        $this->date = $date;
        $this->circuit = $circuit;
    }

    public function __toString() //*Tal y como dijo Alex, hay ciertos casos en los que no me interesa mostrar el __toString entero de Circuit, tal y como hago
    {
        return "Información circuito: " . $this->circuit . " - Fecha de realización: " . date('d/m/Y', $this->date);
    }

    public function addRider(Rider $rider, int $position)
    {
        $position = count($this->riders) + 1; // Obtener el número actual de resultados como posición
        $this->riders[$position] =  $rider;
    }

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
        if (isset($this->$property))
            return $this->$property = $value;
    }
    public function __get($property)
    {
        if (isset($this->$property))
            return $this->$property;
    }
}
