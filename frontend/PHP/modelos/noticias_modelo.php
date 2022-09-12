<?php


require_once("PHP/modelos/generico_modelo.php");
class Noticias_modelo extends generico_modelo{

    protected $titulo;

    protected $cuerpo;

    protected $categorias;

    protected $id;
    
    protected $estado;

    protected $imagen;

    private $totalEnLista = 3;

    public function obtenerTitulo(){
        return $this->titulo;	
    }
    public function obtenerCuerpo(){
        return $this->cuerpo;	
    }
    public function obtenerCategorias(){
        return $this->categorias;	
    }
    public function obtenerID(){
        return $this->id;	
    }
    public function obtenerImagen(){
        return $this->imagen;	
    }

    
    
    public function __constructor($data = array()){

        $this->id 		        = $data['id'];
        $this->titulo			= $data['titulo'];
        $this->cuerpo			= $data['cuerpo'];
        $this->categorias       = $data['categorias'];
        $this->imagen 		    = $data['imagen'];
    }

    public function ingresar(){

        $arrayRespuesta = array("codigo"=>"", "mensaje"=>"");
		
        if(strlen($this->titulo) < 3 || strlen($this->titulo) > 100){
            $arrayRespuesta['codigo'] = "Error";
            $arrayRespuesta['mensaje'] = "El nombre de la noticias no es correcto";
            return $arrayRespuesta;
        }

        $sql = "INSERT INTO noticias SET
                    titulo 		= :titulo,
                    cuerpo	    = :cuerpo,
                    categorias	= :categorias,
                    imagen      = :imagen,
                    estado 		= 1;";
        $arrayDatos = array(
            "titulo" 		=> $this->titulo,
            "cuerpo" 		=> $this->cuerpo,
            "categorias" 	=> $this->categorias,
            "imagen" 	    => $this->imagen,
        );
        $respuesta = $this->ejecutarConsulta($sql, $arrayDatos);
    
        if($respuesta){
            $arrayRespuesta['codigo'] = "OK";
            $arrayRespuesta['mensaje'] = "Se ingreso la noticia correctamente";
        }else{
            $arrayRespuesta['codigo'] = "Error";
            $arrayRespuesta['mensaje'] = "Error al ingresar la noticia";
        }
        return $arrayRespuesta;


    }

    public function editar(){

        $arrayRespuesta = array("codigo"=>"", "mensaje"=>"");
        $sqlDuplicado = "SELECT count(*) AS total FROM noticias WHERE id = :id";
        $arrayDuplicado = array("id" => $this->id);
        $lista = $this->traerListado($sqlDuplicado, $arrayDuplicado);
        $totalRegistros = $lista[0]['total'];
        
        if($totalRegistros == 0){
            $arrayRespuesta['codigo'] = "Error";
            $arrayRespuesta['mensaje'] = "Error el id no se encuentra registrado";
            return $arrayRespuesta;
        }

        if(strlen($this->titulo) < 3 || strlen($this->titulo) > 100){
            $arrayRespuesta['codigo'] = "Error";
            $arrayRespuesta['mensaje'] = "La noticia no es correcta";
            return $arrayRespuesta;
        }

        $sql = "UPDATE noticias SET
                    titulo		= :titulo,
                    cuerpo		= :cuerpo,
                    categorias	= :categorias,
                    imagen      = :imagen
                WHERE id = :id;";
        $arrayDatos = array(
            "id" 			=> $this->id,				
            "titulo" 		=> $this->titulo,
            "cuerpo" 		=> $this->cuerpo,
            "categorias" 	=> $this->categorias,
            "imagen" 	    => $this->imagen,
        );
        $respuesta = $this->ejecutarConsulta($sql, $arrayDatos);

        if($respuesta){
            $arrayRespuesta['codigo'] = "OK";
            $arrayRespuesta['mensaje'] = "Se Edito la noticia correctamente";
        }else{
            $arrayRespuesta['codigo'] = "Error";
            $arrayRespuesta['mensaje'] = "Error al editar la noticia";
        }
        return $arrayRespuesta;


    }

    public function cargar($id){
			

        $sql = "SELECT * FROM noticias WHERE id = :id";
        $arrayDatos = array("id" => $id);
        $lista = $this->traerListado($sql, $arrayDatos);
        if(isset($lista[0])){
            $this->id 			= $lista[0]['id'];
            $this->titulo 	    = $lista[0]['titulo'];
            $this->cuerpo 	    = $lista[0]['cuerpo'];
            $this->categorias   = $lista[0]['categorias'];
            $this->estado 		= $lista[0]['estado'];
            $this->imagen 		= $lista[0]['imagen'];	
        }

    }

    public function borrar(){
			
        $sql = "UPDATE noticias SET estado = 0 WHERE id = :id";
        $arrayDatos = array("id" => $this->id);
        $respuesta = $this->ejecutarConsulta($sql, $arrayDatos);
        
        if($respuesta){
            $arrayRespuesta['codigo'] = "OK";
            $arrayRespuesta['mensaje'] = "Se borro la noticia correctamente";
        }else{
            $arrayRespuesta['codigo'] = "Error";
            $arrayRespuesta['mensaje'] = "Error al borrar la noticia";
        }
        return $arrayRespuesta;

    }

    public function listar($filtros = array()){
			
        $sql = "SELECT * FROM noticias WHERE estado = 1 ";

        if(isset($filtros['buscar']) && $filtros['buscar'] != ""){

            $sql .= " AND titulo LIKE ('%".$filtros['buscar']."%')";

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

			$sql = "SELECT count(*) as total FROM noticias
						WHERE estado = 1 ";

			if(isset($filtros['buscar']) && $filtros['buscar'] != ""){

				$sql .= " AND titulo LIKE ('%".$filtros['buscar']."%')";

			}
			$lista = $this->traerListado($sql);
			$totalRegistros = $lista[0]['total'];
			$totalPaginas = ceil($totalRegistros/$this->totalEnLista);
			return $totalPaginas;

		}

        public function listaSelect(){

			$sql = "SELECT id, titulo
						FROM noticias 
						WHERE estado = 1 ";

			$lista = $this->traerListado($sql);
			return $lista;


		}
        
 








}





?>