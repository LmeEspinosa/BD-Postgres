<?php
    $dbconn = pg_connect("host=localhost port=5432 dbname=cine user=postgres password=postgres")
    or die('No se ha podido conectar: ' . pg_last_error()); 
?>