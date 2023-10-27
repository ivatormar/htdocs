<?php
class Team{
    private $name;
    private $country;
    private $riders; //*Porque tiene 0,n riders
    private $mechanics;//*Porque tiene 0,n mechanics

    public function __construct(string $name, string $country)
    {
        $this->name=$name;
        $this->country=$country;

    }

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

    public function addRider(Rider $rider){
        $this->riders[]=$rider;
    }
    public function addMechanic(Mechanic $mechanic){
        $this->mechanics[]=$mechanic;
    }

}