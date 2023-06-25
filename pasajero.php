<?php

class Pasajero {
    private $nombre;
    private $apellido;
    private $numDoc;
    private $telefono;
    private $mensajeOperacion;
    private $objViaje;

    public function __construct()
    {
        $this->numDoc = "";
        $this->nombre = "";
        $this->apellido = "";
        $this->telefono = "";
    }

    //metodos para setear

    public function setNombre($newName){
        $this->nombre = $newName;
    }

    public function setApellido($newApellido){
        $this->apellido = $newApellido;
    }

    public function setNumDoc($newDni){
        $this->numDoc = $newDni;
    }

    public function setTelefono($newCel){
        $this->telefono = $newCel;
    }

    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function setObjViaje($nuevoObjViaje){
        $this->objViaje = $nuevoObjViaje;
    }

    //Metodos acceso

    public function getObjViaje(){
        return $this->objViaje;
    }


    public function getNombre(){
        return $this->nombre;
    }

    public function getApellido(){
        return $this->apellido;
    }

    public function getNumDoc(){
        return $this->numDoc;
    }

    public function getTelefono(){
        return $this->telefono;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    //metodo para cargar los datos

    public function cargar($dniCargar, $nombreCargar, $apellidoCargar, $telCargar, $objViaje){
        $this->setNumDoc($dniCargar);
        $this->setNombre($nombreCargar);
        $this->setApellido($apellidoCargar);
        $this->setTelefono($telCargar);
        $this->setObjViaje($objViaje);

    }

    public function buscarPasajero($dni){
        $base = new BaseDatos();
        $consultaPasajero = "Select * from persona where pdocumento=" .$dni;
        $resp = false;
        if($base->Iniciar()){
            if($base->Ejecutar($consultaPasajero)){
				if($row2=$base->Registro()){
                    $objViaje = new Viaje();
                    $objViaje->buscarViaje($row2['idviaje']);
					$this->cargar($dni, $row2['pnombre'], $row2['papellido'], $objViaje, $row2['ptelefono']);
					$resp= true;
				}
            }else{
                $this->setMensajeOperacion($base->getError());
            }
        }else{
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO pasajero (pdocumento, pnombre, papellido, pteleofno, idviaje)
        VALUES (".$this->getNumDoc().", '".$this->getNombre()."','".$this->getApellido()."',".$this->getTelefono(). ",'".$this->getObjViaje()->getCodeViaje()."')";
	
        if($base->Iniciar()){
            if($base->Ejecutar($consultaInsertar)){
                $resp = true;
            }else{
                $this->setMensajeOperacion($base->getError()); 
            }

        }else{
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    public function listar($condicion=""){
        $arregloPasajero = null;
        $base = new BaseDatos();
        $consultaPasajero = "Select * from pasajero";
        if($condicion !=""){
            $consultaPasajero = $consultaPasajero. 'where' .$condicion;
        }
        $consultaPasajero .=" order by papellido";

        if($base->Iniciar()){
            if($base->Ejecutar($consultaPasajero)){
                $arregloPasajero = array();
                while($row2 = $base->Registro()){

                    $numDoc = $row2 ['pdocumento'];
                    $nombre = $row2 ['pnombre'];
                    $apellido = $row2 ['papellido'];
                    $telefono = $row2 ['ptelefono'];

                    $objViaje = new Viaje();
                    $objViaje->buscarViaje($row2 ['idviaje']);

                    $pasaj = new Pasajero();
                    $pasaj->cargar($numDoc, $nombre, $apellido, $telefono, $objViaje);

                    array_push($arregloPasajero, $pasaj);
                }

            }else{
                $this->setMensajeOperacion($base->getError());
            }
            
        }else{
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloPasajero;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $consultaModificar = "UPDATE pasajero SET pnombre='".$this->getNombre()."',papellido='".$this->getApellido()."'
        ,ptelefono=".$this->getTelefono().", idviaje=".$this->getObjViaje()->getCodeViaje()." WHERE pdocumento=".$this->getNumDoc();
        
        if($base->Iniciar()){
            if($base->Ejecutar($consultaModificar)){
                $resp = true;
            }else{
                $this->setMensajeOperacion($base->getError());
            }
        }else{
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $base = new BaseDatos();
        $resp = false;
        if($base->Iniciar()){
            $consultaBorrar = "DELETE FROM pasajero WHERE pdocumento =".$this->getNumDoc();
            if($base->Ejecutar($consultaBorrar)){
                $resp = true;
            }else{
                $this->setMensajeOperacion($base->getError());
            }
        }else{
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    public function __toString()
    {
        return "\nNombre: " . $this->getNombre() . 
        "\nApellido: " . $this->getApellido() . 
        "\nDni: " . $this->getNumDoc() . 
        "\nTelefono: " . $this->getTelefono() . "\n";
    }


}