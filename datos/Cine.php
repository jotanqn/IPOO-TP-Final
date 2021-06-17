<?php

class Cine extends Funcion
{
    // Atributos
    private $genero;
    private $paisOrigen;

    // Constructor
    public function __construct()
    {
        // Constructor Cuenta
        parent::__construct();
        $this->genero = "";
        $this->paisOrigen ="";
    }
    public function cargar($paramFuncion)
    //$idFuncion, $nombreFuncion, $precioFuncion, $horaDeInicio, $duracionFuncion, $objTeatro)
    {
        parent::cargar($paramFuncion);
        $this->setGenero($paramFuncion['genero']);
        $this->setPaisOrigen($paramFuncion['paisorigen']);
    }
    // Metodos
    public function __toString()
    {
        return parent::__toString() . "Genero " . $this->getGenero() . " Pais de Origen " . $this->getPaisOrigen();
    }

    public function darCosto()
    {
        $precioCosto = parent::darCosto()  * 1.65;
        return $precioCosto;
    }


    /**
     * Get the value of genero
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set the value of genero
     */
    public function setGenero($genero): self
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get the value of paisOrigen
     */
    public function getPaisOrigen()
    {
        return $this->paisOrigen;
    }

    /**
     * Set the value of paisOrigen
     */
    public function setPaisOrigen($paisOrigen): self
    {
        $this->paisOrigen = $paisOrigen;

        return $this;
    }
    //funciones ORM
    public function Buscar($idFuncion){
        $base=new BaseDatos();
        $consulta="Select * from funcioncine where idfuncion=".$idFuncion;
        $resp= false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row2=$base->Registro()) {
                    parent::Buscar($idFuncion);
                    $this->setIdFuncion($idFuncion);
                    $this->setGenero($row2['genero']);
                    $this->setPaisOrigen($row2['paisorigen']);
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
        $consulta="Select * from funcioncine ";
        if ($condicion!="") {
            $consulta=$consulta.' where '.$condicion;
        }
        $consulta.=" order by idfuncion ";
        //echo $consulta."\n consulta cine";
        
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $arreglo= array();
                while ($row2=$base->Registro()) {
                    $obj=new Cine();
                    $obj->Buscar($row2['idfuncion']);
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
           
            $consultaInsertar="INSERT INTO funcioncine(idfuncion,genero,paisorigen)
				VALUES (".parent::getIdFuncion().",'".$this->getGenero()."','".$this->getPaisOrigen()."')";
            //echo "\ncolsuta insertar cine ".$consultaInsertar;
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
            $consultaBorra="DELETE FROM funcioncine WHERE idfuncion=".parent::getIdFuncion();
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
	        $consultaModifica="UPDATE funcioncine SET genero='".$this->getGenero().",'pasiorigen'=".$this->getPaisOrigen().
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
