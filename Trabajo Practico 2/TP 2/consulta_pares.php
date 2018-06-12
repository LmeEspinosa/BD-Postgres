<?php
$conn = pg_connect("host=localhost dbname=lucasespinosa user=lucasespinosa password=lme")or die('ERROR AL CONECTAR: ' . pg_last_error());

$sqldrop = 'drop view no_vio';
$querydrop = pg_query($conn,$sqldrop);


$sql = 'select distinct p1.id_usuario as u1, p2.id_usuario as u2
			from pelis_que_vio p1, pelis_que_vio p2
			where p1.id_usuario < p2.id_usuario
			and not exists (select 1 from pelis_que_vio p3 where p3.id_usuario = p1.id_usuario and not exists(
				select 1 from pelis_que_vio p4 where p4.id_pelicula = p3.id_pelicula and p4.id_usuario = p2.id_usuario))
				and not exists (select 1 from pelis_que_vio p5 where p5.id_usuario = p2.id_usuario and not exists(
					select 1 from pelis_que_vio p6 where p6.id_pelicula = p5.id_pelicula and p6.id_usuario = p1.id_usuario))';
		
$query = pg_query($conn, $sql);

if (!$query) {
	die ('SQL Error: ' . pg_last_error($conn));
}

$sql1 = 'create view no_vio as
select p.id from persona p where not exists (select 1 from pelis_que_vio where id_usuario = p.id);

select distinct p1.id_usuario as b1, p2.id_usuario as b2
from pelis_que_vio p1, pelis_que_vio p2
where p1.id_usuario < p2.id_usuario
and not exists (select 1 from pelis_que_vio p3 where p3.id_usuario = p1.id_usuario and not exists(
    select 1 from pelis_que_vio p4 where p4.id_pelicula = p3.id_pelicula and p4.id_usuario = p2.id_usuario))
    and not exists (select 1 from pelis_que_vio p5 where p5.id_usuario = p2.id_usuario and not exists(
    select 1 from pelis_que_vio p6 where p6.id_pelicula = p5.id_pelicula and p6.id_usuario = p1.id_usuario))
union    
select distinct
    case
        when no_vio_1.id < no_vio_2.id 
        then no_vio_1.id 
        else no_vio_2.id
    end,
    case
        when no_vio_1.id < no_vio_2.id 
        then no_vio_2.id 
        else no_vio_1.id
    end
    
from no_vio no_vio_1, no_vio no_vio_2
where no_vio_1.id <> no_vio_2.id
    
    
    and not exists (select 1 from no_vio no_vio_3 where no_vio_1.id = no_vio_3.id
            and not exists (select 1 from no_vio no_vio_4 where no_vio_2.id = no_vio_4.id))';
		
$query1 = pg_query($conn, $sql1);

if (!$query1) {
	die ('SQL Error: ' . pg_last_error($conn));

}




?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Displaying MySQL Data in HTML Table</title>	
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
	
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
		<caption class="title">Pares de personas que vieron el mismo grupo de peliculas</caption>
		<thead>
			<tr>
				<th>USUARIO 1</th>
				<th>USUARIO 2</th>
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
					<td>'.$row['u1'].'</td>
					<td>'.$row['u2'].'</td>
				</tr>';
			//$total += $row['amount'];
			$no++;
		}?>
		</tbody>
	</table>
	
	<h1>Table 2</h1>
	<table class="data-table">
		<caption class="title">Pares de personas que no vieron ninguna pelicula</caption>
		<thead>
			<tr>
				<th>USUARIO 1</th>
				<th>USUARIO 2</th>
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
					<td>'.$row['b1'].'</td>
					<td>'.$row['b2'].'</td>
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
        <div class="form-group">
          	<hr />
        </div>           
            <div class="form-group">
            	<a href="index.php">Home...</a>
            </div>   
    </div>
    
    </div>

    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>