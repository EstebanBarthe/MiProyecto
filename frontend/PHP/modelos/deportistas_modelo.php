<?php

require_once("PHP/modelos/generico_modelo.php");
class Deportistas_modelo extends generico_modelo{

    protected $nombre;

    protected $apellido;

    protected $documento;
    
    protected $fechaNacimiento;

    protected $genero;

    protected $estado;

    protected $categorias;

    protected $imagen;

    protected $posicion;

    private $totalEnLista = 4;

    public function obtenerDocumento(){
        return $this->documento;	
    }
    public function obtenerNombre(){
        return $this->nombre;	
    }
    public function obtenerApellido(){
        return $this->apellido;	
    }

    public function obtenerFechaNacimiento(){
        return $this->fechaNacimiento;	
    }

    public function obtenerGenero(){
        return $this->genero;	
    }

    public function obtenerCategorias(){
        return $this->categorias;	
    }

    public function obtenerImagen(){
        return $this->imagen;	
    }

    public function obtenerPosicion(){
        return $this->posicion;	
    }
    
    
    public function __constructor($dato = array()){

        $this->documento 		= $dato['documento'];
        $this->nombre 			= $dato['nombre'];
        $this->apellido 		= $dato['apellido'];
        $this->genero 	        = $dato['genero'];
        $this->categorias       = $dato['categorias'];
        $this->fechaNacimiento 	= $dato['fechaNacimiento'];
        $this->imagen 	        = $dato['imagen'];
        $this->posicion 	    = $dato['posicion'];

    }

    public function ingresar(){


        $sql = "INSERT deportistas SET
            nombre 				= :nombre,
            apellido			= :apellido,
            genero 				= :genero,
            fechaNacimiento 	= :fechaNacimiento,
            documento 			= :documento,
            categorias 			= :categorias,
            imagen 			    = :imagen,
            posicion 			= :posicion,
            estado 				= 1;";
            
        $arrayDatos = array(
            "nombre" 			=> $this->nombre,
            "apellido" 			=> $this->apellido,
            "genero" 			=> $this->genero,
            "fechaNacimiento" 	=> $this->fechaNacimiento,
            "documento" 		=> $this->documento,
            "categorias" 		=> $this->categorias,
            "imagen" 		    => $this->imagen,
            "posicion" 		    => $this->posicion,
        );

        $respuesta = $this->ejecutarConsulta($sql, $arrayDatos);

        if($respuesta){
            $arrayRespuesta['codigo'] = "OK";
            $arrayRespuesta['mensaje'] = "Ingreso exitoso";
        }else{
            $arrayRespuesta['codigo'] = "Error";
            $arrayRespuesta['mensaje'] = "Error al ingresar";
        }
        return $arrayRespuesta;

    }

    public function editar(){



        $sql = "UPDATE deportistas SET
            nombre 				= :nombre,
            apellido			= :apellido,
            genero 				= :genero,
            fechaNacimiento 	= :fechaNacimiento,
            categorias 			= :categorias
            imagen 			    = :imagen
            posicion 			= :posicion
            WHERE documento 	= :documento;";

            
        $arrayDatos = array(
            "nombre" 			=> $this->nombre,
            "apellido" 			=> $this->apellido,
            "genero" 			=> $this->genero,
            "fechaNacimiento" 	=> $this->fechaNacimiento,
            "categorias" 		=> $this->categorias,
            "documento" 		=> $this->documento,
            "imagen" 		    => $this->imagen,
            "posicion" 		    => $this->posicion,
        );

        $respuesta = $this->ejecutarConsulta($sql, $arrayDatos);

        if($respuesta){
            $arrayRespuesta['codigo'] = "OK";
            $arrayRespuesta['mensaje'] = "Se edito correctamente";
        }else{
            $arrayRespuesta['codigo'] = "Error";
            $arrayRespuesta['mensaje'] = "Error al editar";
        }
        return $arrayRespuesta;

    }

    public function cargar($documento){		

        $sql = "SELECT * FROM deportistas WHERE documento = :documento";
        $arrayDatos = array("documento" => $documento);
        $lista = $this->traerListado($sql, $arrayDatos);

        if(isset($lista[0])){
            $this->documento 		    = $lista[0]['documento'];
            $this->nombre 			    = $lista[0]['nombre'];
            $this->apellido 		    = $lista[0]['apellido'];
            $this->genero 	            = $lista[0]['genero'];
            $this->fechaNacimiento 	    = $lista[0]['fechaNacimiento'];	
            $this->estado 			    = $lista[0]['estado'];
            $this->categorias 			= $lista[0]['categorias'];	
            $this->imagen 			    = $lista[0]['imagen'];
            $this->posicion 			= $lista[0]['posicion'];	
        }

    }

    public function borrar(){
			
        $sql = "UPDATE deportistas SET estado = 0 WHERE documento = :documento";
        $arrayDatos = array("documento" => $this->documento);
        $respuesta = $this->ejecutarConsulta($sql, $arrayDatos);
        
        if($respuesta){
            $arrayRespuesta['codigo'] = "OK";
            $arrayRespuesta['mensaje'] = "Se borro el deportista correctamente";
        }else{
            $arrayRespuesta['codigo'] = "Error";
            $arrayRespuesta['mensaje'] = "Error al borrar el deportista";
        }
        return $arrayRespuesta;

    }

    public function listar($filtros = array()){
       
        $sql = "SELECT * FROM deportistas WHERE estado = 1 ";
        
        if(isset($filtros['buscar']) && $filtros['buscar'] != ""){

            $sql .= " AND (nombre LIKE ('%".$filtros['buscar']."%')
                        OR apellido LIKE ('%".$filtros['buscar']."%')
                        OR documento LIKE ('%".$filtros['buscar']."%')
                    )
                ";
        }
        
        if(isset($filtros['pagina']) && $filtros['pagina'] != ""){
            $pagina = $filtros['pagina'] * $this->totalEnLista;
            $sql .= " LIMIT ".$pagina.",".$this->totalEnLista."";
        }else{
            $sql .= " LIMIT 0,".$this->totalEnLista;
        }
        $lista = $this->traerListado($sql);
        return $lista;
    }

    public function traerListado($sql, $arrayData=array()){

		include("configuracion/configuracion.php");

		$host 		= $BDMYSQL['host'];
		$dbName 	= $BDMYSQL['dbName'];
		$user 		= $BDMYSQL['user'];
		$password 	= $BDMYSQL['password'];
		$options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_CASE => PDO::CASE_NATURAL,
			PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING
		];

		$objConexion = new PDO("mysql:localhost=".$host.";dbname=".$dbName."",$user,$password,$options);

		$preparo = $objConexion->prepare($sql);
		$preparo->execute($arrayData);
		$lista = $preparo->fetchAll();

		return $lista;

    }

    public function totalPaginas(){

        $sql =" SELECT count(*)  total FROM deportistas";
        $lista = $this->traerListado($sql);
        $totalRegistros = $lista[0]['total'];
        $totalPaginas = ceil($totalRegistros/$this->totalEnLista);
        return $totalPaginas;

    }

    public function ejecutarConsulta($sql, $arrayData=array()){

        include("configuracion/configuracion.php");

        $host       = $BDMYSQL['host'];
        $dbName     = $BDMYSQL['dbName'];
        $user       = $BDMYSQL['user'];
        $password   = $BDMYSQL['password'];
        $options    = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
            PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING
        ];

        $objConexion = new PDO("mysql:localhost=".$host.";dbname=".$dbName."",$user,$password,$options);
		try{

			$preparo = $objConexion->prepare($sql);
			$retorno = $preparo->execute($arrayData);

		}catch(Exception $e){
			// En caso que de error imprimimos en pantalla el error 
			// Y retornamos un false
			print_r($e->getMessage());				
			$retorno = false;

		}catch(PDOException $ePDO){
			// En caso que de error imprimimos en pantalla el error 
			// Y retornamos un false
			print_r($ePDO->getMessage());
			$retorno = false;
		}
		
		return $retorno;
    }








}





?>



















