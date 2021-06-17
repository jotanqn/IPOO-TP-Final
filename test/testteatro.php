<?php
include_once '../datos/BaseDatos.php';
include_once '../datos/Teatro.php';
include_once '../datos/Funcion.php';
include_once '../datos/ObraTeatro.php';
include_once '../datos/Musical.php';
include_once '../datos/Cine.php';
/** carga nombre funcion del teatro
 * return strin $nombreFuncion
 */
function cargarNombreFuncion()
{
    echo "\nIngrese el Nombre de la Funcion :";
    $nombreFuncion =  trim(fgets(STDIN));
    return $nombreFuncion;
}
/** carga precio funcion del teatro
 * return int $precioFuncion
 */



function cargarHoraDeInicio()
{
    do {
        echo "\nIngrese la hora (0 a 23): ";
        $hora = trim(fgets(STDIN));
        if (is_numeric($hora) && $hora > -1 && $hora < 24) {
            $opcionValida = true;
        } else {
            echo "\n";
            print ("\e[1;37;41mDebe ingresar un hora valida entre 0 y 23\e[0m") . "\n";

            $opcionValida = false;
        }
    } while (!$opcionValida);

    do {
        echo "\nIngrese los minutos (0 a 59): ";
        $minutos = trim(fgets(STDIN));
        if (is_numeric($minutos) && $minutos > -1 && $minutos < 60) {
            $opcionValida = true;
        } else {
            echo "\n";
            print ("\e[1;37;41mDebe ingresar minutos validos entre 0 y 59  \e[0m") . "\n";

            $opcionValida = false;
        }
    } while (!$opcionValida);
    // Convierto a minutos la hora de inicio + los minutos
    $horaDeInicio =  $hora * 60 + $minutos;
    return $horaDeInicio;
}
/** carga nombre funcion del teatro
 * return strin $nombreFuncion
 */
function cargarDuracionFuncion()
{
    do {
        echo "\nIngrese los minutos de duracion de la funcion): ";
        $duracionFuncion = trim(fgets(STDIN));
        if (is_numeric($duracionFuncion) && $duracionFuncion > 0) {
            $opcionValida = true;
        } else {
            echo "\n";
            print ("\e[1;37;41mError: Debe ingresar un duracion valida en minutos\e[0m") . "\n";
            $opcionValida = false;
        }
    } while (!$opcionValida);
    return $duracionFuncion;
}

function cargarPrecioFuncion()
{
    echo "ingrese el Precio la Funcion :";
    $precioFuncion =  trim(fgets(STDIN));
    
    return $precioFuncion;
}

function cargarDatosTeatro($objTeatro)
{
    echo "Ingrese el Nombre del Teatro";
    $param['nombreteatro'] = trim(fgets(STDIN));
    echo "Ingrese la direccion";
    $param['direccion'] = trim(fgets(STDIN));
    $param['idteatro'] = 0;
    $param['coleccionfuncion'] = array();
    $objTeatro->cargar($param);

    $respuesta = $objTeatro->insertar();

    // Inserto el OBj Teatro en la base de datos

    if ($respuesta == true) {
        echo "\nOP INSERCION;  el tratro fue ingresada en la BD \n";
        echo "Listado de teatros \n";
        $colTeatros = $objTeatro->listar("");
        foreach ($colTeatros as $unTeatro) {
            echo $unTeatro;
            echo "-------------------------------------------------------";
        }
    } else {
        echo $objTeatro->getmensajeoperacion();
    }
    return $objTeatro;
}

function selecciondetreatro($objTeatro){

        $colTeatros = $objTeatro->listar();
        foreach ($colTeatros as $unteatro) {
            echo "ID Teatro: ".$unteatro->getIdTeatro() . "  -  Nombre Teatro" . $unteatro->getnombreTeatro() . "\n";
            echo "--------------------------------------------------------" . "\n";
        }
        echo "Seleccione ID del teatro a trabajar ";
        $idTeatro = trim(fgets(STDIN));
        $objTeatro->Buscar($idTeatro);
   return $objTeatro;
}




// Programa PRINCIPAL

// se crea un objeto Teatro
$objTeatro = new Teatro();
//Busco todas las Teatros almacenadas en la BD
$colTeatros = $objTeatro->listar();
// si no hay teatros en la base primero solicito cargar uno
if (count($colTeatros) == 0) {
    echo "No hay teatros en la base, debe cargar al menos uno\n";
    $teatro = cargarDatosTeatro($objTeatro);
}


do{
    $colTeatros = $objTeatro->listar();
    echo "--------------------------------------------------------------\n";
    foreach ($colTeatros as $unteatro) {

        echo $unteatro . "\n";
        echo "--------------------------------------------------------" . "\n";
    }
    echo "1) Cambiar  Nombre  del Teatro. \n";
    echo "2) Cambiar la direccion del Teatro. \n";
    echo "3) Modificar nombre y Precio de la funcion. \n";
    echo "4) Agregar una funcion. \n";
    echo "5) Precio Costo\n";
    echo "6) Eliminar Teatro\n";
    echo "7) Eliminar Funcion\n";
    echo "0) Salir. \n";
    echo "--------------------------------------------------------------\n";

    // Ingreso y lectura de la opcion
    echo "Ingrese una opcion: ";
    $opcion = (int) trim(fgets(STDIN));
    switch ($opcion) {
        case 1:
            $objTeatro = new Teatro();
            $objTeatro = selecciondetreatro($objTeatro);

            echo "Ingrese el Nombre del Teatro ";
            $nombre= trim(fgets(STDIN));
            $objTeatro->setnombreTeatro($nombre);
            /* echo "Ingrese la direccion ";
            $direccion= trim(fgets(STDIN));
            $teatro->setdireccion($direccion); */
            $objTeatro->modificar();

            break;
        case 2:
            $objTeatro = new Teatro();
            $objTeatro = selecciondetreatro($objTeatro);
            /* echo "Ingrese el Nombre del Teatro ";
            $nombre= trim(fgets(STDIN));
            $teatro->setnombreTeatro($nombre); */
            echo "Ingrese la direccion ";
            $direccion= trim(fgets(STDIN));
            $objTeatro->setdireccion($direccion);
            $objTeatro->modificar();
            break;
        case 3:
            do {
                $objTeatro = new Teatro();
                $objTeatro = selecciondetreatro($objTeatro);
                $coleccionFuncion = $objTeatro->getcoleccionFuncion();
                $cantFunciones = count ($coleccionFuncion);
                $i=1;
                foreach ($coleccionFuncion as $funcion ) {
                    echo "\nn°Funcion: ".$i."  Nombre  :" . $funcion->getnombreFuncion() . " Precio : " . $funcion->getprecioFuncion();
                    $i++;
                }
                echo "\n Que funcion desea cambiar? (1 a " . $cantFunciones . ")";

                $cambiarFuncion = (trim(fgets(STDIN)));
                //Verificamos que ingrese numeros y que sea entre 1 y XXX
                if (is_numeric($cambiarFuncion) && $cambiarFuncion > 0 && $cambiarFuncion < ($cantFunciones + 1)) {
                    $cambiarFuncion=$cambiarFuncion-1;
                    $objFuncion = $coleccionFuncion[$cambiarFuncion];
                    $opcionValida = true;
                    $cambiarFuncion = $cambiarFuncion - 1;
                    $nombreFuncion = cargarNombreFuncion();
                    $precioFuncion = cargarPrecioFuncion();
                    $objFuncion->setnombreFuncion($nombreFuncion);
                    $objFuncion->setprecioFuncion($precioFuncion);
                    $objFuncion->modificar();                
                } else {
                    echo "Debe ingresar una opcion valida \n";
                    $opcionValida = false;
                }
            }   while (!$opcionValida);


            break;
        case 4:
            do {
                $objTeatro = new Teatro();
                $objTeatro = selecciondetreatro($objTeatro);
                echo "Que tipo de Nueva Funcion desea agergar?:\n";
                echo "1) Obra Teatro. \n";
                echo "2) Cine. \n";
                echo "3) Musical. \n";
                echo "0) Cancela";
                echo "--------------------------------------------------------------\n";

                // Ingreso y lectura de la opcion
                echo "Ingrese una opcion: ";
                $tipo = (int) trim(fgets(STDIN));

                if ($tipo != 0) {
                    $horaDeInicio = cargarHoraDeInicio();
                    $duracionFuncion = cargarDuracionFuncion();
                    $exiteFuncion = $objTeatro->verificaSolapamientoDeFunciones($horaDeInicio, $duracionFuncion);


                    if ($exiteFuncion) {
                        echo "\n";
                        print ("\e[1;37;41mNo se puede cargar en ese horario se solapan con otra funcion\e[0m") . "\n";
                        $tipo = 0;
                    } else {
                        $cantFunciones = count($objTeatro->getcoleccionFuncion());
                        echo "\nSe puede agragar funcion no se solapa\n Numero de funciones " . $cantFunciones . "\n";
                        $nombreFuncion = cargarNombreFuncion();
                        $precioFuncion = cargarPrecioFuncion();
                        switch ($tipo) {

                            case 1:
                                $objTeatro->agregarObra($nombreFuncion, $precioFuncion, $horaDeInicio, $duracionFuncion, $objTeatro);
                                $tipo = 0;
                                break;

                            case 2:
                                echo "\nIngrese el Genero de la Pelicula :";
                                $genero = trim(fgets(STDIN));
                                echo "\nIngrese el Pais de Origen :";
                                $paisOrigen = trim(fgets(STDIN));

                                $objTeatro->agregarCine($nombreFuncion, $precioFuncion, $horaDeInicio, $duracionFuncion, $genero, $paisOrigen, $objTeatro);
                                $tipo = 0;
                                break;
                            case 3:
                                echo "\nIngrese el Director del Musical :";
                                $director = trim(fgets(STDIN));
                                echo "\nIngrese la Cantidad de Personas en Escena  :";
                                $cantidadEscena = trim(fgets(STDIN));

                                $objTeatro->agregarMusical($nombreFuncion, $precioFuncion, $horaDeInicio, $duracionFuncion, $director, $cantidadEscena, $objTeatro);
                                $tipo = 0;
                                break;
                        }
                    }
                }
            } while ($tipo != 0);
            break;
        case 5:
            $arregloCosto = array();
            $objTeatro = new Teatro;
            $objTeatro = selecciondetreatro($objTeatro);
            echo "Precio de costo de las funciones \n";
            $coleccionFuncion = $objTeatro->getcoleccionFuncion();
            $i = 0;
            echo "Tipo Funcion  ----------   Precios   ---------  Costo \n";
            foreach ($coleccionFuncion as $funcion) {
                echo  get_class($funcion)."   ----------   ". $funcion->getprecioFuncion(). "   ----------   ".
                $funcion->darCosto()."\n";
                $i++;
            }
            break;
        case 6: // Elimnar teatro
            $objTeatro = new Teatro;
            $objTeatro = selecciondetreatro($objTeatro);
            $eliminar= $objTeatro->eliminarTeatro($objTeatro);
            if ($eliminar){
                echo "El teatro no se pudo eliminar";
            }else{
                echo "Teatro Eliminado con exito";
                $opcion=0;
            }
            break;
        case 7://Eliminar funcion
            $objTeatro = new Teatro();
                $objTeatro = selecciondetreatro($objTeatro);
            do {
                
                $coleccionFuncion = $objTeatro->getcoleccionFuncion();
                $cantFunciones = count ($coleccionFuncion);
                $i=1;
                foreach ($coleccionFuncion as $funcion ) {
                    echo "\nFuncion ".$i." - ".$funcion;
                    $i++;
                }
                echo "\n Que funcion desea Eliminar? (1 a " . $cantFunciones . ")  sino letra c (cancela)";

                $eliminarFuncion = (trim(fgets(STDIN)));
                //Verificamos que ingrese numeros y que sea entre 1 y XXX
                if (is_numeric($eliminarFuncion) && $eliminarFuncion > 0 && $eliminarFuncion < ($cantFunciones + 1)) {
                    $opcionValida = true;
                    $eliminarFuncion = $eliminarFuncion - 1;
                    $objFuncion=$coleccionFuncion[$eliminarFuncion];
                    $objFuncion= $objFuncion->eliminar();
                } elseif($eliminarFuncion="c"){
                    $opcionValida= true;
                }else {
                    echo "Debe ingresar una opcion valida \n";
                    $opcionValida = false;
                }
            }   while (!$opcionValida);

    }

} while ($opcion!= 0);
