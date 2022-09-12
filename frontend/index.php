<?php

	require_once("PHP/modelos/noticias_modelo.php");
	require_once("PHP/modelos/deportistas_modelo.php");
	require_once("PHP/modelos/usuarioWeb_modelo.php");



	@session_start();

	$objUsuario = new usuarioWeb_modelo();
	if( (isset($_POST['txtDocumento']) && $_POST['txtDocumento'] != "") && (isset($_POST['txtClave']) && $_POST['txtClave'] != "") ){

		print("Login");	
		$documento 	= $_POST['txtDocumento'];
		$clave 		= $_POST['txtClave'];

		$respuesta = $objUsuario->login($documento, $clave );

		if($respuesta){	
			print("Login");		
			$_SESSION['docAlumno'] = $objUsuario->obtenerDocumento();
			$_SESSION['nomAlumno'] = $objUsuario->obtenerNombre();
		}

	}

	$nombreLogin = "";
	if(isset($_SESSION['nomAlumno']) && $_SESSION['nomAlumno'] != ""){
		$nombreLogin = $_SESSION['nomAlumno'];
	}

	$objDeportistas = new Deportistas_modelo();
	$listaDeportistas = $objDeportistas->listar();


	$objNoticias = new Noticias_modelo();
	$listaNoticias = $objNoticias->listar();


	


?>
<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<meta name="viewport" content="width=device-width, initial-scale=1"/>
			<title>Parallax Template - Materialize</title>

			<!-- CSS  -->
			<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
			<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
			<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
		</head>
		<body>
		<nav class="nav-extended">
    		<div class="nav-wrapper green darken-4">
					<a id="logo" href="#" class="brand-logo center black-text">PMF.FC</a>
					<ul class="right hide-on-med-and-down">
				<li>
					<a href="#" class="black-text">
						<?= $nombreLogin ?>
					</a>
				</li>

<?php
			if($nombreLogin == ""){
?>
				<li>
					<a class="waves-effect waves-light btn modal-trigger green darken-3" href="#modal1">Login</a>
				</li>
<?php
			}else{
?>
				<li>
					<a class="waves-effect waves-light btn modal-trigger green darken-3" href="#modal2">Logout</a>
				</li>
<?php
			}
?>
			</ul>

					<ul id="nav-mobile" class="sidenav">
						<li><a href="#">Navbar Link</a></li>
					</ul>
					<a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
				</div>
			</nav>
			<!-- Modal Structure -->
			<div id="modal1" class="modal">
					<div class="modal-content">
						<h4>Ingresar Usuario</h4>
						<div class="container">
							<form action="index.php?" method="POST" class="col s12">
								<div class="row">
									<div class="input-field col s12">
										<input placeholder="Documento" id="documento" type="text" class="validate" name="txtDocumento">
										<label for="documento">Documento</label>
									</div>
								</div>				
								<div class="row">
									<div class="input-field col s12">
										<input placeholder="Clave" id="clave" type="text" class="validate" name="txtClave">
										<label for="clave">Clave</label>
									</div>
								</div>	
								<button class="btn waves-effect waves-light" type="submit" >Entrar
									<i class="material-icons right">send</i>
								</button>
							</form>
						</div>
					</div>
				</div>
				<div id="modal2" class="modal">
					<div class="modal-content">
						<h4>Usted desea salir?</h4>
						<div class="container">
							<form action="logout.php?" method="POST" class="col s12">
								<button class="btn waves-effect waves-light red" type="submit" name="accion" value="salir">Salir
									<i class="material-icons right">send</i>
								</button>
								<button class="btn waves-effect waves-light green" name="accion" value="nada">Cancelar
									<i class="material-icons right">send</i>
								</button>
							</form>
						</div>
					</div>
				</div>
			<div id="index-banner" class="parallax-container">
				<div class="section no-pad-bot">
					<div class="container">
						<br><br>
						<br><br>
					</div>
				</div>
				<div class="parallax"><img src="imagenes/parallax.jpg" alt="Unsplashed background img 1"></div>
			</div>
			<div class="container">
				<div class="section">
					<!--   Icon Section   -->
					

					<div class="row">
<?php 
foreach($listaNoticias as $noticias){;
?>					
						<div class="col s12 m4">
							<div class="card">
								<div class="card-image waves-effect waves-block waves-light"><?=$noticias['titulo']?>
									<img class="activator" src="http://localhost/mi_proyecto/backend/archivos/imagenes/<?=$noticias['imagen']?>">
								</div>
								<div class="card-content">
									<span class="card-title activator grey-text text-darken-4">Card Title<i class="material-icons right">more_vert</i></span>
									<p>
										<a href="#">This is a link</a>
									</p>
								</div>
								<div class="card-reveal">
									<span class="card-title grey-text text-darken-4">Card Title<i class="material-icons right">close</i></span>
									<p>
										<h3><?=$noticias['titulo']?></h3>
										<h5>Categoria: <?= $noticias['categorias']?></h5>
										<h5> <?= $noticias['cuerpo']?></h5>
									</p>
								</div>
							</div>
							
						</div>
<?php }?>
						</div>

				</div>
			</div>


			<div class="parallax-container valign-wrapper">
				<div class="section no-pad-bot">
					<div class="container">
						<div class="row center">
							<h5 class="header col s12 light">A modern responsive front-end framework based on Material Design</h5>
						</div>
					</div>
				</div>
				<div class="parallax"><img src="imagenes/parallax.jpg" alt="Unsplashed background img 2"></div>
			</div>

			<div class="container">
				<div class="section">

					<div class="row">
<?php 
	foreach($listaDeportistas as $deportistas){;
		?>				
					<div class="col s12 center">
							<div class="card">
								<div class="card-image waves-effect waves-block waves-light"><?=$deportistas['nombre']?>
									<img class="activator" src="http://localhost/mi_proyecto/backend/archivos/imagenes/<?=$deportistas['imagen']?>">
								</div>
								<div class="card-content">
									<span class="card-title activator grey-text text-darken-4">Card Title<i class="material-icons right">more_vert</i></span>
									<p>
										<a href="#">This is a link</a>
									</p>
								</div>
								<div class="card-reveal">
									<span class="card-title grey-text text-darken-4">Card Title<i class="material-icons right">close</i></span>
							<h4>Plantel 2021/22</h4>
							<p>
								<h3><?=$deportistas['nombre']?></h3>
								<h5><?= $deportistas['apellido']?></h5>
								<h5> <?= $deportistas['documento']?></h5>
								<h5><?= $deportistas['fechaNacimiento']?></h5>
								<h5> <?= $deportistas['genero']?></h5>
								<h5> <?= $deportistas['categorias']?></h5>
								<h5><?= $deportistas['imagen']?></h5>
								<h5> <?= $deportistas['posicion']?></h5>
							</p>
						</div>
					</div>
<?php 
  }
  ?>
				</div>
			</div>


			<div class="parallax-container valign-wrapper">
				<div class="section no-pad-bot">

				</div>
				<div class="parallax"><img src="imagenes/parallax.jpg" alt="Unsplashed background img 3"></div>
			</div>

			<footer class="page-footer green darken-3 ">
				<div class="container">
					<div class="row">
						
						<div class="container">
							<h5 class="black-text">Contactos:</h5>
							<p class="black-text">Telefono: 092955041 E.mail: pmhoficial@gmail.com</p>
						</div>

					</div>
				</div>

			</footer>


			<!--  Scripts-->
			<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
			<script src="js/materialize.js"></script>
			<script src="js/init.js"></script>
			<script>			
			document.addEventListener('DOMContentLoaded', function() {
				M.AutoInit();
				var elems = document.querySelectorAll('.datepicker');
    			var instances = M.Datepicker.init(elems, options);
			});
		</script>
		</body>
	</html>
