<?php

class Viaje {
    private $codeViaje;
    private $destino;
    private $cantMaxPasajeros;
    private $empresa;
    private $responsableV;
    private $costo;
    private $sumaCostos;
    private $pasajeros;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->codeViaje = 0;
        $this->destino = "";
        $this->cantMaxPasajeros = 0;
        $this->empresa = 0;
        $this->responsableV = 0;
        $this->costo = 0;
        $this->pasajeros = 0;
    }

    public function cargar($codViajeCargar, $destinoCargar, $cantMaxPasajerosCargar, $empresaCargar, $responsableCargar, $costoCargar, $pasajerosCargar){
        $this->codeViaje = $codViajeCargar;
        $this->destino = $destinoCargar;
        $this->cantMaxPasajeros = $cantMaxPasajerosCargar;
        $this->empresa = $empresaCargar;
        $this->responsableV = $responsableCargar;
        $this->costo = $costoCargar;
        $this->pasajeros = $pasajerosCargar;
    }

    public function getEmpresa(){
        return $this->empresa;
    }
    
    public function setEmpresa($empresaCargar){
        $this->empresa = $empresaCargar;
    }
    
    public function getSumaCostos(){
        return $this->sumaCostos;
    }
    
    
    public function setSumaCostos($sumaCostos){
        $this->sumaCostos = $sumaCostos;
    }
    
    /** Devuelve el valor actual almacenado en el atributo costo
    * @return $costo
    */
    public function getCosto(){
        return $this->costo;
    }
    
    /** Coloca el valor pasado por parámetro en el atributo costo 
    *@param float $costo 
    */
    public function setCosto($costo){
        $this->costo = $costo;
    }
    
    /** Coloca el valor pasado por parámetro en el atributo responsable 
    *@param Responsable $responsableV
    */
    public function setResponsableV($responsableV){
        $this->responsableV = $responsableV;
    }
    
    /** Devuelve el valor actual almacenado en el atributo responsableV
    * @return Responsable $responsableV
    */
    public function getResponsableV(){
        return $this->responsableV;
    }
    
    /** Devuelve el valor actual almacenado en el atributo codeViaje
    * @return int 
    */
    public function getCodigoViaje() {
        return $this->codeViaje;
    }
    
    /** Coloca el valor pasado por parámetro en el atributo codeViaje
    *@param int $codViaje 
    */
    public function setCodigoViaje($codViaje) {
        $this->codeViaje = $codViaje;
    }
    
    /**Devuelve el valor actual almacenado en el atributo destino
    * @return string $dest
    */
    public function getDestino() {
        return $this->destino;
    }
    
    /** Coloca el valor pasado por parámetro en el atributo destino
    * @param string $dest 
    */
    public function setDestino($dest) {
        $this->destino = $dest;
    }
    
    /** Devuelve el valor actual almacenado en el atributo cantMaximaPasajeros
    * @return int $cantMaxPasajeros
    */
    public function getCantMaxPasajeros() {
        return $this->cantMaxPasajeros;
    }
    
     /** Coloca el valor pasado por parámetro en el atributo cantMaxPasajeros
    * @param int $cantMaximaPasajeros 
    */
    public function setCantcantMaxPasajeros($cantMaximaPasajeros) {
        $this->cantMaxPasajeros = $cantMaximaPasajeros;
    }
    
    /** Devuelve el valor actual almacenado en el atributo pasajeros
    * @return array $pasajeros
    */
    public function getPasajeros(){
        return $this->pasajeros;
    }
    
    /** Coloca el valor pasado por parámetro en el atributo pasajeros 
    *@param array $pasajeros 
    */
    public function setPasajeros ($pasajeros){
        $this->pasajeros = $pasajeros;
    }

    public function getMensajeOperacion(){
        return  $this-> mensajeOperacion;
    }
    
    
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function buscar($codViaje){
        $base = new BaseDatos();
        $consultaViaje = "Select * FROM viaje where idviaje=" .$codViaje;
        if($base->Iniciar()){
            if($base->Ejecutar($consultaViaje)){
                if($row2 = $base->Registro()){
                    $objEmpresa = new Empresa();
                    $objEmpresa->buscar($row2['idempresa']);
                    $objResponsable = new ResponsableV();
                    $objResponsable->buscar($row2['rnumeroempleado']);
                    $this->cargar($codViaje, $row2['vdestino'], $row2['vcantmaxpasajeros'], $objEmpresa, $objResponsable, $row2['vimporte'], []);

                    $resp = true;
                }

            }else{
                $this->setMensajeOperacion($base->getError());
            }
        }else{
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    //Trae los datos de los pasajeros de la base de datos, y los setea en la clase

    public function traePasajeros(){
        $pasajero = new Pasajero();
        $condicion = "idviaje =".$this->getCodigoViaje();
        $colPasajeros = $pasajero->listar($condicion);
        $this->setPasajeros($colPasajeros);
    }

    public function mostrarPasajeros(){
        $cad = '';
        $colPasajeros = $this->getPasajeros();
        $cant = count($colPasajeros);
        if($cant > 0){
            for ($i=0;$i < count($colPasajeros); $i++){
                $cad .= '---------------' . "\n" . $colPasajeros[$i]."\n";
            }
        }
        return $cad;
    }

    public function insertar(){
        $base = new BaseDatos();
        $resp = false; 
        $consultaInsertar = "INSERT INTO viaje (vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte)
        VALUES ('".$this->getDestino()."',".$this->getCantMaxPasajeros().",". $this->getEmpresa()->getIdEmpresa(). ",".$this->getResponsableV()->getNroEmpleado().",".$this->getCosto().");";
        if($base->Iniciar()){
            $id = $base->devuelveIDInsercion($consultaInsertar);
            if($id !=null){
                $resp = true;
                $this->setCodigoViaje($id);
            }else{
                $this->setMensajeOperacion($base->getError());
            }
        }else{
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    /**
	 * Lista a los pasajeros, se le puede pasar una condición para filtrar la lista
     * @param string $condicion
	 * @return $arregloPasajeros
	 */	
    public function listar($condicion=""){
        $arrayViajes = null;
        $base = new BaseDatos();
        $consultaViaje = "Select * FROM viaje";
        if($condicion !=""){
            $consultaViaje = $consultaViaje. 'WHERE' .$condicion;
        }
        $consultaViaje .=" order by idviaje";

        if($base->Iniciar()){
            if($base->Ejecutar($consultaViaje)){
                $arrayViajes = array();
                while($row2 = $base->Registro()){
                    $objViaje = new Viaje();
                    $objViaje->buscar($row2['idviaje']);
                    array_push($arrayViajes, $objViaje);
                }

            }else{
                $this->setMensajeOperacion($base->getError());
            }
            
        }else{
            $this->setMensajeOperacion($base->getError());
        }
        return $arrayViajes;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $consultaModificar = "UPDATE viaje SET vdestino='".$this->getDestino()."',vcantmaxpasajeros='".$this->getCantMaxPasajeros()."',idempresa='".$this->getEmpresa()->getIdEmpresa().",rnumeroempleado=".$this->getResponsableV()->getNumEmpleado().",vimporte=".$this->getCosto()."WHERE idviaje =".$this->getCodigoViaje();
        
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
            $consultaBorrar = "DELETE FROM viaje WHERE idviaje =".$this->getCodigoViaje();
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

}