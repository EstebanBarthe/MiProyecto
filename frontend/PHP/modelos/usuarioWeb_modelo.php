<?php

require_once("PHP/modelos/generico_modelo.php");
class usuarioWeb_modelo extends generico_modelo{

    protected $nombre;
    
    protected $documento;

    protected $mail;

    protected $clave;

    protected $estado;


    public function obtenerNombre(){
        return $this->nombre;	
    }
    public function obtenerDocumento(){
        return $this->documento;	
    }
    public function obtenerMail(){
        return $this->mail;	
    }

    
    
    public function __constructor($data = array()){
        $this->nombre 		    = $data['nombre'];
        $this->documento 		= $data['documento'];
        $this->mail 			= $data['mail'];
        $this->clave 			= $data['clave'];

    }

    public function ingresar(){

        $arrayRespuesta = array("codigo"=>"", "mensaje"=>"");
        $sqlDuplicado = "SELECT count(*) AS total FROM usuarioWeb WHERE documento = :documento";
        $arrayDuplicado = array("documento" => $this->documento);
        $lista = $this->traerListado($sqlDuplicado, $arrayDuplicado);
        $totalRegistros = $lista[0]['total'];
        
        if($totalRegistros > 0){
            $arrayRespuesta['codigo'] = "Error";
            $arrayRespuesta['mensaje'] = "El documento ya se encuentra registrado";
            return $arrayRespuesta;
        }

        if(strlen($this->documento) < 5 || strlen($this->documento) > 10){
            $arrayRespuesta['codigo'] = "Error";
            $arrayRespuesta['mensaje'] = "El documento tiene que ser mayor a 5 digitos y menos a 10 digitos";
            return $arrayRespuesta;
        }


        $sql = "INSERT INTO deportistas SET
            nombre              = :nombre,
            documento 			= :documento,
            mail 			    = :mail,
            estado 				= 1;";
            
        $arrayDatos = array(
            "nombre" 			=> $this->nombre,
            "documento" 		=> $this->documento,
            "mail" 		        => $this->mail,
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


    public function cargar($documento){		

        $sql = "SELECT * FROM usuarioWeb WHERE documento = :documento";
        $arrayDatos = array("documento" => $documento);
        $lista = $this->traerListado($sql, $arrayDatos);

        if(isset($lista[0])){
            $this->documento 		    = $lista[0]['documento'];
            $this->nombre 			    = $lista[0]['nombre'];
            $this->mail 		        = $lista[0]['mail'];
            $this->estado 			    = $lista[0]['estado'];
		
        }

    }


    public function login($documento, $clave){

        $claveMD5 = md5($clave);
        $sql = "SELECT * FROM usuarioWeb WHERE documento = :documento AND clave = :clave";
        $arrayDatos = array("documento" => $documento, "clave" => $claveMD5);
        $lista = $this->traerListado($sql, $arrayDatos);

        if(isset($lista[0])){
            $this->documento 		= $lista[0]['documento'];
            $this->nombre 			= $lista[0]['nombre'];
            $this->mail 		    = $lista[0]['mail'];
            $this->estado 			= $lista[0]['estado'];	
            $retorno = true;
        }else{
            $retorno = false;
        }
        return $retorno;

    }








}





?>