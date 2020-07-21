<?php
session_start();
if (empty($_SESSION['user'])){
    echo "no estas registrado";
    die();
}
require_once '../../conection/conexion.php';



$nombres = $_POST['nombres'];
$apellido_p = $_POST['apellido_p'];
$apellido_m = $_POST['apellido_m'];
$nombre_c = $nombres . " " . $apellido_p . " " . $apellido_m;

$vulnerable = $_POST['vulnerable'];
$genero = $_POST['genero'];
$curp = $_POST['curp'];
$tipo_identificacion = $_POST['tipo_identificacion'];
$numero_identificacion = $_POST['numero_identificacion'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$whats = $_POST['whats'];

$fecha_nacimiento = $_POST['fecha_nacimiento'];

$nivel = $_POST['nivel'];

$estado_civil = $_POST['estado_civil'];
$num_hijos = $_POST['num_hijos'];
$ocupacion = $_POST['ocupacion'];
$pensionado = $_POST['pensionado'];
$enfermedades_cron = $_POST['enfermedades_cron'];
$cp = $_POST['cp'];

$calle = $_POST['dir_calle'];
$numero = $_POST['dir_numero'];
$numero_int = $_POST['dir_numero_int'];
$id_colonia = $_POST['id_colonia'];
$otra_colonia = (isset($_POST['otra_colonia'])) ? $_POST['otra_colonia'] : NULL;
$municipio = "Metepec";
$manzana $_POST['manzana'];
$lote $_POST['lote'];
$dir_referencia = $_POST['dir_referencia'];

$id_empleado = $_SESSION['user']['id_empleado'];

$medio = $_POST['medio'];
$origen = $_POST['origen'];
$promueve = $_POST['promueve'];

$zona_electoral = $_POST['zona_electoral'];
$seccion_electoral = $_POST['seccion_electoral'];
$participo_eleccion = $_POST['participo_eleccion'];
$posicion = $_POST['posicion'];
$asisitio = $_POST['asisitio'];
$afiliacion = $_POST['afiliacion'];

$observaciones = $_POST['observaciones'];





function alta_auxiliar($con){
    
    $empleado = $_SESSION['user']['id_empleado'];
    $sql_unico = $con->prepare('SELECT * FROM beneficiarios WHERE id_empleado = ? ORDER BY id_beneficiario DESC');
    $sql_unico->execute(array($empleado));
    $beneficiario = $sql_unico->fetch();


    $nombres_aux = $_POST['nombres_auxiliar'];
    $apellido_p_aux = $_POST['apellido_p_auxiliar'];
    $apellido_m_aux = $_POST['apellido_m_auxiliar'];
    $telefono_auxiliar = $_POST['telefono_auxiliar'];
    $parentesco = $_POST['parentesco'];
    $id_del_beneficiario = $beneficiario['id_beneficiario'];
    
    $sql_agregar_beneficiario = 'INSERT INTO auxiliares VALUES (NULL, ?, ?, ?, ?, ?, ?)';
    $sentencia_agregar_beneficiario = $con->prepare($sql_agregar_beneficiario);

    try{
        $sentencia_agregar_beneficiario->execute(array($nombres_aux, $apellido_p_aux, $apellido_m_aux, $telefono_auxiliar, $id_del_beneficiario, $parentesco));
    }catch(Exception $e){
        echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }  

    
}

function alta_beneficiario($con){
 
    $sql_agregar = 'INSERT INTO beneficiarios (id_beneficiario, fecha_captura, nombre_c, nombres, apellido_p, apellido_m, vulnerable, genero, curp, tipo_identificacion, numero_identificacion, telefono, email, whats, fech_nacimiento, nivel, dir_calle, dir_numero, dir_numero_int, id_colonia, otra_colonia, municipio, dir_referencia, solicitud_basico, id_empleado, id_medio_contacto, id_origenes, id_promotores) 
    VALUES (NULL, CURRENT_TIMESTAMP(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
    $sentencia_agregar = $con->prepare($sql_agregar);

    try{
        $sentencia_agregar->execute(array($nombre_c, $nombres, $apellido_p, $apellido_m, $vulnerable, $genero, $curp, $tipo_identificacion, $numero_identificacion, $telefono, $email, $whats, $fech_nacimiento, $nivel, $calle, $numero, $numero_int, $colonia, $otra_colonia, $municipio, $referencia, $solicitud_basico, $id_empleado, $medio, $origen, $promueve));
    }catch(Exception $e){
        echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }  

}


function actualizar($con){

    $sql_editar = "UPDATE beneficiarios SET nombre_c=?, nombres=?, apellido_p=?, apellido_m=?, vulnerable=?, genero=?, curp=?, tipo_identificacion=?, numero_identificacion=?, telefono=?, email=?, whats=?, fecha_nacimiento=?, nivel=?, estado_civil=?, num_hijos=?, ocupacion=?, pensionado=?, enfermedades_cron=?, cp=?, dir_calle=?, dir_numero=?, dir_numero_int=?, id_colonia=?, otra_colonia=?, municipio=?, manzana=?, lote=?, dir_referencia=?, id_empleado=?, id_medio_contacto=?, id_origenes=?, id_promotores=?, zona_electoral=?, seccion_electoral=?, participo_eleccion=?, posicion=?, asisitio=?, afiliacion=?, nivel_satisfaccion=?
    WHERE id_beneficiario = ?";
    $sentencia_agregar = $con->prepare($sql_editar);

    try{
        $sentencia_agregar->execute(array($nombre_c, $nombres, $apellido_p, $apellido_m, $vulnerable, $genero, $curp, $tipo_identificacion, $numero_identificacion, $telefono, $email, $whats, $fech_nacimiento, $nivel, $calle, $estado_civil, $num_hijos, $ocupacion, $pensionado, $enfermedades_cron, $cp, $dir_calle, $dir_numero, $dir_numero_int, $id_colonia, $otra_colonia, $municipio, $manzana, $lote, $dir_referencia, $id_empleado, $medio, $origen, $promueve, $zona_electoral, $seccion_electoral, $participo_eleccion, $posicion, $asistio, $afiliacion, $nivel_satisfaccion));
    }catch(Exception $e){
        echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }  


}




if(array_key_exists("guardar_salir",$_POST)){
    alta_beneficiario($con);
    if(isset($_POST['nombres_auxiliar'])){
        alta_auxiliar($con);
    }
    header("Location: ../beneficiarios");
}

if(array_key_exists("actualizar",$_POST)){
    actualizar($con);
}


 
?>



<!-- INSERT INTO beneficiarios (`id_beneficiario`, `fecha_captura`, `nombre_c`, `nombres`, `apellido_p`, `apellido_m`, `vulnerable`, `genero`, `curp`, `tipo_identificacion`, `numero_identificacion`, `telefono`, `email`, `whats`, `fecha_nacimiento`, `nivel`, `estado_civil`, `num_hijos`, `ocupacion`, `pensionado`, `enfermedades_cron`, `cp`, `dir_calle`, `dir_numero`, `dir_numero_int`, `id_colonia`, `otra_colonia`, `municipio`, `manzana`, `lote`, `dir_referencia`, `id_empleado`, `id_medio_contacto`, `id_origenes`, `id_promotores`, `zona_electoral`, `seccion_electoral`, `participo_eleccion`, `posicion`, `asisitio`, `afiliacion`, `nivel_satisfaccion`) VALUES (NULL, '2020-07-20 00:00:00', '', 'German', 'Guillen', 'Sanchez', 'si', 'm', 'awweq3edqwa', 'ine', '234234', '7224531128', 'goder@live.com', 'si', '1990-03-17', '5', 'soltero', '0', 'Programador', 'no', 'Compu', '50250', 'progreso', '6', NULL, '15', NULL, 'Metepec', NULL, NULL, 'Cerca del colegio mexiquense', '1', '1', '1', '1', NULL, NULL, 'si', 'Secretario', 'si', 'Pri', '5'); -->