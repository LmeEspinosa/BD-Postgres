<?php
    include('../db/connection.php');

    $user = $_POST['user'];
    $password = $_POST['password'];
    $password_new = $_POST['password-new'];
    
    $query_login = "SELECT * FROM persona WHERE clave = crypt('" . $password . "',clave) AND usuario='" . $user . "'";

    $result = pg_query($query_login) or die('La consulta fallo: ' . pg_last_error());

    if(pg_num_rows($result)>0){
        $query_update_psw = "UPDATE persona SET clave = crypt('". $password_new ."',gen_salt('bf'))";
        $result_uodate = pg_query($query_update_psw) or die('La consulta fallo: ' . pg_last_error());
        header("location: ../index.php");
    }else{
        echo("<script>alert('Error al cambiar la password, intente nuevamente'); window.location = '../index.php'</script>");
    }

?>