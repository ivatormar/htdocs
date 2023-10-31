<?php
include_once(__DIR__ . '/TraitCalcAge.inc.php');
class Person
{

    use Age;

    private $name;
    private $birthday;

    public function __construct(string $name, int $birthday)
    {
        $this->name = $name;
        $this->birthday = $birthday;
    }

    public function __toString()
    {
        $age = $this->calcAge(); // Llama al método calcAge del trait usando $this
        return $this->name . ' - ' . $age;
    }
    public function __set($property,$value){
        if(isset($this->$property))
        return  $this->$property=$value;
    }
    public function __get($property){
        if(isset($this->$property))
        return  $this->$property;
    }
}
