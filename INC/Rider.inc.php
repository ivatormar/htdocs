<?php

class Rider extends Person
{
    private $number;

    public function __construct(string $name, int $birthday, int $number)
    {
        parent::__construct($name, $birthday);
        $this->number = $number;
    }
    public function __toString()
    {
        return parent::__toString().' '. $this->number;
    }
    public function __set($property,$value){
        if(isset($this->$property))
        return $this->$property=$value;
    }
    public function __get($property){
        if(isset($this->$property))
        return $this->$property;
    }
}

