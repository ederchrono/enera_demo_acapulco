<?php
        //Conexión a la base de datos
           $mysqli = new mysqli('Localhost', 'root', 'Enera4265BX.R', 'enera_wifi');

           if(mysqli_connect_errno()) {
            echo "Connection Failed: " . mysqli_connect_errno();
              exit();
           }
?>
