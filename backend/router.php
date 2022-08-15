<?php


		///backend/index.php?r=

		if(isset($_GET['r']) && $_GET['r'] != ""){

			$ruta = $_GET['r'];    

			if($ruta == "Administrador"){
				include("vistas/admin_vista.php");
			} elseif($ruta == "Deportistas"){
				include("vistas/deportistas_vista.php");
			} elseif($ruta == "Menu"){
				include("vistas/menu_vista.php");
			} elseif($ruta == "Noticias"){
				include("vistas/noticias_vista.php");
			} else{
				echo("<h1>Bienvenidos</h1>");
			}

		} 


?>
