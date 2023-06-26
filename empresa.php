<?php

class Empresa {
    private $idEmpresa;
    private $nombre;
    private $direccion;
    private $mensajeOperacion;

    public function __construct()
    {
        $this-> idEmpresa = 0;
        $this-> nombre = "";
        $this-> direccion = "";
      
    }

    public function cargar($idEmpresaCargar, $enombreCargar, $empDireccionCargar) {
        $this->idEmpresa = $idEmpresaCargar;
        $this->nombre = $enombreCargar;
        $this->direccion = $empDireccionCargar;
    }

    public function getIdEmpresa(){
        return  $this->idEmpresa;
    }

    public function setIdEmpresa($idEmpresaCargar) {
        $this->idEmpresa = $idEmpresaCargar;
      }

    public function getEmpNombre(){
        return  $this-> nombre;
    }

    public function setEmpNombre($enombreCargar) {
        $this->nombre = $enombreCargar;
      }

    public function getEmpDireccion(){
        return  $this->direccion;
    }

    public function setEmpDireccion($empDireccionCargar) {
        $this->direccion = $empDireccionCargar;
      }
      public function getMensajeOperacion(){
        return  $this-> mensajeOperacion;
    }
    
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
      }


    /**
	 * Recupera los datos de una empresa por id
	 * @param int $idEmpresa
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function buscar($idEmpresa){
		$base=new BaseDatos();
		$consultaEmpresa="Select * from empresa where idempresa=".$idEmpresa;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){
				if($row2=$base->Registro()){
					$this->cargar($idEmpresa,$row2['enombre'],$row2['edireccion']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setMensajeOperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setMensajeOperacion($base->getError());
		 	
		 }		
		 return $resp;
	}

    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO empresa(enombre, edireccion)
				VALUES ('".$this->getEmpNombre()."','".$this->getEmpDireccion()."')";
		
		if($base->Iniciar()){
            $id = $base->devuelveIDInsercion($consultaInsertar);
			if($id != null){
				$resp=  true;
				$this->setIdEmpresa($id);
			}	else {
					$this->setMensajeOperacion($base->getError());
					
			}

		} else {
				$this->setMensajeOperacion($base->getError());
			
		}
		return $resp;
	}



    /**
     * Lista las empresas segun la condicion
     *@param string $condicion
     *@return array $arregloEmpresa
     */
    public function listar($condicion=""){
        $arregloEmpresa = null;
        $base = new BaseDatos();
        $consultaEmpresa = "Select * FROM empresa";
        if($condicion !=""){
            $consultaEmpresa = $consultaEmpresa. 'where' .$condicion;
        }
        $consultaEmpresa .=" order by enombre";

        if($base->Iniciar()){
            if($base->Ejecutar($consultaEmpresa)){
                $arregloEmpresa = array();
                while($row2 = $base->Registro()){

                    $idEmpresa = $row2['idempresa'];
                    $nombre = $row2['enombre'];
                    $direccion = $row2['edireccion'];

                    //$objViaje = new Viaje();
                    //$colViajes = $objViaje->listar('idempresa='.$idEmpresa);

                    $empre= new Empresa();
                    $empre->cargar($idEmpresa, $nombre, $direccion);

                    array_push($arregloEmpresa, $empre);
                }

            }else{
                $this->setMensajeOperacion($base->getError());
            }
            
        }else{
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloEmpresa;
    }


    public function modificar(){
	    $resp = false; 
	    $base=new BaseDatos();
		$consultaModificar="UPDATE empresa SET enombre='".$this->getEmpnombre()."', edireccion='".$this->getEmpdireccion()."' WHERE idempresa=".$this->getIdEmpresa();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModificar)){
			    $resp=  true;
			}else{
				$this->setMensajeOperacion($base->getError());
				
			}
		}else{
				$this->setMensajeOperacion($base->getError());
			
		}
		return $resp;
	}


    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorrar="DELETE FROM empresa WHERE idempresa=".$this->getIdEmpresa();
				if($base->Ejecutar($consultaBorrar)){
				    $resp=  true;
				}else{
						$this->setMensajeOperacion($base->getError());
					
				}
		}else{
				$this->setMensajeOperacion($base->getError());
			
		}
		return $resp; 
	}
    public function __toString(){
	    return "\nID empresa: ".$this->getIdEmpresa(). 
        "\n Nombre de la empresa:".$this->getEmpNombre().
        "\n Direccion: ".$this->getEmpDireccion()."\n";
			
	}
    }