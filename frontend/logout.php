<?php


		if(isset($_POST['accion']) && $_POST['accion'] == "salir"){

			@session_start();
			unset($_SESSION['documento']);
			unset($_SESSION['nombre']);
			session_destroy();

		}

		header("Location:index.php");



?>