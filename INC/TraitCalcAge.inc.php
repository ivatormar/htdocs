<?php
/**
 * @author Ivan Torres Marcos
 * @version 1.4
 * @description Trait para luego incluir las funciones calcAge y calcDate
 *
 */





trait Age {

/**
 * La función calcAge() se encarga de calcular la edad de una persona basándose en su fecha de nacimiento. 
 * Utiliza la función date() de PHP para obtener el año actual y el año de nacimiento. 
 * Luego realiza la resta entre estos dos valores para obtener la edad. 
 * Si el cumpleaños aún no ha ocurrido en el año actual, se ajusta la edad restando 1.
 *  El resultado de la edad se devuelve como un valor entero.
 */
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

    /**
     *  La función calcDate()  calcula la fecha de nacimiento formateada a partir de una marca de tiempo de cumpleaños almacenada. Utiliza la función date() 
     * para obtener el día, el mes y el año a partir de la marca de tiempo.
     * Utilizo un arreglo $monthNames para obtener el nombre del mes en función del número de mes.
     *  Luego, construimos una cadena que representa la fecha de nacimiento en el formato "día de mes de año" y se devuelve.
    */
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