<?php

class Musical extends Funcion
{
    // Atributos
    private $director;
    private $cantidadEscena;

    // Constructor
    public function __construct()
    {
        // Constructor Cuenta
        parent::__construct();
        $this->director = "";
        $this->cantidadEscena = "";
    }
    public function cargar($paramFuncion)
    //$idFuncion, $nombreFuncion, $precioFuncion, $horaDeInicio, $duracionFuncion, $objTeatro)
    {
        parent::cargar($paramFuncion);
        $this->setDirector($paramFuncion['director']);
        $this->setCantidadEscena($paramFuncion['personasescena']);
    }

    // Metodos
    public function __toString()
    {
        return parent::__toString(). " Director: ".$this->getDirector()." Cant. Personas en Escena".$this->getCantidadEscena();
    }

    public function darCosto()
    {
        $precioCosto= parent::darCosto()* 1.12;
        return $precioCosto;
    }

    /**
     * Get the value of director
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * Set the value of director
     */
    public function setDirector($director): self
    {
        $this->director = $director;

        return $this;
    }

    /**
     * Get the value of cantidadEscena
     */
    public function getCantidadEscena()
    {
        return $this->cantidadEscena;
    }

    /**
     * Set the value of cantidadEscena
     */
    public function setCantidadEscena($cantidadEscena): self
    {
        $this->cantidadEscena = $cantidadEscena;

        return $this;
    }

    //funciones ORM
    public function Buscar($idFuncion)
    {
        $base=new BaseDatos();
        $consulta="Select * from funcionmusical where idfuncion=".$idFuncion;
        $resp= false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row2=$base->Registro()) {
                    parent::Buscar($idFuncion);
                    $this->setIdFuncion($idFuncion);
                    $this->setDirector($row2['director']);
                    $this->setCantidadEscena($row2['personasescena']);
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
        $consulta="Select * from funcionmusical ";
        if ($condicion!="") {
            $consulta=$consulta.' where '.$condicion;
        }
        $consulta.=" order by idfuncion ";
        //echo $consultaPersonas;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $arreglo= array();
                while ($row2=$base->Registro()) {
                    $obj=new Musical();
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
            
            $consultaInsertar="INSERT INTO funcionmusical(idfuncion,director,personasescena)
				
                VALUES (".parent::getIdFuncion().",'".$this->getDirector()."','".$this->getCantidadEscena()."')";
                
            //echo " \n\nconusulta insertar musical ".$consultaInsertar;
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
            $consultaBorra="DELETE FROM funcionmusical WHERE idfuncion=".parent::getIdFuncion();
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

    public function modificar()
    {
        $resp =false;
        $base=new BaseDatos();
        if (parent::modificar()) {
            $consultaModifica="UPDATE funcionmusical SET director='".$this->getDirector()."',personasescena=".$this->getCantidadEscena().
            " WHERE idfuncion=". parent::getIdFuncion();
            //echo $consultaModifica;
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaModifica)) {
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
}
?>