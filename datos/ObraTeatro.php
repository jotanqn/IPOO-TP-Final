<?php

class ObraTeatro extends Funcion
{
    // Constructor
    public function __construct()
    {
        // Constructor Cuenta
        parent::__construct();
    }
    public function cargar($paramFuncion)
        //$idFuncion, $nombreFuncion, $precioFuncion, $horaDeInicio, $duracionFuncion, $objTeatro)
    {
        parent::cargar($paramFuncion);
    }

    // to string
    public function __toString()
    {
        return parent::__toString();
    }

    // da el Costo de una Obra de teatro
	public function darCosto()
    {
        $precioCosto= parent::darCosto() * 1.45;
        return $precioCosto;
    }

    public function Buscar($idFuncion){
        $base=new BaseDatos();
        $consulta="Select * from funcionobrateatro where idfuncion=".$idFuncion;
        $resp= false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row2=$base->Registro()) {
                    parent::Buscar($idFuncion);
                    
                    $resp= true;
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }
    public static function listar($condicion="")
    {
        $arreglo = null;
        $base=new BaseDatos();
        $consulta="Select * from funcionobrateatro ";
        if ($condicion!="") {
            $consulta=$consulta.' where '.$condicion;
        }
        $consulta.=" order by idfuncion ";
        //echo $consultaPersonas;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $arreglo= array();
                while ($row2=$base->Registro()) {
                    $obj=new ObraTeatro();
                    $obj->buscar($row2['idfuncion']);
                    array_push($arreglo, $obj);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arreglo;
    }
    public function insertar()
    {
        $base=new BaseDatos();
        $resp= false;
        
        if (parent::insertar()) {
            
            $consultaInsertar="INSERT INTO funcionobrateatro(idfuncion)
				VALUES (".parent::getIdFuncion().")";
            
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaInsertar)) {
                    $resp=  true;
                } else {
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        }
        return $resp;
    }
    
    
    public function eliminar()
    {
        $base=new BaseDatos();
        $resp=false;
        if ($base->Iniciar()) {
            $consultaBorra="DELETE FROM funcionobrateatro WHERE idfuncion=".parent::getIdFuncion();
            if ($base->Ejecutar($consultaBorra)) {
                if (parent::eliminar()) {
                    $resp=  true;
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
	    if(parent::modificar()){
	        $consultaModifica="UPDATE funcionobrateatro SET idfuncion='".$this->getIdFuncion().
            "' WHERE idfuncion=". parent::getIdFuncion();
	        if($base->Iniciar()){
	            if($base->Ejecutar($consultaModifica)){
	                $resp=  true;
	            }else{
	                $this->setmensajeoperacion($base->getError());
	                
	            }
	        }else{
	            $this->setmensajeoperacion($base->getError());
	            
	        }
	    }
		
		return $resp;
    }
}
?>