<?php

	require_once("modelos/administrador_modelo.php");
	@session_start();

	$nombre = isset($_POST['txtNombre'])?$_POST['txtNombre']:"";
	$clave 	= isset($_POST['txtClave'])?$_POST['txtClave']:"";

	if($nombre != "" && $clave != ""){

		$objAdministrador = new Administrador_modelo();
		$respuesta = $objAdministrador->login($nombre, $clave);

		echo("Estoy haciendo el login:");
		if($respuesta){

			$_SESSION['usuario'] = $nombre;
			header("Location:index.php");

		}else{
			unset($_SESSION['usuario'] );
			session_destroy();
			echo("Error en el login");	
		}
	
	}else{
		unset($_SESSION['usuario']);
		session_destroy();
	}


?>

<!DOCTYPE html>
    <html>
        <head>
            <!--Import Google Icon Font-->
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            <!--Import materialize.css-->
            <link type="text/css" rel="stylesheet" href="web/css/materialize.min.css"  media="screen,projection"/>
            <!--Let browser know website is optimized for mobile-->
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <style>
                body {
                    display: flex;
                    min-height: 100vh;
                    flex-direction: column;
                    }
                main{
                    flex: 1 0 auto;
                    }
                table.striped > tbody > tr:nth-child(odd) {
                    background-color: #a5d6a7;
                    }
                    .pagination li.active {
                        background-color: #a5d6a7;
                    }
            </style>
        </head>
        <body>
            <!--JavaScript at end of body for optimized loading-->
            <script type="text/javascript" src="web/js/materialize.min.js"></script>
            <nav>
                <div class="nav-wrapper green darken-4">
                    <a href="#!" class="brand-logo center"><span class="grey-text text-darken-4">PMH.FC</span></a>
                        <ul class="right hide-on-med-and-down">
                        <li>
                            <a href="index.php?r=deportistas"><i class="material-icons">sports_soccer</i></a>
                        </li>
                        <li>
                            <a href="index.php?r=noticias"><i class="material-icons"><span class="material-icons">notifications</span></i></a>
                        </li>
                        </ul>
                </div>
            </nav>
            <body>
                <main>
                <div class="container">
                    <div class="row">
                        <div class="col s3">
                        </div>
                        <div class="col s6 center-align">
                            <div>
                                <h3>Login</h3>
                            </div>
                            <form action="login.php?" method="POST" class="col s12">
                                <div class="row">
                                    <div class="input-field col s12">
									<input placeholder="nombre" id="nombre" type="text" class="validate" name="txtNombre">
									<label for="nombre">Nombre</label>
								</div>
							</div>				
							<div class="row">
								<div class="input-field col s12">
									<input placeholder="Clave" id="clave" type="text" class="validate" name="txtClave">
									<label for="clave">Clave</label>
                                </div>	
                                <button class="btn waves-effect waves-light" type="submit" >Entrar
                                    <i class="material-icons right">send</i>
                                </button>
                            </form>
                        </div>
                        <div class="col s3">
                        </div>	
                    </div>
                </div>
                </main>      
                    <footer class="page-footer green darken-4">
                        <div class="container">
                            <div class="row">
                                <div class="col l6 s12"></div>
                            </div>
                        </div>
                        <div class="footer-copyright">
                            <div class="container">
                                © 2014 Copyright Text
                                <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
                            </div>
                        </div>
                    </footer>
                    <script type="text/javascript" src="web/js/materialize.min.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                        var elems = document.querySelectorAll('.carousel');
                        var instances = M.Carousel.init(elems, options);
                        });
                        M.AutoInit();
                    </script>
                </body>
        </body>
    </html>