<?php

include('BaseDatos.php');
include('responsableV.php');
include('empresa.php');
include('pasajero.php');
include('viaje.php');



function menuPrincipal(){

    echo "\n▁ ▂ ▄ ▅ ▆ ▇ █ MENU PRINCIPAL █ ▇ ▆ ▅ ▄ ▂ ▁\n";
    echo "1)            Menu pasajero\n";
    echo "2)            Menu responsable\n";
    echo "3)            Menu viaje\n";
    echo "4)            Menu empresa\n";
    echo "5)                Salir\n";
    echo " ▁ ▂ ▄ ▅ ▆ ▇ █-----------------█ ▇ ▆ ▅ ▄ ▂ ▁\n";
}


function menuPasajero(){    
    //Menu pasajero
    $bool = true;
    while ($bool) {
        echo "▄▀▄▀▄▀ MENU PASAJEROS ▀▄▀▄▀▄\n";
        echo "1)        Ver\n";
        echo "2)       Buscar.\n";
        echo "3)       Modificar.\n";
        echo "4)       Eliminar.\n";
        echo "5)       Agregar.\n";
        echo "6)        Salir\n";
        echo "▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▄▀▄▀▄▀";
        $selected = trim(fgets(STDIN));
        switch ($selected) { 
            case '1':// opcion de ver Pasajeros
                $objPasa = new Pasajero();
               
                $colPasas = $objPasa->listar();
                if(count($colPasas) == 0){
                    echo "No hay pasajeros.\n";
                }else{
                 
                   
                    foreach ($colPasas as $value) {
                        echo "\n○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•\n";
                        echo "\n".$value;
                        echo "\n○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•\n";                          
                    }
                   
                }
                break;

            case '2':// opcion de Buscar Pasajeros
               
                echo "Ingrese el dni del pasajero: \n";
                $dni = trim(fgets(STDIN));
                $objPasas = new Pasajero();
                if ($objPasas->buscar($dni)) {                   
                    echo $objPasas;
                } else {
                    echo "No se encontró el pasajero.\n";
                }
                break;

            case '3':// opcion de Modificar Pasajeros
               
                echo "\nIngrese el documento de un pasajero: \n";
                $dniPasa = trim(fgets(STDIN));
               
               
                $objPasas = new Pasajero();
                if ($objPasas->buscar($dniPasa)) {
                    echo $objPasas;
                  
                    $bool =true;
                    while ($bool) {
                        echo "\n_--------Menu Modificar--------\n";
                        echo "1)            Nombre\n";
                        echo "2)           Apellido\n";
                        echo "3)           Telefono\n";
                        echo "___________________________________\n";
                       $opc=trim(fgets(STDIN));
                       switch ($opc) {
                        case '1':
                            echo "\nIngrese el nombre: \n";
                            $nombrePas = trim(fgets(STDIN));                            
                            $objPasas->setNombre($nombrePas);
                            if($objPasas->modificar()){
                                echo "\nSe modifico con exito\n";
                                $bool=false;
                            }  
                            break;
                        case '2':
                            echo "Ingrese el apellido: \n";
                            $apellidoPas = trim(fgets(STDIN));                            
                            $objPasas->setApellido($apellidoPas);
                            if($objPasas->modificar()){
                                echo "\nSe modifico con exito\n";
                                $bool=false;
                            }
                             break;
                        case '3':
                            echo "Ingrese el telefono: \n";
                            $tel = intval(trim(fgets(STDIN)));
                            $objPasas->setTelefono($tel);
                            if($objPasas->modificar()){
                                echo "\nSe modifico con exito\n";
                                $bool=false;
                            }
                                break;
                        default:
                        echo  "\ningrese una opcion correcta\n";
                                $bool=false;
                            break;
                       }
                    }
                }else{
                    echo "\nNo se encontro el pasajero\n";
                }
              break;     
            case '4':// opcion de Eliminar Pasajeros
                echo "Ingrese el documento de un pasajero: \n";
                $dniPasa= trim(fgets(STDIN));
                $objPasas = new pasajero();
                if ($objPasas->buscar($dniPasa)) {
                    if ($objPasas->eliminar()) {
                        echo "Se elimino correctamente.\n";
                    } else {
                        echo "No se ha podido eliminar.\n";
                    }
                } else {
                    echo "No existe ese Pasajero.\n";
                }
                break;

            case '5':// opcion de Agregar un Pasajeros
                
                echo "Ingrese el documento de un pasajero: \n";
                $dniPasa = trim(fgets(STDIN));
                $objPasas = new Pasajero();
                if ($objPasas->buscar($dniPasa)) {
                    echo "Ese pasajero ya existe.\n";
                } else {
                    $objPasas->setNumDoc($dniPasa);
                    echo "\nIngrese el nombre: \n";
                    $nombre = trim(fgets(STDIN));
                    $objPasas->setNombre($nombre);
                    echo "Ingrese el apellido: \n";
                    $apellido = trim(fgets(STDIN));
                    $objPasas->setApellido($apellido);
                    echo "Ingrese el telefono: \n";
                    $tel = trim(fgets(STDIN));
                    $objPasas->setTelefono($tel);
                    $bool = true;

                    $colViaje = $objPasas->getObjViaje()->listar();

                    foreach ($colViaje as $key => $value) {
                        echo "***********************************************\n";
                        echo $value;
                        echo "***********************************************\n";
                    }
                    echo "Ingrese el número de viaje existente: \n";
                    while($bool){
                       
                        $idViaje = trim(fgets(STDIN));
                        $objV = new viaje();
                        if($objV->buscar($idViaje)){
                            
                            $colPasajeros = $objPasas->Listar("idviaje = $idViaje");
                            $lugaresOcup = count($colPasajeros);                           
                            if($lugaresOcup < $objV->getCantMaxPasajeros()){                                
                                echo "Este viaje posee lugar.\n";
                                $objPasas->setObjViaje($objV);
                                $bool = false;
                            }else{
                                echo "No hay lugar.\n";
                            } 
                         }else{
                            echo "Elija un viaje existente\n";
                        }
                    }
                    if ($objPasas->insertar()) {
                        echo "☑ S ingreso Correctamente ☑.\n";
                    } else {
                        echo "🆇 Error al ingresar 🆇.\n";
                    }
                    
                }
                break;

            case '6':
                $bool = false;
                break;

            default:
                break;
        }
    }

}


function menuViaje(){  

    $bool = true;
    while ($bool) {
        echo "Menu viaje.\n
        1. Ver\n
        2. Buscar\n
        3. Modificar\n
        4. Eliminar\n
        5. Crear\n
        6. Salir\n";
        $opc = trim(fgets(STDIN));
        switch ($opc) {
            case '1':// Opcion para ver los Viajes
                $objViaje=new viaje();   
                    
                $colViajes = $objViaje->Listar();
                if (count($colViajes) == 0) {
                    echo "No hay viajes.\n";
                } else {                    
                   
                    foreach ($colViajes as $key => $value) {
                        echo "\n○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•\n";
                        echo  $value;
                        echo "\n○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•○•\n";
                      
                    }
                   
                }
                break;

            case '2':// Opcion para Buscar los Viajes
                
                echo "Ingrese el número de viaje: \n";
                $idV = trim(fgets(STDIN));
                $objViaje = new Viaje();
                if($objViaje->buscar($idV)) {
                    echo $objViaje;
                } else {
                    echo "No se encontró dicho viaje.\n";
                }
                break;

            case '3':// Opcion para Modificar los Viajes               
                echo "Ingrese id del viaje: \n";
                $idV = trim(fgets(STDIN));
                $objViaje = new viaje();
                if ($objViaje->buscar($idV)) {
                    echo $objViaje;
                    echo "Modificar\n
                    1) Destino\n
                    2) Importe\n
                    3) Cantidad Maxima de Pasajero\n
                    4) Empresa\n
                    5) Responsable";
                    $bool = true;
                    $opc=trim(fgets(STDIN));
                    switch ($opc) {
                        case '1':
                            echo "Ingrese el destino: \n";
                            $destino = trim(fgets(STDIN));
                            if($destino != ''){
                                $objViaje->setDestino($destino);
                                if($objViaje->modificar()){
                                    echo "Se realizo la Modificacion";
                                }
                            }else{
                                echo "\nNo se realizo la modificacion\n";
                            }                           
                            break;
                        case '2':                            
                            echo "Ingrese el importe: \n";
                            $importe = trim(fgets(STDIN));
                            if($importe != 0){
                                $objViaje->setCosto($importe);
                                if($objViaje->modificar()){
                                    echo "\nSe realizo la modificacion\n";
                                }
                            }
                            
                            break;
                        case '3':
                            echo "\Ingrese la nueva cantidad maxima de pasajeros\n";
                            $cantPas = trim(fgets(STDIN));
                            if($cantPas > 0){
                                $objPaasas= new Pasajero;
                                $colP = $objPaasas->listar("idviaje=".$idV);
                                if ($cantPas < count($colP)){
                                    $objViaje->setCantMaxPasajeros($cantPas);
                                    $objViaje->modificar();
                                    echo "\nSe realizo la Modificacion\n";
                                }
                            }
                            
                            break;

                        case '4':
                           
                            $colEmp=$objViaje->getEmpresa()->listar();
                            echo "\nCual Empresa\n";
                            foreach ($colEmp as $value) {
                                echo "-------------------------------------------------------------\n";
                                echo $value;
                                echo "-------------------------------------------------------------\n";
                            }
                            echo "Ingres el ID de la Empresa : \n";
                            $idE = trim(fgets(STDIN));
                            $objEmp = new empresa();
                            if ($objEmp->buscar($idE)) {
                                $objViaje->setEmpresa($objEmp);
                                $objViaje->modificar();
                                echo " \nSe realizo la Modificacion\n";                                
                            }
                            break;
                        case '5':
                           $colRes=$objViaje->getResponsableV()->listar();
                           echo "\nElija al responsable\n";
                           foreach ($colRes as $value) {
                            echo "-------------------------------------------------------------\n";
                            echo $value;
                            echo "-------------------------------------------------------------\n";                            
                           }
                           echo "\nIngrese N° identificatorio del Responsable\n";
                           $idR = trim(fgets(STDIN));
                           $objRes = new ResponsableV();
                           if ($objRes->buscar($idR)){
                            $objViaje->setResponsableV($objRes);
                            $objViaje->modificar();
                            echo " \nSe realizo la Modificacion\n"; 
                           }
                            break;
                        
                            default:
                           
                            break;
                    }

                }
            break;          

            case '4':// Opcion para eliminar un Viaje

                echo "Al borrar un viaje se eliminaran todos los datos referentes a este\n";
                echo "Desea Continuar (S / N)\n";
                $opto= trim(fgets(STDIN));

                if ($opto == "S"){
                    $objViaje= new Viaje();
                    $colViajes= $objViaje->listar();
                    foreach ($colViajes as $value) {
                        echo "\n********************************************\n";
                        echo $value;
                        echo "\n********************************************\n";                        
                    }
                    echo "Ingrese el número de viaje: \n";
                    $numViaje= trim(fgets(STDIN));
                   
                    if ($objViaje->buscar($numViaje)){
                        if($objViaje->eliminar()){
                            echo "\nSe elimino correctamente\n";
                        }
                    }else{
                        echo "\nIngrese un vaije Correcto\n";
                    }
                }
                break;
                
          
            case '5': //Opcion Para crear un viaje
                
                $objViaje = new viaje();
                     echo "Ingrese el id del viaje: \n";
                    $idV = trim(fgets(STDIN));
                    $bool= true;
                   while ($bool) {

                    if($objViaje->buscar($idV)){
                        echo "El id ya existe\n";
                        echo "Ingrese otro\n";
                        $idV = trim(fgets(STDIN));
                    }else{
                        $objViaje->setCodigoViaje($idV);
                        $bool = false;                     
                    } 
                   
                   }
                   
                    echo "Ingrese el destino: \n";
                    $destino = trim(fgets(STDIN));                   
                   
                 
                    $objViaje->setDestino($destino);
                    echo "Ingrese la cantidad máxima de pasajeros: \n";
                    $vcantmaxpasajeros = trim(fgets(STDIN));
                    $objViaje->setCantMaxPasajeros($vcantmaxpasajeros);
                    
                    $colEmpresa = $objViaje->getEmpresa()->listar();

                    foreach ($colEmpresa as $value) {

                        echo "\n********************************************\n";
                        echo $value;
                        echo "\n********************************************\n";
                    }
                    echo "Ingrese el id de una empresa\n";
                    $bool = true;
                     while ($bool) {
                       
                        $idE = trim(fgets(STDIN));
                        $objEmp = new Empresa();
                        if($objEmp->buscar($idE)){                           
                            $objViaje->setEmpresa($objEmp);
                            $bool = false;                           
                        }
                        else{
                            echo "Ingrese una Empresa de la lista\n";
                        }
                     }
                     
                    $colRep= $objViaje->getResponsableV()->listar();

                    foreach ($colRep as $value) {
    
                         echo "\n********************************************\n";
                         echo $value;
                         echo "\n********************************************\n";
                    }                                
                    $bool = true;
                    echo "Ingrese el número de un responsable.\n";
                       while ($bool) {
                       
                        $rnumeroempleado = trim(fgets(STDIN));
                        $objResponsable = new ResponsableV();
                        if($objResponsable->buscar($rnumeroempleado)){
                            $objViaje->setResponsableV($objResponsable);
                            $bool = false;
                        }else{
                            echo "ingrese a un Responsable de la lista";
                        }
                       }
                    
                    echo "Ingrese el importe: \n";
                    $vimporte = trim(fgets(STDIN));
                    $objViaje->setCosto($vimporte);

                    echo $objViaje;
                    if($objViaje->insertar()){
                        echo "El viaje se ha insertado.\n";

                    }else{
                        echo "El viaje no se ha insertado.\n";
                        
                    };
              
                break;

            case '6':
                $bool = false;
                break;

            default:
                
                break;
        }
    }

}

function menuResposable(){

    
    //Menu responsable 

    $bool = true;
    while ($bool) {
        echo "Menu responsable.\n
        1. Ver.\n
        2. Buscar.\n
        3. Modificar.\n
        4. Eliminar.\n 
        5. Crear.\n
        6. Salir.\n";
        $opc = trim(fgets(STDIN));
        switch ($opc) {
            case '1':// Opcion para ver los Responsables 
                $objRes= new ResponsableV();               
                $colResponsables =$objRes->listar();
                if (count($colResponsables) == 0) {
                    echo "No hay responsables.\n";
                } else {
                    
                    /*$texto = "";
                    $cantResponsables = count($colResponsables);
                    for($i = 0; $i < $cantResponsables; $i++){  
                        $texto = $texto . $colResponsables[$i];
                        echo "+++++++++++++++++++++++++++++++++++\n";
                        echo $texto;
                        echo "+++++++++++++++++++++++++++++++++++\n";
                    }*/


                    foreach ($colResponsables as $key => $texto) {                             
                        echo "\n*************************************************\n";
                        echo $texto;
                        echo "\n*************************************************\n";
                    }
                   
                }

                break;

            case '2'://Opcion para Buscar un Responsable
               
                echo "Ingrese el número de empleado: \n";
                $numero = trim(fgets(STDIN));
                $objRes = new ResponsableV();
                if ($objRes->buscar($numero)) {
                    echo $objRes;
                } else {
                    echo "No se ha encontrado al responsable.\n";
                }
                break;

            case '3':// Opcion para Modificar un Responsable
                
                echo "Ingrese el número de empleado: \n";
                $numero = trim(fgets(STDIN));
                $objRes = new ResponsableV();
                if ($objRes->buscar($numero)) {
                    echo $objRes;

                    echo "Modificar :\n
                    1)Numero de Licencio\n
                    2) Nombre\n
                    3) Apellido ";
                    $opc=trim(fgets(STDIN));
                    switch ($opc) {
                        case '1':
                            echo "Ingrese el número de licencia: \n";
                            $numlicencia = intval(trim(fgets(STDIN)));
                            if ($numlicencia != '') {
                                $objRes->setNroLicencia($numlicencia);
                                if ($objRes->modificar()) {
                                    echo "Se  modifico el numero de licencia.\n";
                                }
                            }
                            break;
                        case '2':
                            echo "Ingrese el nombre: \n";
                            $nombre = trim(fgets(STDIN));
                            if ($nombre != '') {
                                $objRes->setNombre($nombre);
                                if ($objRes->modificar()) {
                                    echo "Se  modifico el nombre.\n";
                                }
                            }
                            break;
                        case '3':
                            echo "Ingrese el apellido: \n";
                            $apellido = trim(fgets(STDIN));
                            if ($apellido != '') {
                                $objRes->setApellido($apellido);
                                if ($objRes->modificar()) {
                                    echo "Se modifico el apellido.\n";
                                }
                            }
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                }else{
                    echo "\nno se encontro el Responsable\n";
                }
               
                break;

            case '4':// OPcion para eliminar un Responsable
                
                echo "Ingrese el número de empleado: \n";
                $numero = trim(fgets(STDIN));
                $objRes = new ResponsableV();
                if ($objRes->buscar($numero)) {
                    if ($objRes->eliminar()) {
                        echo "Se ha eliminado Correctamente.\n";
                    } else {
                        echo "error no se elimino.\n";                       
                    }
                } else {
                    echo "No se  encontro responsable.\n";
                }
                break;

            case '5':// opcion para crear un responsable
                
                echo "Ingrese el número de empleado: \n";
                $numero = trim(fgets(STDIN));
                $objResponsable = new ResponsableV();
                if ($objResponsable->buscar($numero)) {
                    echo "Ya se encunetra el empleado.\n";
                } else {
                    $objResponsable->setNroEmpleado($numero);
                    echo "Ingrese el número de licencia: \n";
                    $numlicencia = trim(fgets(STDIN));
                    $objResponsable->setNroLicencia($numlicencia);
                    echo "Ingrese el nombre: \n";
                    $nombre = trim(fgets(STDIN));
                    $objResponsable->setNombre($nombre);
                    echo "Ingrese el apellido: \n";
                    $apellido = trim(fgets(STDIN));
                    $objResponsable->setApellido($apellido);
                    $objResponsable->cargarResponsable($numero, $numlicencia, $nombre, $apellido);
                    if ($objResponsable->insertar()) {
                        echo "Se cargo Correctamente.\n";
                    } else {
                        echo "El responsable no ha sido cargado.\n";
                       
                    }
                }
                break;

            case '6':
                $bool = false;
                break;

            default:
                # code...
                break;
        }
    }

}


function menuEmpresa(){
    
    $bool = true;
    while ($bool) {
        echo "Menu empresa.\n
        1. Ver empresas.\n
        2. Buscar empresa.\n
        3. Modificar empresa.\n
        4. Eliminar empresa.\n
        5. Cargar empresa.\n";
      
        $opc = trim(fgets(STDIN));
        switch ($opc) {
            case '1': //opcion para ver las Empresas   
                $objEmpresa= new Empresa();             
                $colEmpresas =$objEmpresa->listar();
                if (count($colEmpresas) == 0) {
                    echo "No hay empresas cargadas.\n";
                } else {                    
                    
                    foreach ($colEmpresas as  $value) {
                        echo "><><><><><><><><><><><><><><><><><><><><><><><><><><><><\n";
                        echo $value;                       
                        echo "><><><><><><><><><><><><><><><><><><><><><><><><><><><><\n";
                    }
                    
                }
                break;

            case '2'://Opcion para Buscar Empresa
                
                echo "Ingrese el número de empresa: \n";
                $idE =trim(fgets(STDIN));
                $objEmpresa = new Empresa();
                if ($objEmpresa->buscar($idE)) {
                    echo $objEmpresa;
                } else {
                    echo "No existe la empresa.\n";
                }
                break;

            case '3':// Opcion para modificar la Empresa                
                echo "Ingrese el ID de empresa: \n";
                $idE =trim(fgets(STDIN));
                $objEmpresa = new Empresa();
                if ($objEmpresa->buscar($idE)) {
                    echo $objEmpresa;

                    echo "Modificar :\n
                    1)Nombre\n
                    2) Direccion \n";
                    $opc = trim(fgets(STDIN));
                    switch ($opc) {
                        case '1':
                            echo "Ingrese el nombre: \n";
                            $nombre = trim(fgets(STDIN));
                            $objEmpresa->setEmpNombre($nombre);
                            if ($objEmpresa->modificar()) {
                                echo "Se ha modificado la empresa.\n";
                            }
                            
                            break;
                        case '2':
                            echo "Ingrese la dirección: \n";
                            $edireccion = trim(fgets(STDIN));
                            $objEmpresa->setEmpDireccion($edireccion);
                            if ($objEmpresa->modificar()) {
                                echo "Se ha modificado la empresa.\n";
                            }
                           
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                }     
                break;

            case '4'://Opcion para eliminar un Empresa
               
                echo "Ingrese el número de empresa: \n";
                $idE = trim(fgets(STDIN));
                $objEmpresa = new Empresa();
                if ($objEmpresa->buscar($idE)) {
                    if($objEmpresa->eliminar()){
                        echo "La empresa se ha eliminado.\n";
                    }else{
                        echo "La empresa no se ha podido eliminar.\n";                       
                    }
                } else {
                    echo "No existe la empresa.\n";
                }
                break;

                case '5':// Opcion para cargar una empresa
                    //cargar empresa
                    $bool = true;
                    $objEmpresa = new empresa();
                        echo "Ingrese el id de la empresa: \n";
                        $bool = true;
                       while ($bool) {
                        $idE = trim(fgets(STDIN));
                        
                        if($objEmpresa->buscar($idE)){
                            echo "El id ya esta utilizado.\n";
                        }else{                       
                            $objEmpresa->setIdEmpresa($idE);
                            $bool = false;
                        }
                       }
                   
                    echo "Ingrese el nombre de la empresa: \n";
                    $nombre = trim(fgets(STDIN));
                    
                    $colEmpresa=$objEmpresa->listar();
                    if ($colEmpresa == null) {
                        
                        $oriDireccion = readline("Ingrese nueva dirección: ");
                        $empresa = new Empresa();
                        $empresa->cargar(1, $nombre, $oriDireccion);
                        $inserto = $empresa->insertar();
                        if (!$inserto) {
                            echo 'no se pudo realizar';
                        }else {
                             echo 'se inserto con exito';
                        }
                    
                    }else {
                    $i=0;
                    $bool=true;
                    while ($bool) {
                        if($colEmpresa[$i]->getEmpnombre() == $nombre){
                            echo "Ya esta esa empresa cargada\n";
                        }else{
                            $objEmpresa->setEmpnombre($nombre);
                            $bool = false;
    
                        }
                        $i++;            
                        
                    }
                  
                   
                    
                    $oriDireccion = readline("Ingrese nueva dirección: ");
                    $empresa = new Empresa();
                    $empresa->cargar(1, $nombre, $oriDireccion);
                    $inserto = $empresa->insertar();
                    if (!$inserto) {
                        echo 'no se pudo realizar';
                    }else {
                        echo 'se inserto con exito';
                    }
                }
                    break;
    
                    case '6':
                        $bool = false;
                        break;
        
                default:
                    # code...
                    break;
        }
    }

}


$bool = true;
while ($bool) {
    menuPrincipal();
    $opc = trim(fgets(STDIN));
    switch ($opc) {
        case '1':
            //pasajero
            menuPasajero();
            break;

        case '2':
            //responsable 
            menuResposable();
            break;

        case '3':
            //viaje
            menuViaje();
            break;

        case '4':
            //empresa 
            menuEmpresa();
            break;

        case '5':
            $bool = false;
            break;

        default:
            break;
    }
}
?>