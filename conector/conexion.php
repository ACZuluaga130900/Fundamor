<?php
    $bd_host = "localhost"
    $bd_usuario = "root";
    $bd_password = "root";
    $bd_bbase = "database_animal";
    $con = mysql_connect($bd_host,$bd_usuario,$bd_password);
    mysql_select_db($bd_base,$con);
    mysql_set_charset('utf8');

        if($con==TRUE)
        {
            echo "conexion exitos";
        }
?>