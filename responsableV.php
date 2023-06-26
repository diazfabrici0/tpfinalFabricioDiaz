<?php

class ResponsableV {
    private $nroEmpleado;
    private $nroLicencia;
    private $nombre;
    private $apellido;
    private $mensajeOperacion;

    public function __construct() {
        $this->nroEmpleado = "";
        $this->nroLicencia = "";
        $this->nombre = "";
        $this->apellido = "";
    }

    public function cargarResponsable($nroEmpleadoCargar, $nroLicenciaCargar,$nombreCargar, $apellidoCargar) {
        $this->nroEmpleado = $nroEmpleadoCargar;
        $this->nroLicencia = $nroLicenciaCargar;
        $this->nombre = $nombreCargar;
        $this->apellido = $apellidoCargar;   
    }

    public function getNroEmpleado() {
        return $this->nroEmpleado;
    }

    public function setNroEmpleado($nroEmpleado) {
        $this->nroEmpleado = $nroEmpleado;
    }

    public function getNroLicencia() {
        return $this->nroLicencia;
    }

    public function setNroLicencia($nroLicencia) {
        $this->nroLicencia = $nroLicencia;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($mensajeOperacion) {
		$this->mensajeOperacion = $mensajeOperacion;
	}

    /**
	 * Lista a los responsables, se le puede pasar una condición para filtrar la lista
     * @param string $condicion
	 * @return array $arregloResponsable
	 */	
    public function listar($condicion = "") {
        $arregloResponsable = null;
        $base = new BaseDatos();
        $consultaResponsable = "Select * from responsable";
        if ($condicion != "") {
            $consultaResponsable = $consultaResponsable. 'where' .$condicion;
        }
        $consultaResponsable .=" order by rnumeroempleado";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaResponsable)) {
                $arregloResponsable = array();
                while ($row2 = $base->Registro()) {
                    $objResp = new ResponsableV();
                    $objResp->buscar($row2['rnumeroempleado']);
                    array_push($arregloResponsable, $objResp);
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloResponsable;
    }

    public function buscar($nroEmpleado) {
        $base= new BaseDatos();
        $consultaResponsable = "select * from responsable where rnumeroempleado=".$nroEmpleado;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaResponsable)) {
                if ($row2 = $base->Registro()) {
                    $this->cargarResponsable($nroEmpleado, $row2['rnumerolicencia'], $row2['rnombre'], $row2['rapellido']);
                    $resp = true;
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    public function insertar() {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO responsable(rnumerolicencia, rnombre, rapellido)
        VALUES (".$this->getNroLicencia().", '".$this->getNombre()."', '".$this->getApellido()."')";
        if ($base->Iniciar()) {

            $id = $base->devuelveIDInsercion($consultaInsertar);
            if($id !=null){
                $resp = true;
                $this->setNroEmpleado($id);
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModificar="UPDATE responsable SET rnumerolicencia=".$this->getNroLicencia()."',rnombre='".$this->getNombre()."'
                           ,rapellido='".$this->getApellido()."' WHERE rnumeroempleado=". $this->getNroEmpleado();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModificar)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}

    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM responsable WHERE rnumeroempleado=".$this->getNroEmpleado();
				if($base->Ejecutar($consultaBorra)){
				    $resp = true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}

    public function __toString() {
        return "Número de empleado: " . $this->getNroEmpleado() . "\n" . 
               "Número de licencia: " . $this->getNroLicencia() . "\n" . 
               "Nombre: " . $this->getNombre() . "\n" . 
               "Apellido: " . $this->getApellido() . "\n\n"; 
    }
}