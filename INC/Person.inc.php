<?php
include_once(__DIR__ . '/INC/TraitCalcAge.inc.php');
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
}
