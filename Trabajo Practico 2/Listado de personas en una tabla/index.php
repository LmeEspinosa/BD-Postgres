<html>
<head>
   <title>TP BD 2</title>
</head>
<body>
<H1>LISTADO DE PERSONAS</H1>
<?php
   include("sql.php");
   $link=Conectarse();
		if ($link==0)
		{
			echo "<H1>Error en apertura de bases de datos.</H1>";
			exit();
		}
	
	$result=pg_query("select * from tabla",$link);
?>
   
   <!-- Escribimos título de las tablas -->
   <TABLE BORDER=1 CELLSPACING=1 CELLPADDING=1>
    <TR>
		<TD><b>&nbsp;ID&nbsp;</b></TD>
		<TD><b>&nbsp;NAME&nbsp;</b></TD>
        </TR>

<?php
   //$row["ID"] NO ES LO MISMO QUE $row["id"] o que $row["Id"]
   while($row = pg_fetch_array($result)) {
	  echo "<TR>";
	  echo "<TD>&nbsp;" . $row["id"] . "</TD>";
	  echo "<TD>&nbsp;" . $row["name"] . "</TD>";
	  echo "</TR>";
   }
   
   //liberamos memoria que ocupa la consulta...
   pg_free_result($result);
   
   //cerramos la conexión con el motor de BD
   pg_close($link);
?>

</table>

	<br>
	<br>
	
	<a href="abm.php?accion=alta">Agregar</a> <br>
	<a href="abm.php?accion=modificacion">Modificar</a> <br>
	<a href="abm.php?accion=baja">Borrar</a> <br>
	
</body>
</html>