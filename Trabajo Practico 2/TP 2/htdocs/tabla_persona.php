<?php
$conn = pg_connect("host=localhost dbname=TP2 user=postgres password=admin")or die('ERROR AL CONECTAR: ' . pg_last_error());

$sql = 'SELECT * 
		FROM persona';
		
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
<html>
<head>
	<title>TP2 - Base de Datos 2</title>
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
	
</body>
</html>