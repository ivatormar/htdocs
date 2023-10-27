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


    public function calcDate(){
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
}