<?php
    
    include('../db/connection.php');
    
    session_start();

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $user = $_POST['user'];
    $password = $_POST['password'];

    $query = "INSERT INTO persona (usuario,clave,nombre,apellido) VALUES ('". $user . "',crypt('". $password . "', gen_salt('bf')),'". $name ."','". $surname ."')";

    $result = pg_query($query) or die(showError());
    
    $_SESSION["login_user"] = $user;
    
    header("location: ../index.php");


    function showError(){
        echo("<script>alert('usuario incorrecto'); window.location = '../index.php'</script>");
    }

?>