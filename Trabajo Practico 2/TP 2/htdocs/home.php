<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['usuario']) ) {
		header("Location: index.php");
		exit;
	}
	// select loggedin users detail
	$res=pg_query("SELECT * FROM persona WHERE id=".$_SESSION['usuario']);
	$userRow=pg_fetch_array($res);
    $consulta=pg_query("SELECT * FROM persona WHERE id=".$_SESSION['usuario']);
	$consultaRow=pg_fetch_array($consulta);
    $conn = pg_connect("host=localhost dbname=lucasespinosa user=lucasespinosa password=lme")or die('ERROR AL CONECTAR: ' . pg_last_error());

	$sql = 'SELECT * FROM persona';

	$query = pg_query($conn, $sql);

	if (!$query) {
		die ('SQL Error: ' . pg_last_error($conn));
	}

	$sql1 = 'SELECT * 
			FROM pelicula';

	$query1 = pg_query($conn, $sql1);

	if (!$query) {
		die ('SQL Error: ' . pg_last_error($conn));
	}

	$sql2 = 'SELECT persona.usuario, pelicula.nombre FROM pelis_que_vio, persona, pelicula
			WHERE pelis_que_vio.id_usuario = persona.id
			AND pelis_que_vio.id_pelicula = pelicula.id';

	$query2 = pg_query($conn, $sql2);

	if (!$query) {
		die ('SQL Error: ' . pg_last_error($conn));
	}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TP2 - Base de Datos 2<?php echo $userRow['Usuario']; ?></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<head>
	<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://localhost/consulta_pares.php">Consulta</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <!--<li class="active"><a href="http://www.codingcage.com/2015/01/user-registration-and-login-script-using-php-mysql.html">Back to Article</a></li>
            <li><a href="http://www.codingcage.com/search/label/jQuery">jQuery</a></li>
            <li><a href="http://www.codingcage.com/search/label/PHP">PHP</a></li>-->
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hola  <?php echo $userRow['usuario']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
				<li><a href="pass.php"><span class="glyphicon glyphicon-lock"></span>&nbsp;Cambiar Contraseña</a></li>  
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
    	<!--<h3>Coding Cage - Programming Blog</h3>-->
		<!--<h4><//?php echo print_r($consultaRow) ?></h4>-->	
    	</div>
        
        <div class="row">
        <div class="col-lg-12">
        <!--<h1>Focuses on PHP, MySQL, Ajax, jQuery, Web Design and more...</h1>-->
        </div>
        </div>
    
    </div>
    
    </div>
	<style type="text/css">
		body {
			font-size: 15px;
			color: #343d44;
			font-family: "segoe-ui", "open-sans", tahoma, arial;
			padding: 0;
			margin: 0;
		}
		table {
			margin: auto;
			font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
			font-size: 10px;
		}

		h1 {
			margin: 20px auto 0;
			text-align: center;
			text-transform: uppercase;
			font-size: 15px;
		}

		table td {
			transition: all .5s;
		}
		
		/* Table */
		.data-table {
			border-collapse: collapse;
			font-size: 10px;
			min-width: 300px;
		}

		.data-table th, 
		.data-table td {
			border: 1px solid #e1edff;
			padding: 5px 7px;
		}
		.data-table caption {
			margin: 2px;
		}

		/* Table Header */
		.data-table thead th {
			background-color: #508abb;
			color: #FFFFFF;
			border-color: #6ea1cc !important;
			text-transform: uppercase;
		}

		/* Table Body */
		.data-table tbody td {
			color: #353535;
		}
		.data-table tbody td:first-child,
		.data-table tbody td:nth-child(4),
		.data-table tbody td:last-child {
			text-align: right;
		}

		.data-table tbody tr:nth-child(odd) td {
			background-color: #f4fbff;
		}
		.data-table tbody tr:hover td {
			background-color: #ffffa2;
			border-color: #ffff0f;
		}

		/* Table Footer */
		.data-table tfoot th {
			background-color: #e5f5ff;
			text-align: right;
		}
		.data-table tfoot th:first-child {
			text-align: left;
		}
		.data-table tbody td:empty
		{
			background-color: #ffcccc;
		}
	</style>
</head>
<body>
	<h1>Table 1</h1>
	<table class="data-table">
		<caption class="title">Listado de Personas</caption>
		<thead>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>Usuario</th>
				<th>Clave</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$no 	= 1;
		$total 	= 0;
		while ($row = pg_fetch_array($query))
		{
			//$amount  = $row['amount'] == 0 ? '' : number_format($row['amount']);
			echo '<tr>
					<td>'.$row['id'].'</td>
					<td>'.$row['nombre'].'</td>
					<td>'.$row['apellido'].'</td>
					<td>'.$row['usuario'] . '</td>
					<td>'.$row['clave'].'</td>
				</tr>';
			//$total += $row['amount'];
			$no++;
		}?>
		</tbody>
	</table>
	
	<h1>Table 2</h1>
	<table class="data-table">
		<caption class="title">Listado de Peliculas</caption>
		<thead>
			<tr>
				<th>ID</th>
				<th>NOMBRE</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$no 	= 1;
		$total 	= 0;
		while ($row = pg_fetch_array($query1))
		{
			//$amount  = $row['amount'] == 0 ? '' : number_format($row['amount']);
			echo '<tr>
					<td>'.$row['id'].'</td>
					<td>'.$row['nombre'].'</td>
				</tr>';
			//$total += $row['amount'];
			$no++;
		}?>
		</tbody>
	</table>
	
	<h1>Table 3</h1>
	<table class="data-table">
		<caption class="title">Listado de Peliculas que vio cada usuario</caption>
		<thead>
			<tr>
				<th>USUARIO</th>
				<th>PELICULA</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$no 	= 1;
		$total 	= 0;
		while ($row = pg_fetch_array($query2))
		{
			//$amount  = $row['amount'] == 0 ? '' : number_format($row['amount']);
			echo '<tr>
					<td>'.$row['usuario'].'</td>
					<td>'.$row['nombre'].'</td>
				</tr>';
			//$total += $row['amount'];
			$no++;
		}?>
		</tbody>
	</table>
			<div id="wrapper">

	<div class="container">
    
    	<div class="page-footer">
    	<!--<h3>Coding Cage - Programming Blog</h3>-->
		<!--<h4><//?php echo print_r($consultaRow) ?></h4>-->	
    	</div>
        
        <div class="row">
        <div class="col-lg-12">
        <!--<h1>Focuses on PHP, MySQL, Ajax, jQuery, Web Design and more...</h1>-->
        </div>
        </div>
    
    </div>
    
    </div>

    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
<?php ob_end_flush(); ?>