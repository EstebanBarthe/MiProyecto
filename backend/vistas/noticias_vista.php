<?php

	require_once("modelos/noticias_modelo.php");
	$rutaPagina = "noticias";
	
	$objNoticias = new Noticias_modelo();

	$respuesta = array();
	if(isset($_POST["accion"]) && $_POST['accion'] == "ingresar" ){

			$archivo = $objNoticias->subirImagen($_FILES['imagen'], "800","600");

			if($archivo){
				$datos = array();
				$datos['id']			= "";
				$datos['titulo'] 		= isset($_POST['txtTitulo'])?$_POST['txtTitulo']:"";
				$datos['cuerpo'] 		= isset($_POST['txtCuerpo'])?$_POST['txtCuerpo']:"";
				$datos['categorias']	= isset($_POST['txtCategorias'])?$_POST['txtCategorias']:"";

			$objNoticias->__constructor($datos);
			$respuesta = $objNoticias->ingresar();
			}else{
				$respuesta = array();
				$respuesta['id'] = "Error";
				$respuesta['mensaje'] = "Error al subir la imagen";
			}
	}	

	if(isset($_POST["accion"]) && $_POST['accion'] == "editar" ){

		$datos = array();
		$datos['id'] 			= isset($_POST['txtId'])?$_POST['txtId']:"";	
		$datos['titulo'] 		= isset($_POST['txtTitulo'])?$_POST['txtTitulo']:"";
		$datos['cuerpo'] 		= isset($_POST['txtCuerpo'])?$_POST['txtCuerpo']:"";
		$datos['categorias']	= isset($_POST['txtCategorias'])?$_POST['txtCategorias']:"";
		
		$archivo = $objNoticias->subirImagen($_FILES['imagen'], "800","600");
		if($archivo){
			
			$datos['imagen'] 	= $archivo;
			
		}else{

			$datos['imagen'] 	= "";

		}
		$objNoticias->__constructor($datos);
		$respuesta = $objNoticias->editar();

	}	


	if(isset($_POST["accion"]) && $_POST['accion'] == "borrar" && isset($_POST["id"]) && $_POST['id'] != ""){

		$id = $_POST['id'];
		$objNoticias->cargar($id);
		$respuesta = $objNoticias->borrar();

	}
	

	
	$buscar = isset($_POST['buscador'])?$_POST['buscador']:"";
	if($buscar == "" && isset($_GET['buscador']) && $_GET['buscador'] != ""){
		$buscar = $_GET['buscador'];
	}

	$arrayFiltros = array("buscar"=>$buscar);

	$totalMaximo = $objNoticias->totalPaginas($arrayFiltros);
	if(isset($_GET['pagina']) && $_GET['pagina'] != ""){
		// Validados que la pagina siempre sea un numero
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
		$paginaSiguente = $pagina + 1;
		if($paginaSiguente > $totalMaximo){
			$paginaSiguente = $totalMaximo;
		}

	}else{
		$pagina  		= 1;
		$paginaAnterior = 1;
		$paginaSiguente = 2;
	}

	
	$arrayFiltros['pagina'] = $pagina - 1;
	$listaNoticias = $objNoticias->listar($arrayFiltros);


	

?>


<h1>Noticias</h1>

	<!-- Modal ingreso -->
	<div id="modal1" class="modal modal-fixed-footer">
		<div class="modal-content">
			<h4>Ingresar Noticias</h4>
				<div class="row">
					<form action="index.php?r=<?=$rutaPagina?>" enctype="multipart/form-data" method="POST" class="col s12">
						<div class="row">
							<div class="input-field col s6">
								<input placeholder="Titulo" id="titulo" type="text" class="validate" name="txtTitulo">
								<label for="titulo">Titulo</label>
							</div>
							<div class="input-field col s6">
								<select name = "txtCategorias">
									<option value="1">Futbol 5</option>
									<option value="2">Futbol 7</option>
								</select>
								<label for="categorias">Categorias</label>
							</div>
							<div class="input-field col s6">
								<input placeholder="Cuerpo" id="cuerpo" type="text" class="validate" name="txtCuerpo">
								<label for="cuerpo">Cuerpo</label>
							</div>
						</div>
					</div>
					<div class="file-field input-field">
						<div class="btn green darken-3">
							<span>Imagen</span>
							<input type="file" name="imagen" multiple>
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text" placeholder="Subir un archivo">
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
	if(isset($_GET['accion']) && $_GET['accion'] == "editar" && isset($_GET['i']) && $_GET['i'] != ""  ){
		$objNoticias->cargar($_GET['i']);

?>
	<div class="grey lighten-3 center-align">	
		<h3>Editar Noticias</h3>
		<form action="index.php?r=<?=$rutaPagina?>" enctype="multipart/form-data" method="POST" class="container col s10">
			<div class="row">
				<div class="input-field col s12">
					<input placeholder="id" id="id" type="text" class="validate" value="<?=$objNoticias->obtenerID()?>" disabled>
					<input type="hidden" name="txtId" value="<?=$objNoticias->obtenerID()?>">
					<label for="id">id</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<input id="titulo" type="text" class="validate" name="txtTitulo" value="<?=$objNoticias->obtenerTitulo()?>">
					<label for="titulo">Nombre</label>
				</div>
			</div>	
			<div class="row">
				<div class="input-field col s12">
					<textarea id="cuerpo" class="materialize-textarea" name="txtCuerpo"><?=$objNoticias->obtenerCuerpo()?></textarea>
					<label for="cuerpo">Cuerpo</label>
				</div>
				<div class="input-field col s6">
					<select placeholder="Categorias" id="categorias" type="text" class="validate" name="txtCategorias" value="<?=$objNoticias->obtenerCategorias()?>">
						<option value="1">Futbol 5</option>
						<option value="2">Futbol 7</option>
					</select>
					<label for="categorias">Categorias</label>
				</div>
			</div>
			<div class="file-field input-field">
					<div class="btn">
						<span>Imagen</span>
						<input type="file" name="imagen" multiple>
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text" placeholder="Ingresar">
					</div>
			</div>
			<button class="btn waves-effect waves-light green darken-3" type="submit" name="accion" value="editar">Enviar
				<i class="material-icons right">send</i>
			</button>
		</form>
	
	</div>
<?php
	}
?>

<?PHP 
	if(isset($_GET['accion']) && $_GET['accion'] == "borrar" && isset($_GET['i']) && $_GET['i'] != ""  ){
?>
	<div class="green lighten-3 center-align">	
		<form action="index.php?r=<?=$rutaPagina?>" method="POST" class="col s12">
			<h3>Borrar la noticia</h3>
			<h4>Desea borra la noticia <?=$_GET['i']?></h4>
			<input type="hidden" name="id" value="<?=$_GET['i']?>">
			<button class="btn waves-effect waves-light red" type="submit" name="accion" value="borrar">Eliminar
				<i class="material-icons right">deleted</i>
			</button>
			<button class="btn waves-effect waves-light blue" type="submit" name="accion" value="cancelar">Cancelar
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
					<th class="" colspan=3>
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
					<th class="center" colspan=2>
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
                    <th class="center">ID</th>
                    <th class="center">Titulo</th>
					<th class="center">Cuerpo</th>
					<th class="center">Categorias</th>
					<th class="center">Imagen de la noticia</th>
					<th style="width:100px">Botones</th>
				</tr>
			</thead>
			<tbody>
		<?php
        	foreach ($listaNoticias as $noticias) {
        ?>
					<tr>
                        <td class="center"><?=$noticias['id']?></td>
                        <td class="center"><?=$noticias['titulo']?></td>
						<td class="center"><?=$noticias['cuerpo']?></td>
                        <td class="center"><?=$noticias['categorias']?></td>
						<td class="center">
							<img src="archivos/imagenes/<?=$noticias['imagen']?>" style="width:200px">
						</td>
                        <td>
                            <div class="right">
                                <a href="index.php?r=<?=$rutaPagina?>&accion=editar&i=<?=$noticias['id']?>" class="waves-effect waves-light btn btn waves-effect waves-light green darken-3">
                                    <i class="material-icons left">edit</i>
                                </a>
                                <a href="index.php?r=<?=$rutaPagina?>&accion=borrar&i=<?=$noticias['id']?>" class="waves-effect waves-light btn red">
                                    <i class="material-icons left">delete</i>
                                </a>
                            <div>
                        </td>
					</tr>
	<?php
    	}
	?>
					<tr class="teal darken-4">
						<td colspan="6">
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