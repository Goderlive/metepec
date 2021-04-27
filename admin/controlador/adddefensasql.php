<?php
session_start();
if (empty($_SESSION['user'])){
    echo "no estas registrado";
    die();
}
if (!$_GET) {
echo "Algo salio mal";
die();
}
require_once '../../conection/conexion.php';

$id_ciudadano = $_GET['id'];
$up = $_SESSION['user']['id_ciudadano'];

function Capacitaciones($con, $id, $capacitacion, $actual, $def){
    $stm = $con->query("SELECT * FROM capacitaciones_defensa WHERE id_ciudadano = $id");
    $capacitaciones = $stm->fetch(PDO::FETCH_ASSOC);
    $nid = $def-4;


    if($capacitaciones){
        $nrows = $con->exec("UPDATE capacitaciones_defensa SET $capacitacion = $actual WHERE id_ciudadano = $id");
        header("Location: ../defensa.php#$nid");
    }else{
        $nrows = $con->exec("INSERT INTO capacitaciones_defensa ($capacitacion, id_ciudadano) VALUES($actual, $id)");
        header("Location: ../defensa.php#$nid");
    }
}


function changeStatus($con, $id, $status){
    $nid = $id - 4;
    $status = ($status == 1) ? 0 : 1;
    $nrows = $con->exec("UPDATE puestos_defensa SET confirmacion = $status WHERE id_defensa = $id");
    header("Location: ../defensa.php#$nid");
}


function inamovible($con, $id, $status){
    $nid = $id - 4;
    $status = ($status == 1) ? 0 : 1;
    $nrows = $con->exec("UPDATE puestos_defensa SET inamovible = $status WHERE id_defensa = $id");
    header("Location: ../defensa.php#$nid");
}


function borrarAlta($con, $id){
    $nrows = $con->exec("UPDATE puestos_defensa SET id_ciudadano=NULL, previo = NULL, posicion_prev= NULL, asistio = NULL, compromiso=NULL, afiliacion=NULL, origen=NULL, cubre=NULL, up=NULL, confirmacion=NULL WHERE id_defensa=$id");
    header("Location: ../defensa.php");
}


function nuevo($con, $id_ciudadano, $puesto, $up){
    $npuesto = $puesto -4;
    $sql_puestos = "UPDATE puestos_defensa SET id_ciudadano = $id_ciudadano, up = $up, confirmacion = 0 WHERE id_defensa = $puesto";
    $sentencia_puestos = $con->prepare($sql_puestos);
    try{  
        $sentencia_puestos->execute();
        header("Location: ../defensa.php?id=".$id_ciudadano.'#'.$npuesto);
    }catch(Exception $e){
        echo 'Error al agregar un nuevo: ',  $e->getMessage(), "\n";
        die();
    }  

}

if (isset($_GET['borrar']) && $_GET['borrar'] != 0) {
    $id=$_GET['id'];
    borrarAlta($con, $id, $borrar);
}


if (isset($_GET['status']) && $_GET['status'] != '') {
    $id = $_GET['id'];
    $status = (isset($_GET['status']) && $_GET['status'] != '') ? $_GET['status'] : '';
    changeStatus($con, $id, $status);
}

if (isset($_GET['nuevo']) && $_GET['nuevo'] == '1'){
    $puesto = $_GET['casilla'];
    nuevo($con, $id_ciudadano, $puesto, $up);
}


if (isset($_GET['inamovible']) && $_GET['inamovible'] != ''){
    $puesto = $_GET['id'];
    $status = $_GET['inamovible'];
    inamovible($con, $puesto, $status);
}


if (isset($_GET['cap1']) || isset($_GET['cap2'])){
    $id = $_GET['id'];
    $def = $_GET['def'];
    if(isset($_GET['cap1'])){
        $actual = ($_GET['cap1'] == 1) ? 0 : 1;
        $capacitacion = 'capacitacion1';
    }
    if(isset($_GET['cap2'])){
        $actual = ($_GET['cap2'] == 1) ? 0 : 1;
        $capacitacion = 'capacitacion2';
    }
    Capacitaciones($con, $id, $capacitacion, $actual, $def);
}

$con=null;
?>
