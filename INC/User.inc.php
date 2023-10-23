<?php
class User
{
    private $id;
    private $email;
    private $name;
    private $surname1;
    private $surname2;
    private $birthday;
    private $phone;

    public function __construct($id, $email, $name, $surname1='', $surname2='', $birthday='01/05/1980', $phone='')
    {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->surname1 = $surname1;
        $this->surname2 = $surname2;
        $this->birthday = $birthday;
        $this->phone = $phone;
    }

    public function __set($property,$value){
        if(isset($this->$property))
            $this->$property=$value;
        
    }


    public function __get($property){
        if(isset($this->$property))
            return $this->$property;
    }
    
    public function calculate_age() {
        $birthday = new DateTime();
        $birthday->setTimestamp($this->birthday);
        $now = new DateTime();
        $age = $now->diff($birthday)->y;
        return $age;
    }
    
    function make_birthday(): int {
        $birthday = new DateTime();
        $birthday->setDate(mt_rand(1999, 2005), mt_rand(1, 12), mt_rand(1, 31));
        $birthday->setTime(0, 0, 0);
        return $birthday->getTimestamp();
    }

    private function calculate_birthdate() {
        $birthday = new DateTime();
        $birthday->setTimestamp($this->birthday); // Use the user's stored birthday timestamp
        $day = $birthday->format('d');
        $monthNumber = $birthday->format('n');
        $monthNames = [
            1 => 'enero',
            2 => 'febrero',
            3 => 'marzo',
            4 => 'abril',
            5 => 'mayo',
            6 => 'junio',
            7 => 'julio',
            8 => 'agosto',
            9 => 'septiembre',
            10 => 'octubre',
            11 => 'noviembre',
            12 => 'diciembre'
        ];
        $month = $monthNames[$monthNumber];
        $year = $birthday->format('Y');
        
        return $day . ' de ' . $month . ' de ' . $year;
    }
    


    public function __toString()
    {
        return '<article class="user">
                <h1>'.$this->name.' '.$this->surname1.' '.$this->surname2.' ('.$this->id.')</h1>
                <div>
                <p>'.self::calculate_age($this->birthday).' - '.self::calculate_birthdate($this->birthday).'<br> Email: <a href="'.$this->email.'">'.$this->email.'</a><br> Teléfono:  '.$this->phone.'</p>
                </div> 
                </article><br>';
    }
    
}
