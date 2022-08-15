<?php

require_once("modelos/deportistas_modelo.php");

$rutaPagina = "Deportistas";

$objDeportistas = new deportistas_modelo();

if(isset($_POST["accion"]) && $_POST['accion'] == "ingresar" ){

    $datos = array();
    $datos['documento'] 		= isset($_POST['txtDocumento'])?$_POST['txtDocumento']:"";		
    $datos['nombre'] 			= isset($_POST['txtNombre'])?$_POST['txtNombre']:"";
    $datos['apellido']			= isset($_POST['txtApellido'])?$_POST['txtApellido']:"";
    $datos['genero'] 	= isset($_POST['txtGenero'])?$_POST['txtGenero']:"";
    $datos['fechaNacimiento'] 	= isset($_POST['txtFechaNacimiento'])?$_POST['txtFechaNacimiento']:"";

    $objDeportistas->constructor($datos);
    $respuesta = $objDeportistas->ingresar();


}	

$buscar = isset($_POST['buscador']) ? $_POST['buscador'] : "";
if ($buscar == "" && isset($_GET['buscador']) && $_GET['buscador'] != "") {
    $buscar = $_GET['buscador'];
}

$arrayFiltros = array("buscar" => $buscar);

$totalMaximo = $objDeportistas->totalPaginas($arrayFiltros);

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

}else {
    $pagina = 1;
    $paginaAnterior = 1;
    $paginaSiguiente = 2;
}

$arrayFiltros = array("pagina" => $pagina - 1);

$listaDeportistas = $objDeportistas->listar();

print_r($listaDeportistas);
?>

<h1>Deportistas</h1>
	  <!-- El modal de ingreso -->
      <div id="modal1" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Ingresar Deportista</h4>
		<div class="row">
			<form action="index.php?r=<?=$rutaPagina?>" method="POST" class="col s12">
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
						<label for="Genero">Genero</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s6">
						<input placeholder="Fecha Nacimiento" id="fechaNacimiento" type="date" class="validate" name="txtFechaNacimiento">
						<label for="fechaNacimiento">Fecha Nacimiento</label>
					</div>

						</select>
				</div>
		</div>			
				<button class="btn waves-effect waves-light green darken-3" type="submit" name="accion" value="ingresar">Enviar
					<i class="material-icons right">send</i>
				</button>
			</form>
		</div>
	</div>
	<div class="modal-footer">
   		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
	</div>
</div>


<!-- Page Content goes here -->		


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
		<h3>Editar deportistas</h3>
		<form action="index.php?r=<?=$rutaPagina?>" method="POST" class="container col s10">
			<div class="row">
				<div class="input-field col s12">
					<input placeholder="Documento" id="documento" type="text" class="validate" value="<?=$objdeportistas->obtenerDocumento()?>" disabled>
					<input type="hidden" name="txtDocumento" value="<?=$objdeportistas->obtenerDocumento()?>">
					<label for="documento">Documento</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s6">
					<input placeholder="Nombre" id="nombre" type="text" class="validate" name="txtNombre" value="<?=$objdeportistas->obtenerNombre()?>">
					<label for="nombre">Nombre</label>
				</div>
				<div class="input-field col s6">
					<input placeholder="Apellido" id="apellido" type="text" class="validate" name="txtApellido" value="<?=$objdeportistas->obtenerApellido()?>">
					<label for="apellido">Apellido</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s6">
					<input placeholder="Fecha Nacimiento" id="fechaNacimiento" type="date" class="validate" name="txtFechaNacimiento" value="<?=$objDeportistas->obtenerFechaNacimiento()?>">
					<label for="fechaNacimiento">Fecha Nacimiento</label>
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
	if(isset($_GET['accion']) && $_GET['accion'] == "borrar" && isset($_GET['alumno']) && $_GET['alumno'] != ""  ){
?>
	<div class="grey lighten-3 center-align">	
		<form action="index.php?r=<?=$rutaPagina?>" method="POST" class="col s12">
			<h3>Borrar Alumno</h3>
			<h4>Desa borra al alumno <?=$_GET['alumno']?></h4>
			<input type="hidden" name="documento" value="<?=$_GET['alumno']?>">
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
			<th class="center" colspan=4>
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
            <th class="center">Nombre</th>
            <th class="center">Apellido</th>
            <th class="center">Genero</th>
            <th class="center">FechaNacimiento</th>
            <th class="center">Documento</th>
            <th style="width:150px">Botones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($listaDeportistas as $deportistas) {
        ?>
            <tr>
                <td class="center"><?= $deportistas['nombre'] ?></td>
                <td class="center"><?= $deportistas['apellido'] ?></td>
                <td class="center"><?= $deportistas['genero'] ?></td>
                <td class="center"><?= $deportistas['fechaNacimiento'] ?></td>
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
                                <td colspan="6">
                                    <ul class="pagination center">
                                        <li class="disabled">   
                                            <a href="index.php?r=<?=$rutaPagina?>&pagina=<?=$paginaAnterior?>&buscador=<?=$buscar?>" class="black-text">
                                                <i class="material-icons">chevron_left</i>
                                            </a>
                                        </li>
<?php
    for($i = 1; $i <= $totalMaximo; $i++){
        $class = "waves-effect";
        $classText = "white-text";
        if($i == $pagina){
            $class = "active";
            $classText = "red-text";
        }
?>
					<li class="<?=$class?>" >
						<a href="index.php?r=<?=$rutaPagina?>&pagina=<?=$i?>&buscador=<?=$buscar?>" class="<?=$classText?>"><?=$i?></a>
					</li>

<?PHP
					}
?>  
                            <li>
						        <a href="index.php?r=<?=$rutaPagina?>&pagina=<?=$paginaSiguente?>&buscador=<?=$buscar?>" class="black-text">
							        <i class="material-icons">chevron_right</i>
						        </a>
					        </li>
                        </ul>
                    </td>
                </tr>
    </tbody>
</table>