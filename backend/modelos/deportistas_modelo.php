<?php


    class deportistas_modelo{

        protected $nombre;

        protected $apellido;

        protected $documento;
        
        protected $fechaNacimiento;

        protected $estado;

        private $totalEnLista = 5;

        public function constructor(){

            $this->nombre            ="";
            $this->apellido          ="";
            $this->documento         ="";
            $this->fechaNacimiento   ="";
            $this->genero            ="";
        }

        public function ingresar(){

			$arrayRespuesta = array("codigo"=>"", "mensaje"=>"");
			$sqlDuplicado = "SELECT count(*) AS total FROM deportistas WHERE documento = :documento";
			$arrayDuplicado = array("documento" => $this->documento);
			$lista = $this->traerListado($sqlDuplicado, $arrayDuplicado);
			$totalRegistros = $lista[0]['total'];
			
			if($totalRegistros > 0){
				$arrayRespuesta['codigo'] = "Error";
				$arrayRespuesta['mensaje'] = "Error el documento ya se encuentra registrado";
				return $arrayRespuesta;
			}

			if(strlen($this->documento) < 5 || strlen($this->documento) > 10){
				$arrayRespuesta['codigo'] = "Error";
				$arrayRespuesta['mensaje'] = "El documento tiene que ser mayor a 5 digitos y menos a 10 digitos";
				return $arrayRespuesta;
			}



			$sql = "INSERT INTO deportistas SET
						documento 	= :documento,
						nombre 		= :nombre,
						apellido	= :apellido,
						fechaNacimiento = :fechaNacimiento,
						tipoDocumento = :tipoDocumento,
						estado 		= 1;";
			$arrayDatos = array(

				"documento" 	=> $this->documento,
				"nombre" 		=> $this->nombre,
				"apellido" 		=> $this->apellido,
				"fechaNacimiento" => $this->fechaNacimiento,
				"tipoDocumento" => $this->tipoDocumento,

			);
			$respuesta = $this->ejecutarConsulta($sql, $arrayDatos);

			
			if($respuesta){
				$arrayRespuesta['codigo'] = "OK";
				$arrayRespuesta['mensaje'] = "Se ingreso el Deportista correctamente";
			}else{
				$arrayRespuesta['codigo'] = "Error";
				$arrayRespuesta['mensaje'] = "Error al ingresar el Deportista";
			}
			return $arrayRespuesta;


		}

        public function cargar($documento){
			

			$sql = "SELECT * FROM Deportistas WHERE documento = :documento";
			$arrayDatos = array("documento" => $documento);
			$lista = $this->traerListado($sql, $arrayDatos);

			if(isset($lista[0])){
				$this->documento 		= $lista[0]['documento'];
				$this->nombre 			= $lista[0]['nombre'];
				$this->apellido 		= $lista[0]['apellido'];
				$this->fechaNacimiento 	= $lista[0]['fechaNacimiento'];	
				$this->estado 			= $lista[0]['estado'];	
			}

		}


        public function borrar(){
			
			$sql = "UPDATE Deportistas SET estado = 0 WHERE documento = :documento";
			$arrayDatos = array("documento" => $this->documento);
			$respuesta = $this->ejecutarConsulta($sql, $arrayDatos);
			
			if($respuesta){
				$arrayRespuesta['codigo'] = "OK";
				$arrayRespuesta['mensaje'] = "Se borro el Deportista correctamente";
			}else{
				$arrayRespuesta['codigo'] = "Error";
				$arrayRespuesta['mensaje'] = "Error al borrar el Deportista";
			}
			return $arrayRespuesta;

		}
        
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

		public function totalPaginas($filtros = array()){

			$sql = "SELECT count(*)  total FROM deportistas 
						WHERE estado = 1 ";

			if(isset($filtros['buscar']) && $filtros['buscar'] != ""){

				$sql .= " AND (nombre LIKE ('%".$filtros['buscar']."%')
							OR apellido LIKE ('%".$filtros['buscar']."%')
							OR documento LIKE ('%".$filtros['buscar']."%')
						)
					";
			}

			$lista = $this->traerListado($sql);
			$totalRegistros = $lista[0]['total'];
			$totalPaginas = ceil($totalRegistros/$this->totalEnLista);
			return $totalPaginas;

		}
 

            public function traerListado($sql, $arrayData=array()){

                include("configuracion/configuracion.php");
                print_r($BDMYSQL);
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
    
                $preparo = $objConexion->prepare($sql);
                
                $lista = $preparo->fetchAll();
    
                return $lista;
            }
                
        }























?>