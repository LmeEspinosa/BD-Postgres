<?php
	ob_start();
	session_start();
	if( isset($_SESSION['usuario'])!="" ){
		header("Location: home.php");
	}
	include_once 'dbconnect.php';

	$error = false;

	if ( isset($_POST['btn-loggin']) ) {
		
		// clean user inputs to prevent sql injections
		$name = trim($_POST['Nombre']);
		$name = strip_tags($name);
		$name = htmlspecialchars($name);
		
		$apellido = trim($_POST['Apellido']);
		$apellido = strip_tags($apellido);
		$apellido = htmlspecialchars($apellido);
		
		$usuario = trim($_POST['Usuario']);
		$usuario = strip_tags($usuario);
		$usuario = htmlspecialchars($usuario);
		
		$pass = trim($_POST['Contraseña']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		
		// basic name validation
		if (empty($name)) {
			$error = true;
			$nameError = "Por favor Ingrese su Nombre.";
		} else if (strlen($name) < 3) {
			$error = true;
			$nameError = "El Nombre debe Contener al menos 3 caracteres.";
		} else if (!preg_match("/^[a-zA-Z]+$/",$name)) {
			$error = true;
			$nameError = "El Nombre solo Debe Contener Letras sin Espacios.";
		}
		
		if (empty($apellido)) {
			$error = true;
			$apellidoError = "Por favor Ingrese su Apellido.";
		} else if (strlen($apellido) < 3) {
			$error = true;
			$apellidoError = "El Nombre debe Contener al menos 3 caracteres.";
		} else if (!preg_match("/^[a-zA-Z]+$/",$apellido)) {
			$error = true;
			$apellidoError = "El Apellido solo Debe Contener Letras sin Espacios.";
		}
			
		//basic usuario validation
		if (empty($usuario)) {
			$error = true;
			$usuarioError = "Por favor Ingrese un Usuario.";
		} else if (strlen($usuario) < 3) {
			$error = true;
			$usuarioError = "El Usuario debe Contener al menos 3 caracteres.";
		} else if (!preg_match("/^[a-zA-Z0123456789]+$/",$usuario)) {
			$error = true;
			$usuarioError = "El Usuario debe Contener Solo Letra y Numeros.";	
		} else {
			$query = "SELECT usuario FROM persona WHERE usuario='$usuario'";
			$result = pg_query($query);
			$count = pg_num_rows($result);
			if($count!=0){
				$error = true;
				$usuarioError = "El Usuaruio Ingresado ya Existe.";
		        }
		}
		// password validation
		if (empty($pass)){
			$error = true;
			$passError = "Por favor Ingrese Contraseña.";
		} else if(strlen($pass) < 4) {
			$error = true;
			$passError = "La Contraseña debe Contener al menos 4 Caracteres.";
		}
		
		// password encrypt using md5();
		$password = md5($pass);
		
		// if there's no error, continue to signup
		if( !$error ) {
			
			$query = "INSERT INTO persona(nombre,apellido,usuario,clave) VALUES('$name','$apellido','$usuario','$password')";
			$res = pg_query($query);
				
			if ($res) {
				$errTyp = "success";
				$errMSG = "Registracion Exitosa, Puedes loguearte ahora";
				unset($name);
				unset($apellido);
				unset($usuario);
				unset($pass);
			} else {
				$errTyp = "danger";
				$errMSG = "Algo salio mal, Intenta otra vez...";	
			}	
				
		}
			
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TP2 - Login & Sistema de Registracion</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div class="container">

	<div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
    	<div class="col-md-12">
        
        	<div class="form-group">
            	<h2 class="">Alta de Usuario</h2>
            </div>
        
        	<div class="form-group">
            	<hr />
            </div>
            
            <?php
			if ( isset($errMSG) ) {
				
				?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php
			}
			?>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="Nombre" class="form-control" placeholder="Ingrese su Nombre" maxlength="50" value="<?php echo $name ?>" />
                </div>
                <span class="text-danger"><?php echo $nameError; ?></span>
            </div>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="Apellido" class="form-control" placeholder="Ingrese su Apellido" maxlength="40" value="<?php echo $apellido ?>" />
                </div>
                <span class="text-danger"><?php echo $apellidoError; ?></span>
            </div>

			<div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="Usuario" class="form-control" placeholder="Ingrese Usuario " maxlength="40" value="<?php echo $usuario ?>" />
                </div>
                <span class="text-danger"><?php echo $usuarioError; ?></span>
            </div>

			
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            	<input type="password" name="Contraseña" class="form-control" placeholder="Ingrese Contraseña" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<button type="submit" class="btn btn-block btn-primary" name="btn-loggin">Resgistrarse</button>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<a href="index.php">Login...</a>
            </div>
        
        </div>
   
    </form>
    </div>	

</div>

</body>
</html>
<?php ob_end_flush(); ?>