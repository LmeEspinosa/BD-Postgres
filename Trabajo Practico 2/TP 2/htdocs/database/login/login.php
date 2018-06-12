<?php
    include('../db/connection.php');

    $user = $_POST['user'];
    $password = $_POST['password'];
    
    $query_login = "SELECT * FROM persona WHERE clave = crypt('" . $password . "',clave) AND usuario='" . $user . "'";

    $result = pg_query($query_login) or die('La consulta fallo: ' . pg_last_error());

    if(pg_num_rows($result)>0){
        $_SESSION["login_user"] = $user;
        header("location: ../db/excersice.php");
        //header("location: ../pages/home.php");
    }else{
        echo("<script>alert('usuario incorrecto'); window.location = '../index.php'</script>");
    }
        
?>