
        <?php
        /**
         * @author Ivan Torres Marcos
         * @version V.1.0
         * @description Esta actividad organiza un array de manera selección directa y burbuja. 
         */



        $arr = [];
        $aux = array();

        for ($i = 0; $i < 10; $i++) {
            $arr[$i] = rand(1, 1000);
        }
        echo ('<b>Array desorganizado: </b>');
        for ($i = 0; $i < 10; $i++) {
            echo $arr[$i] . ' ▪ ';
        }
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 9; $j++) { //Ponemos el 9 para que no compare la ultima
                if ($arr[$i] < $arr[$j]) { //Si A < B lo que hacemos es: 
                    $aux = $arr[$i]; //guardamos A en una variable auxiliar
                    $arr[$i] = $arr[$j]; //A ahora tiene el valor de B
                    $arr[$j] = $aux; //y asi vamos "subiendo" los valores mas bajos a la primera posición
                }
            }
        }
        echo (' <br> <b>Array organizado: </b>');
        for ($i = 0; $i < 10; $i++) {
            echo $arr[$i] . ' ▪ ';
        }


        echo ('<br><br> <b>Extra burbuja: </b>');
        echo ('<br> <b>Desorganizado: </b>');
        $arr = [];

        // Llenar el array con números aleatorios
        for ($i = 0; $i < 10; $i++) {
            $arr[] = rand(1, 1000);
        }

        echo ('<b>Array desorganizado: </b>');
        for ($i = 0; $i < 10; $i++) {
            echo $arr[$i] . ' ▪ ';
        }

        // Algoritmo de ordenamiento de burbuja
        for ($i = 0; $i < count($arr) - 1; $i++) {
            for ($j = 0; $j < count($arr) - $i - 1; $j++) {
                if ($arr[$j] > $arr[$j + 1]) {
                    $aux = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $aux;
                }
            }
        }

        echo (' <br> <b>Array organizado (método burbuja)checklin: </b>');
        for ($i = 0; $i < 10; $i++) {
            echo $arr[$i] . ' ▪ ';
        }
