
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


        echo ('<br><br> <b>Extra burbuja: </b><br>');
        $burbuja = [];

        // Llenamos el array con números aleatorios
        for ($i = 0; $i < 10; $i++) {
            $burbuja[] = rand(1, 1000);
        }

        echo ('<b>Array desorganizado: </b>');
        for ($i = 0; $i < 10; $i++) {
            echo $burbuja[$i] . ' ▪ ';
        }

<<<<<<< HEAD
        // Algoritmo método burbuja, lo tengo explicado en el notes del móvil, donde pone server.
=======
        // Algoritmo método burbuja, lo tengo explicado en el notes del movil, donde pone server.
>>>>>>> 9eea09701dc3eb8047f541ccda068781cdfef4e9
        for ($i = 0; $i < count($burbuja) - 1; $i++) {
            for ($j = 0; $j < count($burbuja) - $i - 1; $j++) {
                if ($burbuja[$j] > $burbuja[$j + 1]) {
                    $aux = $burbuja[$j];
                    $burbuja[$j] = $burbuja[$j + 1];
                    $burbuja[$j + 1] = $aux;
                }
            }
        }

        echo (' <br> <b>Array organizado (metodo burbuja): </b>');
        for ($i = 0; $i < 10; $i++) {
            echo $burbuja[$i] . ' ▪ ';
        }
