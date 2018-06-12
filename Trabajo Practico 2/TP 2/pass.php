<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	$error=false;
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['usuario']) ) {
		header("Location: index.php");
		exit;
	}
	// select loggedin users detail
	$res=pg_query("SELECT * FROM persona WHERE id=".$_SESSION['usuario']);
	$userRow=pg_fetch_array($res);

    if ( isset($_POST['btn-loggin']) ) 
	{
		
  		$aPass = trim($_POST['aPass']);
		$aPass = strip_tags($aPass);
		$aPass = htmlspecialchars($aPass);

		$nPass = trim($_POST['nPass']);
		$nPass = strip_tags($nPass);
		$nPass = htmlspecialchars($nPass);

		$cPass = trim($_POST['cPass']);
		$cPass = strip_tags($cPass);
		$cPass = htmlspecialchars($cPass);

		if (empty($aPass)){
			$error = true;
			$aPassError = "Por favor Ingrese Actual Contraseña.";
		} else{

			$aPassword = md5($aPass);
			//$query = "SELECT clave FROM persona WHERE clave='$aPassword' and id=".$_SESSION['usuario'];
			//$result = pg_query($query);
			//$userRow=pg_fetch_array($res);
			if($aPassword != $userRow['clave']){
				$error = true;
				$aPassError = "La contrseña Actual Ingresada es Incorrecta.";
			}else{
				$aPassok= "Validacion Correcta";		
		   }
		}	

        if (empty($nPass)){
			$error = true;
			$nPassError = "Por favor Ingrese Nueva Contraseña.";
		} else if(strlen($nPass) < 4) {
			$error = true;
			$nPassError = "La Nueva Contraseña debe Contener al menos 4 Caracteres.";
		}

        if (empty($cPass)){
			$error = true;
			$cPassError = "Por favor Ingrese Confirmacion de Contraseña.";
		} else if($nPass!=$cPass){
			$error = true;
			$cPassError = "La Confirmacion Contraseña no Coincide con la Nueva Contrseña.";
		}

        $nPassword = md5($nPass);
		 
        if( !$error ) {	
			$query = "UPDATE persona SET clave ='$nPassword' WHERE id=".$_SESSION['usuario'];
			$res = pg_query($query);
				
			if ($res) {
				$errTyp = "success";
				$errMSG = "Cambio de Contraseña Exitoso, Debes loguearte ahora";
				unset($aPass);
				unset($nPass);
				unset($cPass);
				session_unset();
		        session_destroy();
				sleep(2);
		        header("Location: index.php");
		        exit;
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
<title>Welcome - <?php echo $userRow['Usuario']; ?></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hola  <?php echo $userRow['usuario']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Cerrar Sesion</a></li>	
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav> 
	<div id="wrapper">
	<div class="container">
    	<div class="page-header">
    	</div>
          <div class="row">
            <div class="col-lg-12">		            	
            </div>
          </div>
	</div>
	</div>	
<div class="container">

	<div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
    	<div class="col-md-12">
        
        	<div class="form-group">
            	<h2 class="">Cambiar Contraseña</h2>
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
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
           	<input type="password" name="aPass" class="form-control" placeholder="Ingrese su Actual Contraseña" maxlength="50" value="<?php echo $aPass?>" />
              </div>
                <span class="text-danger"><?php echo $aPassError; ?></span>
				<span class="text-success"><?php echo $aPassok; ?></span>
            </div>
				
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
           	<input type="password" name="nPass" class="form-control" placeholder="Ingrese su Nueva Contraseña" maxlength="40" value="<?php echo $nPass?>" />
              </div>
                <span class="text-danger"><?php echo $nPassError; ?></span>
            </div>
				
			 <div class="form-group">
               <div class="input-group">
                 <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
           	 <input type="password" name="cPass" class="form-control" placeholder="Confirme Contraseña" maxlength="40" value="<?php echo $cPass?>" />
               </div>
                 <span class="text-danger"><?php echo $cPassError; ?></span>
             </div>
				
             <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<button type="submit" class="btn btn-block btn-primary" name="btn-loggin">Cambiar Contraseña</button>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<a href="index.php">Home...</a>
            </div>
        
        </div>
   
    </form>
    </div>	

</div>

    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
<?php ob_end_flush(); ?>