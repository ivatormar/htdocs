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
        $teamInfo = 'Nombre del equipo: ' . $this->name . "\nPaís: " . $this->country . "\n";

        $ridersInfo = 'Pilotos:' . "\n";
        foreach ($this->riders as $rider) {
            $ridersInfo .= $rider . "\n";
        }

        $mechanicsInfo = 'Mecánicos:' . "\n";
        foreach ($this->mechanics as $mechanic) {
            $mechanicsInfo .= $mechanic . "\n";
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