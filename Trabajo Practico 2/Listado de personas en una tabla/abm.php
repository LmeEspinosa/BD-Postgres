<html>
	<head>
		<!-- de acuerdo al contenido de la variable "accion", escribimos el título -->
		<?php
			if ($_GET["accion"] == "alta")
				echo "<title>" . "Alta de registro" . "</title>";

			if ($_GET["accion"] == "baja")
				echo "<title>" . "Baja en la agenda" . "</title>";

			if ($_GET["accion"] == "modificacion")
				echo "<title>" . "Modificaci&oacute;n en agenda" . "</title>";
		?>
	</head>

	<body>

		<?php
			// Acá mostramos la pantalla de carga de ALTAS.
			if ($_GET["accion"] == "alta")
			{
				echo "<h1>Agregar un registro</h1>";
				echo "<br>";
				echo "<FORM ACTION=\"abm.php\" METHOD=\"GET\">";
					echo "name: " . "<INPUT TYPE=\"TEXT\" NAME=\"txtname\">" . "<BR>";
					echo "<BR>";
					echo "<INPUT TYPE=\"submit\" NAME=\"OK\">";
					echo "<INPUT TYPE=\"hidden\" NAME=\"accion\" VALUE=\"realizar_alta\">";
				echo "</FORM>";

				echo "<br>" . "<a href=\"/\">Volver a la agenda</a>";

				exit();
			}
		?>

		<?php
			// Acá, en base a los datos recibidos (nombre, telefono, direccion, etc), hacemos el alta.
			if ($_GET["accion"] == "realizar_alta")
			{
				include("sql.php");

				$name = $_GET["txtname"];
				alta ($name);

				echo "<br>" . "<a href=\"/\">Volver a la agenda</a>";
			}
		?>

		<?php
			//Acá solicitamos el ID para poder modificar el registro.
			if ($_GET["accion"] == "modificacion")
			{
				echo "<h1>Modificar un registro</h1>";
				echo "<br>";
				echo "<FORM ACTION=\"abm.php\" METHOD=\"GET\">";
					echo "ID: " . "<INPUT TYPE=\"TEXT\" NAME=\"txtId\">" . "<BR>";
					echo "<INPUT TYPE=\"hidden\" NAME=\"accion\" VALUE=\"datos_modificacion\">";
				echo "</FORM>";

				echo "<br>" . "<a href=\"/\">Volver a la agenda</a>";

				exit();
			}
		?>


		<?php
			// Acá, en base al ID recibido, pedimos los datos para MODIFICAR.
			if ($_GET["accion"] == "datos_modificacion")
			{
				include("sql.php");

				//me conecto a la BD y SELECCIONO el registro cuyo ID fue pasado.
				$conexion = Conectarse();

					if (!$conexion)
					{
						echo "<h1>Error al intentar conectar a BD</h1>";
						echo "<br>" . "<a href=\"/\">Volver a la agenda</a>";
						exit();
					}

				$id = $_GET["txtId"];
				$consulta = "SELECT * FROM tabla WHERE id = $id";

				echo $consulta . "<br>";

				$resultado = pg_query($consulta, $conexion);

				$fila = pg_fetch_array($resultado);

				if (!$fila)
				{
					echo "<h1>Registro inexistente</h1>";
					echo "<br>" . "<a href=\"/\">Volver a la agenda</a>";
					exit();
				}

				//cargo los datos del registro en variables para que sea más cómodo trabajar.

                $name = $fila["name"];

				   //liberamos memoria que ocupa la consulta...
				   pg_free_result($resultado);

				   //cerramos la conexión con el motor de BD
				   pg_close($conexion);

				/*
				ahora que teóricamente tengo los datos del registro que quiero modificar, muestro
				el formulario de carga.
				*/
				echo "<h1>Modificar un registro</h1>";
				echo "<br>";
				echo "<FORM ACTION=\"abm.php\" METHOD=\"GET\">";
				echo "name: " . "<INPUT TYPE=\"TEXT\" NAME=\"txtname\" VALUE=\"$name\">" . "<BR>";

                                echo "<BR>";
				echo "<INPUT TYPE=\"submit\" NAME=\"submit\">";
				echo "<INPUT TYPE=\"hidden\" NAME=\"accion\" VALUE=\"realizar_modificacion\">";
				echo "<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=\"$id\">";
				echo "</FORM>";

				echo "<br>" . "<a href=\"/\">Volver a la agenda</a>";
			}
		?>

		<?php
			// Acá, en base al ID recibido, hacemos la modificación.
			if ($_GET["accion"] == "realizar_modificacion")
			{
				include("sql.php");

                $id = $_GET["id"];
				$name = $_GET["txtname"];

				modificacion($id, $name);
				echo "<br>" . "<a href=\"/\">Volver a la agenda</a>";
			}
		?>

		<?php
			// Acá mostramos la pantalla de carga de BAJAS.
			if ($_GET["accion"] == "baja")
			{
				echo "<h1>Dar de baja un registro</h1>";
				echo "<br>";
				echo "<FORM ACTION=\"abm.php\" METHOD=\"GET\">";
					echo "ID: " . "<INPUT TYPE=\"TEXT\" NAME=\"txtId\">" . "<BR>";
					echo "<INPUT TYPE=\"hidden\" NAME=\"accion\" VALUE=\"realizar_baja\">";
				echo "</FORM>";
				
				echo "<br>" . "<a href=\"/\">Volver a la agenda</a>";
				
				exit();
			}
		?>

		<?php
			// Acá, en base al ID recibido, hacemos la baja.
			if ($_GET["accion"] == "realizar_baja")
			{
				include("sql.php");
				
				$id = $_GET["txtId"];
				
				baja($id);
				
				echo "<br>" . "<a href=\"/\">Volver a la agenda</a>";
			}
		?>

	</body>
</html>