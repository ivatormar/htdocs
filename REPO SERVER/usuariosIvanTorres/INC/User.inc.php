<?php

/**
 * @author Iván Torres Marcos
 * @version 1.1
 * @description Creación de la clase user con sus funciones
 *
 */


class User
{
    private $id;
    private $email;
    private $name;
    private $surname1;
    private $surname2;
    private $birthday;
    private $phone;

    public function __construct($id, $email, $name, $surname1 = '', $surname2 = '', $birthday = '01/05/1980', $phone = '')
    {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->surname1 = $surname1;
        $this->surname2 = $surname2;
        $this->birthday = $birthday;
        $this->phone = $phone;
    }

    public function __set($property, $value)
    {
        if (isset($this->$property))
            $this->$property = $value;
    }


    public function __get($property)
    {
        if (isset($this->$property))
            return $this->$property;
    }

    public function calculate_age()
    {
        $birthday_year = date('Y', $this->birthday); // Obtiene el año de nacimiento
        $current_year = date('Y'); // Obtiene el año actual

        $age = $current_year - $birthday_year;

        // Ajusta la edad si el cumpleaños aún no ha ocurrido este año
        $birthday_month = date('m', $this->birthday);
        $current_month = date('m');
        $birthday_day = date('d', $this->birthday);
        $current_day = date('d');

        if ($birthday_month > $current_month || ($birthday_month === $current_month && $birthday_day > $current_day)) {
            $age--;
        }

        return $age;
    }




    private function calculate_birthdate()
    {
        $birthday_timestamp = $this->birthday; // Utiliza la marca de tiempo de cumpleaños almacenada

        $day = date('d', $birthday_timestamp);
        $monthNumber = date('n', $birthday_timestamp);
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
        $year = date('Y', $birthday_timestamp);

        return $day . ' de ' . $month . ' de ' . $year;
    }




    public function __toString()
    {
        return '<article class="user">
                <h1>' . $this->name . ' ' . $this->surname1 . ' ' . $this->surname2 . ' (' . $this->id . ')</h1>
                <div>
                <p>' . self::calculate_age($this->birthday) . ' años - ' . self::calculate_birthdate($this->birthday) . '<br> Email: <a href="' . $this->email . '">' . $this->email . '</a><br> Teléfono:  ' . $this->phone . '</p>
                </div> 
                </article><br>';
    }
}
