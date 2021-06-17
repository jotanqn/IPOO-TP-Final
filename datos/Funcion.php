<?php
class Funcion
{
    // para los objetos Funcion

    private $idFuncion;
    private $nombreFuncion;
    private $precioFuncion;
    private $horaDeInicio;
    private $duracionFuncion;
    private $objTeatro;
    private $mensajeoperacion;

    // Metodo constructor de la clase Punto
    public function __construct()
    {
        $this->idFuncion = 0;
        $this->nombreFuncion = "";
        $this->precioFuncion = "";
        $this->horaDeInicio = "";
        $this->duracionFuncion = "";
        $this->objTeatro = "";
    }

    public function cargar($paramFuncion)
        //$idFuncion, $nombreFuncion, $precioFuncion, $horaDeInicio, $duracionFuncion, $objTeatro)
    {
        $this->setIdFuncion($paramFuncion['idfuncion']);
        $this->setNombreFuncion($paramFuncion['nombrefuncion']);
        $this->setPrecioFuncion($paramFuncion['preciofuncion']);
        $this->setHoraDeInicio($paramFuncion['horainicio']);
        $this->setduracionFuncion($paramFuncion['duracionfuncion']);
        $this->setObjTeatro($paramFuncion['objTeatro']);
    }
    // metodo de lectura atributos
    public function getnombreFuncion()
    {
        return $this->nombreFuncion;
    }
    public function getprecioFuncion()
    {
        return $this->precioFuncion;
    }
    public function gethoraDeInicio()
    {
        return $this->horaDeInicio;
    }
    public function getduracionFuncion()
    {
        return $this->duracionFuncion;
    }
    public function getIdFuncion()
    {
        return $this->idFuncion;
    }
    public function getObjTeatro()
    {
        return $this->objTeatro;
    }


    // metodo de escritura atributos
    public function setIdFuncion($idFuncion)
    {
        $this->idFuncion = $idFuncion;
    }

    public function setnombreFuncion($nombreFuncion)
    {
        $this->nombreFuncion = $nombreFuncion;
    }
    public function setprecioFuncion($precioFuncion)
    {
        $this->precioFuncion = $precioFuncion;
    }
    public function setduracionFuncion($duracionFuncion)
    {
        $this->duracionFuncion = $duracionFuncion;
    }
    public function sethoraDeInicio($horaDeInicio)
    {
        $this->horaDeInicio = $horaDeInicio;
    }

    public function setObjTeatro($objTeatro): self
    {
        $this->objTeatro = $objTeatro;

        return $this;
    }

    // metodo conviertir a string instancia
    public function __toString()
    {
        $horas = floor((int)filter_var($this->gethoraDeInicio(),FILTER_SANITIZE_NUMBER_INT) / 60);
        $minutos = floor((int)filter_var($this->gethoraDeInicio(), FILTER_SANITIZE_NUMBER_INT) - ($horas * 60));
        $horasStr = date("H:i", strtotime($horas . ":" . $minutos));
        return "\nNombre  :" . $this->getnombreFuncion() . " Precio : " . $this->getprecioFuncion() .
            " Hora de Inicio: " . $horasStr . " - Duracion de la funcion: " . $this->getduracionFuncion() . " minutos";
    }
    public function __destruct()
    {
        //echo $this . " instancia destruida, no hay referencias a este objeto \n";
    }

    public function darCosto()
    {
        $precioCosto =  $this->getprecioFuncion();
        return $precioCosto;
    }

    /**
     * Recupera los datos de una funcion pod ID
     * @param int $idFuncion
     * @return true en caso de encontrar los datos, false en caso contrario
     */
    public function Buscar($idFuncion)
    {
        $base=new BaseDatos();
        $consultaFuncion="Select * from funcion where idfuncion=".$idFuncion;
        $resp= false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaFuncion)) {
                if ($row2=$base->Registro()) {
                    $this->setIdFuncion($idFuncion);
                    $this->setnombreFuncion($row2['nombrefuncion']);
                    $this->sethoraDeInicio($row2['horainicio']);
                    $this->setduracionFuncion($row2['duracionfuncion']);
                    $this->setprecioFuncion($row2['precio']); 
                    $idTeatro= $row2['idteatro'];
                  
                    $objTeatro = new Teatro();
                    $objTeatro->buscar($idTeatro); 
                    $this->setObjTeatro($objTeatro); 
                    /* $funcion = new Funcion();
                    $funcion->cargar($row2);  */
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

    public static function listar($condicion)
    {
        $arregloFuncion = null;
        $base=new BaseDatos();
        $consultaFuncion="Select * from funcion";
        if ($condicion!="") {
            $consultaFuncion=$consultaFuncion.' where '.$condicion;
        }
        $consultaFuncion.=" order by idfuncion ";
        echo "-----------------------------";
        echo $consultaFuncion;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaFuncion)) {
                $arregloFuncion= array();
                while ($row2=$base->Registro()) {
                  /*   $idFuncion=$row2['idfuncion'];
                    $nombreFuncion=$row2['nombrefuncion'];
                    $horaDeInicio=$row2['horainicio'];
                    $duracionFuncion=$row2['duracionfuncion'];
                    $precioFuncion=$row2['precio']; */
                    $idTeatro=$row2['idteatro'];
                    
                    $objTeatro= new Teatro();
                    
                    $row2['$objTeatro']=$objTeatro->buscar($idTeatro);
                    $func = new Funcion();
                    $func->cargar($row2);
                    array_push($arregloFuncion, $func);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arregloFuncion;
    }
    public function insertar()
    {
        $objTeatro = $this->getObjTeatro();
        $idTeatro = $objTeatro->getIdTeatro();
        echo " id de teatro ".$idTeatro."\n";
        $base=new BaseDatos();
        $resp= false;
        $consultaInsertar="INSERT INTO funcion(nombrefuncion, horainicio, duracionfuncion,  precio, idteatro) 
				VALUES ('".$this->getnombreFuncion()."','".$this->gethoraDeInicio()."','".$this->getduracionFuncion()."','".
                $this->getprecioFuncion()."','".$idTeatro."')";
        //echo "consulta insertar funcoin ". $consultaInsertar;
        
        if ($base->Iniciar()) {
            if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setIdFuncion($id);
                $resp=  true;
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
        $consultaModifica="UPDATE funcion SET nombrefuncion='".$this->getnombreFuncion()."',precio=". $this->getprecioFuncion().
                           " WHERE idfuncion=".$this->getIdFuncion();
        echo $consultaModifica;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaModifica)) {
                $resp=  true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }
    
    public function eliminar()
    {
        $base=new BaseDatos();
        $resp=false;
        if ($base->Iniciar()) {
            $consultaBorra="DELETE FROM funcion WHERE idfuncion=".$this->getIdFuncion();
            if ($base->Ejecutar($consultaBorra)) {
                $resp=  true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }
}	
?>