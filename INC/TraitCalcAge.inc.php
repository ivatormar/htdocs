<?php
trait Age {
    public function calcAge(){
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
}