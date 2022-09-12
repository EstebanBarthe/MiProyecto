<?php

	require_once("modelos/deportistas_modelo.php");
	$rutaPagina = "deportistas";
	
	$objDeportistas = new Deportistas_modelo();

	$respuesta = array();
	if(isset($_POST["accion"]) && $_POST['accion'] == "ingresar" ){

		$archivo = $objDeportistas->subirImagen($_FILES['imagen'], "800","600");

		if($archivo){
		$datos = array();
		$datos['documento'] 		= isset($_POST['txtDocumento'])?$_POST['txtDocumento']:"";		
		$datos['nombre'] 			= isset($_POST['txtNombre'])?$_POST['txtNombre']:"";
		$datos['apellido']			= isset($_POST['txtApellido'])?$_POST['txtApellido']:"";
		$datos['genero'] 			= isset($_POST['txtGenero'])?$_POST['txtGenero']:"";
		$datos['fechaNacimiento'] 	= isset($_POST['txtFechaNacimiento'])?$_POST['txtFechaNacimiento']:"";
		$datos['categorias'] 		= isset($_POST['txtCategorias'])?$_POST['txtCategorias']:"";
		$datos['posicion'] 			= isset($_POST['txtPosicion'])?$_POST['txtPosicion']:"";
		$datos['imagen'] 			= $archivo;
		$objDeportistas->__constructor($datos);
		$respuesta = $objDeportistas->ingresar();
		}else{
			$respuesta = array();
			$respuesta['id'] = "Error";
			$respuesta['mensaje'] = "Error al subir la imagen";
		}
	}

	if(isset($_POST["accion"]) && $_POST['accion'] == "editar" ){

		$datos = array();
		$datos['documento'] 		= isset($_POST['txtDocumento'])?$_POST['txtDocumento']:"";		
		$datos['nombre'] 			= isset($_POST['txtNombre'])?$_POST['txtNombre']:"";
		$datos['apellido']			= isset($_POST['txtApellido'])?$_POST['txtApellido']:"";
		$datos['genero'] 			= isset($_POST['txtGenero'])?$_POST['txtGenero']:"";
		$datos['fechaNacimiento'] 	= isset($_POST['txtFechaNacimiento'])?$_POST['txtFechaNacimiento']:"";
		$datos['categorias'] 		= isset($_POST['txtCategorias'])?$_POST['txtCategorias']:"";
		$datos['posicion'] 			= isset($_POST['txtPosicion'])?$_POST['txtPosicion']:"";
		
		$archivo = $objDeportistas->subirImagen($_FILES['imagen'], "800","600");
		if($archivo){
			
			$datos['imagen'] 	= $archivo;
			
		}else{

			$datos['imagen'] 	= "";

		}
		$objDeportistas->__constructor($datos);
		$respuesta = $objDeportistas->editar();

	}	

	if(isset($_POST["accion"]) && $_POST['accion'] == "borrar" && isset($_POST["documento"]) && $_POST['documento'] != ""){

		$documento = $_POST['documento'];
		$objDeportistas->cargar($documento);
		$respuesta = $objDeportistas->borrar();

	}

	$buscar = isset($_POST['buscador'])?$_POST['buscador']:"";
	if($buscar == "" && isset($_GET['buscador']) && $_GET['buscador'] != ""){
		$buscar = $_GET['buscador'];
	}

	$arrayFiltros = array("buscar"=>$buscar);

	$totalMaximo = $objDeportistas->totalPaginas($arrayFiltros);
	if(isset($_GET['pagina']) && $_GET['pagina'] != ""){

		$pagina = (int)$_GET['pagina'];
		
		if($pagina < 1){
			$pagina = 1;
		}elseif($pagina > $totalMaximo){
			$pagina = $totalMaximo;
		}elseif(!is_int($pagina)){
			$pagina = 1;
		}
		$paginaAnterior = $pagina - 1;
		if($paginaAnterior < 1){
			$paginaAnterior = 1;
		}
		$paginaSiguiente = $pagina + 1;
		if($paginaSiguiente > $totalMaximo){
			$paginaSiguiente = $totalMaximo;
		}

	}else{
		$pagina  		= 1;
		$paginaAnterior = 1;
		$paginaSiguiente= 2;
	}

	$arrayFiltros['pagina'] = $pagina - 1;
	$listaDeportistas = $objDeportistas->listar($arrayFiltros);
	

?>


<h1>Deportistas</h1>

	<!-- Modal ingreso -->
	<div id="modal1" class="modal modal-fixed-footer">
		<div class="modal-content">
		<h4>Ingresar Deportista</h4>
			<div class="row">
				<form action="index.php?r=<?=$rutaPagina?>" enctype="multipart/form-data" method="POST" class="col s12">
					<div class="row">
						<div class="input-field col s12">
							<input placeholder="Documento" id="documento" type="text" class="validate" name="txtDocumento">
							<label for="documento">Documento</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s6">
							<input placeholder="Nombre" id="nombre" type="text" class="validate" name="txtNombre">
							<label for="nombre">Nombre</label>
						</div>
						<div class="input-field col s6">
							<input placeholder="Apellido" id="apellido" type="text" class="validate" name="txtApellido">
							<label for="apellido">Apellido</label>
						</div>
						<div class="input-field col s6">
							<select name = "txtGenero">
								<option value="1">Masculino</option>
								<option value="2">Femenino</option>
								<option value="3">Otros</option>
							</select>
							<label for="genero">Genero</label>
						</div>
						<div class="input-field col s6">
							<select name = "txtCategorias">
								<option value="1">Futbol 5</option>
								<option value="2">Futbol 7</option>
							</select>
							<label for="categorias">Categorias</label>
						</div>
						<div class="input-field col s6">
							<select name = "txtPosicion">
								<option value="1">POR</option>
								<option value="2">DEF</option>
								<option value="3">MED</option>
								<option value="4">DEL</option>
							</select>
							<label for="posicion">Categorias</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s6">
							<input placeholder="Fecha Nacimiento" id="fechaNacimiento" type="date" class="validate" name="txtFechaNacimiento">
							<label for="fechaNacimiento">Fecha Nacimiento</label>
						</div>
					</div>
					<div class="file-field input-field">
						<div class="btn green darken-3">
							<span>Foto</span>
							<input type="file" name="imagen" multiple>
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text" placeholder="Subir un archivo">
						</div>
					</div>
				</div>			
				<button class="btn waves-effect waves-light green darken-3" type="submit" name="accion" value="ingresar">Enviar
					<i class="material-icons right">send</i>
				</button>
			</form>
		</div>

	</div>

<?PHP 
	if(isset($respuesta['codigo']) && $respuesta['codigo'] == "Error"  ){
?>
	<div class="red center-align">	
		<h3><?=$respuesta['mensaje']?></h3>
	</div>
<?PHP
	}
?>
<?PHP 
	if(isset($respuesta['codigo']) && $respuesta['codigo'] == "OK"  ){
?>
	<div class="green center-align">	
		<h3><?=$respuesta['mensaje']?></h3>
	</div>
<?PHP
	}
?>

<?PHP 
	if(isset($_GET['accion']) && $_GET['accion'] == "editar" && isset($_GET['deportistas']) && $_GET['deportistas'] != ""  ){
		$objDeportistas->cargar($_GET['deportistas']);

?>
	<div class="grey lighten-3 center-align">	
		<h3>Editar Deportista</h3>
		<form action="index.php?r=<?=$rutaPagina?>" enctype="multipart/form-data" method="POST" class="container col s10">
			<div class="row">
				<div class="input-field col s12">
					<input placeholder="Documento" id="documento" type="text" class="validate" value="<?=$objDeportistas->obtenerDocumento()?>" disabled>
					<input type="hidden" name="txtDocumento" value="<?=$objDeportistas->obtenerDocumento()?>">
					<label for="documento">Documento</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s6">
					<input placeholder="Nombre" id="nombre" type="text" class="validate" name="txtNombre" value="<?=$objDeportistas->obtenerNombre()?>">
					<label for="nombre">Nombre</label>
				</div>
				<div class="input-field col s6">
					<input placeholder="Apellido" id="apellido" type="text" class="validate" name="txtApellido" value="<?=$objDeportistas->obtenerApellido()?>">
					<label for="apellido">Apellido</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s6">
					<input placeholder="Fecha Nacimiento" id="fechaNacimiento" type="date" class="validate" name="txtFechaNacimiento" value="<?=$objDeportistas->obtenerFechaNacimiento()?>">
					<label for="fechaNacimiento">Fecha Nacimiento</label>
				</div>
				<div class="input-field col s6">
					<select placeholder="Genero" id="genero" type="text" name="txtGenero" value="<?=$objDeportistas->obtenerGenero()?>">
						<option value="1">Masculino</option>
						<option value="2">Femenino</option>
						<option value="3">Otros</option>
					</select>
					<label for="genero">Genero</label>
				</div>
				<div class="input-field col s6">
					<select placeholder="Categorias" id="categorias" type="text" class="validate" name="txtCategorias" value="<?=$objDeportistas->obtenerCategorias()?>">
						<option value="1">Futbol 5</option>
						<option value="2">Futbol 7</option>
					</select>
					<label for="categorias">Categorias</label>
				</div>
				<div class="input-field col s6">
					<select placeholder="Posicion" id="posicion" type="text" class="validate" name="txtPosicion" value="<?=$objDeportistas->obtenerPosicion()?>">
						<option value="1">POR</option>
						<option value="2">DEF</option>
						<option value="3">MED</option>
						<option value="4">DEL</option>
					</select>
					<label for="posicion">Posicion</label>
				</div>
			</div>
			<div class="file-field input-field">
					<div class="btn green darken-3">
						<span>Foto</span>
						<input type="file" name="imagen" multiple>
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text" placeholder="Ingresar imagen">
					</div>
			</div>			
			<button class="btn waves-effect waves-light" type="submit" name="accion" value="editar">Enviar
				<i class="material-icons right">send</i>
			</button>
		</form>
	
	</div>
<?php
	}
?>

<?PHP 
	if(isset($_GET['accion']) && $_GET['accion'] == "borrar" && isset($_GET['deportistas']) && $_GET['deportistas'] != ""){
?>
	<div class="green lighten-3 center-align">	
		<form action="index.php?r=<?=$rutaPagina?>" method="POST" class="col s12">
			<h3>Borrar Deportista</h3>
			<h4>¿Esta seguro de borrar al deportista?<?=$_GET['deportistas']?></h4>
			<input type="hidden" name="documento" value="<?=$_GET['deportistas']?>">
			<button class="btn waves-effect waves-light red" type="submit" name="accion" value="borrar">Eliminar
				<i class="material-icons right">deleted</i>
			</button>
			<button class="btn waves-effect waves-light green" type="submit" name="accion" value="cancelar">Cancelar
				<i class="material-icons right">cancel</i>
			</button>		
		</form>
	</div>
<?php
	}
?>

		<table class="striped">
			<thead>
				<tr>
					<th class="" colspan=4>
						<div class="left">
							<a class="waves-effect waves-light btn modal-trigger green darken-3" href="#modal1">
								<i class="material-icons left">group_add</i>Ingresar
							</a>
						</div>
						<div class="right">
							<a class="waves-effect waves-light btn modal-trigger green darken-3" href="index.php?r=<?=$rutaPagina?>">
								<i class="material-icons left">restore</i>Reset
							</a>
						</div>
					</th>
					<th class="center" colspan=6>
						<nav>
							<div class="nav-wrapper green darken-3">
								<form action="index.php?r=<?=$rutaPagina?>" method="POST" >
									<div class="input-field">
										<input id="search" type="search" name="buscador" required>
										<label class="label-icon" for="search">
											<i class="material-icons">search</i>
										</label>
										<i class="material-icons">close</i>
									</div>
								</form>
							</div>
						</nav>
					</th>
				</tr>
					<th class="center">Foto</th>
					<th class="center">Nombre</th>
					<th class="center">Apellido</th>
					<th class="center">Posicion</th>
					<th class="center">Genero</th>
					<th class="center">FechaNacimiento</th>
					<th class="center">Categorias</th>
					<th class="center">Documento</th>
					<th style="width:150px">Botones</th>
				</tr>
			</thead>
			<tbody>
		<?php
        	foreach ($listaDeportistas as $deportistas) {
        ?>
					<tr>
						<td class="center">
							<img src="archivos/imagenes/<?=$noticias['imagen']?>" style="width:200px">
						</td>
						<td class="center"><?= $deportistas['nombre'] ?></td>
						<td class="center"><?= $deportistas['apellido'] ?></td>
						<td class="center"><?= $deportistas['posicion'] ?></td>
						<td class="center"><?= $deportistas['genero'] ?></td>
						<td class="center"><?= $deportistas['fechaNacimiento'] ?></td>
						<td class="center"><?= $deportistas['categorias'] ?></td>
						<td class="center"><?= $deportistas['documento'] ?></td>
						<td>
							<div class="right">
								<a href="index.php?r=<?= $rutaPagina ?>&accion=editar&deportistas=<?= $deportistas['documento'] ?>" class="waves-effect waves-light btn green darken-3">
									<i class="material-icons left">edit</i>
								</a>
								<a href="index.php?r=<?= $rutaPagina ?>&accion=borrar&deportistas=<?= $deportistas['documento'] ?>" class="waves-effect waves-light btn red">
									<i class="material-icons left">delete</i>
								</a>
								<div>
						</td>
					</tr>
	<?php
    	}
	?>
					<tr class="teal darken-4">
						<td colspan="10">
							<ul class="pagination center">
								<li class="waves-effect">
									<a href="index.php?r=<?=$rutaPagina?>&pagina=1" class="black-text">
										<i class="material-icons">arrow_back</i>
									</a>
								</li>
								<li class="waves-effect">
									<a href="index.php?r=<?=$rutaPagina?>&pagina=<?=$paginaAnterior?>" class="black-text">
										<i class="material-icons">chevron_left</i>
									</a>
								</li>
								
							<?php
								for($i = 1; $i <= $totalMaximo; $i++){
									$class = "waves-effect";
									$classText = "white-text";
									if($i == $pagina){
										$class = "active";
										$classText = "black-text";
									}
							?>
								<li class="<?=$class?>" >
									<a href="index.php?r=<?=$rutaPagina?>&pagina=<?=$i?>" class="<?=$classText?>"><?=$i?></a>
								</li>

							<?PHP
												}
							?>
								<li class="waves-effect" >
									<a href="index.php?r=<?=$rutaPagina?>&pagina=<?=$paginaSiguiente?>" class="black-text">
										<i class="material-icons">chevron_right</i>
									</a>
								</li>
								<li class="waves-effect">
									<a href="index.php?r=<?=$rutaPagina?>&pagina=<?=$totalMaximo?>" class="black-text">
										<i class="material-icons">arrow_forward</i>
									</a>
								</li>
							</ul>
						</td>
					</tr>
			</tbody>
		</table>