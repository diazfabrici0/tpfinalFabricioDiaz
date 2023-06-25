<?php

class Responsable {
    private $nroEmpleado;
    private $nroLicencia;
    private $nombre;
    private $apellido;
    private $refViaje;
    private $mensajeoperacion;

    public function __construct() {
        $this->nroEmpleado = "";
        $this->nroLicencia = "";
        $this->nombre = "";
        $this->apellido = "";
        $this->refViaje = "";
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

    /** Devuelve el valor actual almacenado en el atributo refViajes
    * @return Viaje $refViajes */
    public function getRefViaje() {
        return $this->refViaje;
    }

    /** Coloca el valor pasado por parámetro en el atributo refViajes 
    * @param Viaje $refViajes */
    public function setRefViaje($refViaje) {
        $this->refViaje = $refViaje;
    }

    public function setMensajeOperacion($mensajeoperacion) {
		$this->mensajeoperacion = $mensajeoperacion;
	}

    public function __toString() {
        return "Número de empleado: " . $this->getnroEmpleado() . "\n" . 
               "Número de licencia: " . $this->getNroLicencia() . "\n" . 
               "Nombre: " . $this->getNombre() . "\n" . 
               "Apellido: " . $this->getApellido() . "\n\n"; 
    }

    public function cargarResponsable($nroEmpleadoCargar, $nroLicenciaCargar,$nombreCargar, $apellidoCargar) {
        $this->setNroEmpleado($nroEmpleadoCargar);
        $this->setNroLicencia($nroLicenciaCargar);
        $this->setNombre($nombreCargar);
        $this->setApellido($apellidoCargar);   
    }

    public function listarResponsable($condicion = "") {
        $arregloResponsable = null;
        $base = new BaseDatos();
        $consultaResponsable = "Select * from responsable";
        if ($condicion != "") {
            $consultaResponsable = $consultaResponsable. 'where' .$condicion;
        }
        $consultaResponsable .=" order by rapellido";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaResponsable)) {
                $arregloResponsable = array();
                while ($row2 = $base->Registro()) {
                    $numEmp = $row2 ['rnumeroempleado'];
                    $numLic = $row2 ['rnumerolicencia'];
                    $nombre = $row2 ['rnombre'];
                    $apellido = $row2 ['rapellido'];

                    $objViaje = new Viaje();
                    $objViaje->buscar($row2 ['idviaje']);

                    $responsable = new Responsable($numEmp, $numLic, $nombre, $apellido);
                    $responsable->cargarResponsable($numEmp, $numLic, $nombre, $apellido, $objViaje);

                    array_push($arregloResponsable, $responsable);
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloResponsable;
    }

    public function buscarResponsable($nroEmp) {
        $base= new BaseDatos();
        $consultaResponsable = "select * from responsable where rnumeroempleado=".$nroEmp;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaResponsable)) {
                if ($row2 = $base->Registro()) {
                    $objViaje = new Viaje();
                    $objViaje-> buscar($row2['idviaje']);
                    $this->cargarResponsable($nroEmp, $row2['rnombre'], $row2['rapellido'], $objViaje, $row2['rnumerolicencia']);
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

    public function insertarResponsable() {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO responsable(rnumeroempleado, rnombre, rapellido, rnumerolicencia, idviaje)
        VALUES (".$this->getNroEmpleado().", '".$this->getNombre()."', '".$this->getApellido()."', '".$this->getNroLicencia()."', '".$this->getRefViaje()->getCodigoViaje()."')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaInsertar)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    public function modificarResponsable(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE responsable SET rapellido='".$this->getApellido()."',rnombre='".$this->getNombre()."'
                           ,rnuemrolicencia='".$this->getNroLicencia()."' WHERE rnumeroempleado=". $this->getNroEmpleado();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}

    public function eliminarResponsable(){
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
}