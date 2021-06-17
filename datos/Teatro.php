<?php
class Teatro
{
    // para los objetos teatro
    
    private $nombreTeatro ;
    private $direccion ;
    private $coleccionFuncion;
    private $idTeatro;
    private $mensajeoperacion;
    
    
    public function __construct()
    {
        // Metodo constructor de la clase Punto
        $this->nombreTeatro = "";
        $this->direccion = "";
        $this->coleccionFuncion = array();
        $this->idTeatro=0;
    }
    public function cargar($param){	
	    $this->setIdTeatro($param['idteatro']);
		$this->setdireccion($param['direccion']);
		$this->setnombreTeatro($param['nombreteatro']);
		$this->setcoleccionFuncion($param['coleccionfuncion']);
		
    }

    // metodo de lectura atributos
    public function getnombreTeatro()
    {
        return $this->nombreTeatro;
    }
    public function getdireccion()
    {
        return $this->direccion;
    }

    public function getcoleccionFuncion()
    {
		if (count($this->coleccionFuncion) == 0) {
			$objCine = new Cine();
			$objMusical = new Musical();
			$objObraTeatro = new ObraTeatro();
			$condicion = "";//" idteatro=" . $this->getIdTeatro();
			
			$colCine = $objCine->listar($condicion);
			$colMusical = $objMusical->listar($condicion);
			$colObrasTeatro = $objObraTeatro->listar($condicion);
			$coleccionFunciones = array_merge($colCine, $colMusical, $colObrasTeatro);
			$this->setcoleccionFuncion($coleccionFunciones);
		}
		return $this->coleccionFuncion;
    }
  
    public function getIdTeatro()
    {
        return $this->idTeatro;
    }
    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
    
  
    // metodo de escritura atributos
    public function setIdTeatro($idTeatro): self
    {
        $this->idTeatro = $idTeatro;

        return $this;
    }
	public function setnombreTeatro($nombreTeatro)
	{
		$this->nombreTeatro = $nombreTeatro;
	}
	public function setdireccion($direccion)
	{
		$this->direccion = $direccion;
	}

	public function setcoleccionFuncion($coleccionFuncion)
	{
		$this->coleccionFuncion = $coleccionFuncion;
	}

    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}

    public function cambiarFuncion($cambiarFuncion,$nombreFuncion)
    {
        echo "funcion a cambiar ".$cambiarFuncion."\n";
        $coleccionFuncion= $this->getcoleccionFuncion();
        $this->getcoleccionFuncion()[$cambiarFuncion]-> $this->setnombreFuncion ($nombreFuncion);
        $this->setcoleccionFuncion($coleccionFuncion);
    }
    /* Verificar si la funcion a agregar no se solapa con alguna que ya se encuentre cargada
    * @param INT $horaDeInicioNuevaFuncion //expresada en minutos
    * @param INT $duracionNuevaFuncion  // expresada en minutos
    * @return boolean
    */
    public function verificaSolapamientoDeFunciones($horaDeInicioNuevaFuncion,$duracionNuevaFuncion)
    {
        $horaCierreNuevaFuncion = $horaDeInicioNuevaFuncion + $duracionNuevaFuncion;
        $coleccionFuncion = $this->getcoleccionFuncion();
        $seSolapan = false;
      
        foreach ($coleccionFuncion as  $funcion)
            {
                $horaFuncionActual=$funcion->gethoraDeInicio();
                $horaCierreActual= $horaFuncionActual + $funcion->getduracionFuncion();
                
                if (($horaDeInicioNuevaFuncion >=$horaFuncionActual  ) && ($horaDeInicioNuevaFuncion <= $horaCierreActual))    
				{
                        $seSolapan = true;
                }    
            }
        foreach ($coleccionFuncion  as  $funcion)
            
            {
                $horaFuncionActual=$funcion->gethoraDeInicio();
                $horaCierreActual= $horaFuncionActual+$funcion->getduracionFuncion();
                if (($horaDeInicioNuevaFuncion<$horaFuncionActual) && ($horaCierreActual<$horaCierreNuevaFuncion)) 
                    {
                        $seSolapan = true;
                    }
            }
    	return $seSolapan;

    }


    /* muestra todos los parameros del objeto y la coleccion de objetos de funciones
    * @return string
    */
    public function __toString()
	{
        $coleccionFuncionStr ="";
        $i=1;
        foreach ($this->getcoleccionFuncion() as $key => $value)
        {
            $coleccionFuncionStr=$coleccionFuncionStr. "\n Funcion :".$i.$value;
            $i++;
        }
		return "\n Id Teatro ".$this->getIdTeatro()." nombre del teatro: ".$this->getnombreTeatro()."\n"."Direccion del Teatro: ".$this->getdireccion()."\n".
		"Funciones \n".$coleccionFuncionStr;
	}

	/* public function __destruct(){
		echo $this . " instancia destruida, no hay referencias a este objeto \n";
	} */
	public function agregarObra ($nombreFuncion, $precioFuncion, $horaDeInicio,$duracionFuncion,$objTeatro)
    {
		$paramFuncion=array();
        $coleccionFuncion = $this->getcoleccionFuncion();
		$paramFuncion['idfuncion']=0;
		$paramFuncion['nombrefuncion']=$nombreFuncion;
        $paramFuncion['preciofuncion']=$precioFuncion;
        $paramFuncion['horainicio']=$horaDeInicio;
        $paramFuncion['duracionfuncion']=$duracionFuncion;
        $paramFuncion['objTeatro']= $objTeatro;
		$obraTeatro = new ObraTeatro();
		$obraTeatro->cargar($paramFuncion);
		$obraTeatro->insertar();
        array_push($coleccionFuncion,$obraTeatro);
        $this->setcoleccionFuncion($coleccionFuncion);
    }
    public function agregarCine ($nombreFuncion, $precioFuncion, $horaDeInicio, $duracionFuncion, $genero, $paisOrigen,$objTeatro)
    {
        $coleccionFuncion = $this->getcoleccionFuncion();
		$paramFuncion['idfuncion']=0;
		$paramFuncion['nombrefuncion']=$nombreFuncion;
        $paramFuncion['preciofuncion']=$precioFuncion;
        $paramFuncion['horainicio']=$horaDeInicio;
        $paramFuncion['duracionfuncion']=$duracionFuncion;
        $paramFuncion['objTeatro']= $objTeatro;
		$paramFuncion['genero']=$genero;
		$paramFuncion['paisorigen']=$paisOrigen;
        $cine = new Cine($paramFuncion);
		$cine->cargar($paramFuncion);
		echo $cine;
		$cine->insertar();
        array_push($coleccionFuncion,$cine);
        $this->setcoleccionFuncion($coleccionFuncion);
    }

    public function agregarMusical ($nombreFuncion, $precioFuncion, $horaDeInicio,$duracionFuncion, $director, $cantidadEscena,$objTeatro)
    {
        $coleccionFuncion = $this->getcoleccionFuncion();
		$paramFuncion['idfuncion']=0;
		$paramFuncion['nombrefuncion']=$nombreFuncion;
        $paramFuncion['preciofuncion']=$precioFuncion;
        $paramFuncion['horainicio']=$horaDeInicio;
        $paramFuncion['duracionfuncion']=$duracionFuncion;
        $paramFuncion['objTeatro']= $objTeatro;
		$paramFuncion['director'] = $director;
		$paramFuncion['personasescena']=$cantidadEscena;
        $musical  = new Musical($paramFuncion);
		$musical->cargar($paramFuncion);
		$musical->insertar();
        array_push($coleccionFuncion,$musical);
        $this->setcoleccionFuncion($coleccionFuncion);
    }
    
	/**
	 * Recupera los datos de una teatro por idteatro
	 * @param int $idteatro
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($idteatro){
		$base=new BaseDatos();
		$consultateatro="Select * from teatro where idteatro=".$idteatro;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultateatro)){
				if($row2=$base->Registro()){
				    $this->setIdteatro($row2['idteatro']);
				    $this->setnombreTeatro($row2['nombreteatro']);
					$this->setdireccion($row2['direccion']);
                    //busco colecciones de funciones
                    
					/* $row2['coleccionfuncion']=array();
                    $objTeatro = new Teatro();
                    $objTeatro->cargar($row2);
					echo "funcoin buscar teatro ".$objTeatro; */
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	
    

	public static function listar($condicion=""){
	    $arregloteatro = null;
		$base=new BaseDatos();
		$consultateatros="Select * from teatro ";
		if ($condicion!=""){
		    $consultateatros=$consultateatros.' where '.$condicion;
		}
		$consultateatros.=" order by nombreteatro ";
		//echo $consultateatros;
		if($base->Iniciar()){
			if($base->Ejecutar($consultateatros)){				
				$arregloteatro= array();
				while($row2=$base->Registro()){
					
				   	$row2['coleccionfuncion']=array();
					$teat=new teatro();
					$teat->cargar($row2);
					array_push($arregloteatro,$teat);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloteatro;
	}	


	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO teatro(nombreteatro, direccion) 
				VALUES ("."'".$this->getnombreTeatro()."','".$this->getdireccion()."')";
		//echo "consulta:    ".$consultaInsertar;
		if($base->Iniciar()){

			if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setIdteatro($id);
			    $resp=  true;

			}	else {
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
		$consultaModifica="UPDATE `teatro` SET `nombreteatro`='".$this->getnombreTeatro()."',`direccion`='".$this->getdireccion()
        ."' WHERE idteatro=".$this->getIdteatro();
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
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM teatro WHERE idteatro=".$this->getIdTeatro();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}

	public function modificarTeatro($objTeatro,$nombre,$direccion){
		$objTeatro->getIdTeatro();
        $objTeatro->setnombreTeatro($nombre);
        $objTeatro->setdireccion($direccion); 
		echo $objTeatro;
        $objTeatro->modificar();
    }

   public function seleccionTeatro($idTeatro){
        $objTeatro = new Teatro(); 
        $objTeatro->buscar($idTeatro);
        return $objTeatro; 
    }

   public function eliminarTeatro($objTeatro){
      $funciones = $objTeatro->getcoleccionFuncion();
	 
      $retorno = false;
      $i = 0;
	  if (!$retorno && $i < (count($funciones))){
		  foreach ($funciones as $unaFuncion){
			  $retorno = $unaFuncion->eliminar();
		  }
	  }
      
      if($retorno){
         $retorno = $objTeatro->eliminar();
      }
      return $retorno;
    }
	
	
}

?>