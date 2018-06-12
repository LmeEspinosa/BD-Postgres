<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	// it will never let you open index(login) page if session is set
	if ( isset($_SESSION['usuario'])!="" ) {
		header("Location: home.php");
		exit;
	}
	
	$error = false;
	
	if( isset($_POST['btn-login']) ) {	
		
		// prevent sql injections/ clear user invalid inputs
		$usuario = trim($_POST['Usuario']);
		$usuario = strip_tags($usuario);
		//$email = htmlspecialchars($email);
		
		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		// prevent sql injections / clear user invalid inputs
		
		if(empty($usuario)){
			$error = true;
			$usuarioError = "Por favor Ingrese su Usuario .";
		//} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			//$error = true;
			//$emailError = "Please enter valid email address.";
		}
		
		if(empty($pass)){
			$error = true;
			$passError = "Por favor Ingrese su Contraseña.";
		}
		
		// if there's no error, continue to login
		if (!$error) {
			
			$password = md5($pass); // password hashing using md5
		    
			
			$res=pg_query("SELECT id, clave FROM persona WHERE usuario='$usuario'");
			$row=pg_fetch_array($res);
			$count = pg_num_rows($res); // if uname/pass correct it returns must be 1 row
			
			if( $count == 1 && $row['clave']==$password ) {
				$_SESSION['usuario'] = $row['id'];
				
				header("Location: home.php");
			} else {
				$errMSG = "Credenciales Incorrectas, Intente otra Vez...";
			}
				
		}
		
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TP2 - Login & Sistema de Registracion </title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div class="container">

	<div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
    	<div class="col-md-12">
        
        	<div class="form-group">
            	<h2 class="">Loggin.</h2>
            </div>
        
        	<div class="form-group">
            	<hr />
            </div>
            
            <?php
			if ( isset($errMSG) ) {
				
				?>
				<div class="form-group">
            	<div class="alert alert-danger">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php
			}
			?>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="Usuario" name="Usuario" class="form-control" placeholder="Su Usuario" value="<?php echo $usuario; ?>" maxlength="40" />
                </div>
                <span class="text-danger"><?php echo $usuarioError; ?></span>
            </div>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            	<input type="password" name="pass" class="form-control" placeholder="Su Contraseña" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<button type="submit" class="btn btn-block btn-primary" name="btn-login">Iniciar Sesion</button>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<a href="register.php">Registrarse...</a>
            </div>
        
        </div>
   
    </form>
    </div>	

</div>

</body>
</html>
<?php ob_end_flush(); ?>