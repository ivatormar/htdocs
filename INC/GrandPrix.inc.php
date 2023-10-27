<?php
class GrandPrix{
    private $date;
    private $circuit;
    private $rider;

    public function __construct(int $date)
    {
        $this->date=$date;       
    }

    public function __toString()
    {
        return 'Información circuito: '.$this->circuit.' - Fecha de realización'. date('d/m/Y',$this->date); 
    }

    public function reuslts(){

    }

}