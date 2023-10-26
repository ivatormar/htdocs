<?php
 class Person{

    private $name;
    private $birthday;

    public function __construct(string $name, int $birthday){
        $this->name=$name;
        $this->birthday=$birthday;
        
    }
    public function __toString()
    {
        return $this->name.' - '.$this->birthday;
    }
    
        
    


 }