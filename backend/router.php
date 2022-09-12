<?php


		///backend/index.php?r=

		if(isset($_GET['r']) && $_GET['r'] != ""){

			$ruta = $_GET['r'];    

			if($ruta == "deportistas"){
				include("vistas/deportistas_vista.php");
			} elseif($ruta == "noticias"){
				include("vistas/noticias_vista.php");
			} else{
				echo("<h1>Bienvenidos</h1>");
			}

		} 


?>
