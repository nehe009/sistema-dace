<?php
require('lib/adodb/adodb.inc.php'); # load code common to ADOdb
require("config.inc.php");
require ("includes/funciones.php");
iniciarBD();
//header('Content-Type: text/html; charset=utf-8');
#consulta ajax para obtener listado de paises
if(isset($_POST["obtenerPais"]) && is_numeric($_POST["obtenerPais"])){    
    #consulta de paises.
    $datos = $conn->getAll("SELECT id_pais, pais FROM localidad_paises ORDER BY pais ASC");    
    foreach ($datos as &$pais) {
        echo '<option value="'.$pais["id_pais"].'">'.$pais["pais"].'</option>';
    unset($pais);   
    }   
}
#consulta ajax para obtener listado de estados
if(isset($_POST["obtenerEstado"]) && is_numeric($_POST["obtenerEstado"])){    
    #consulta por id
    $datos = $conn->getAll("SELECT id_estado, estado FROM localidad_estados ORDER BY estado ASC");    
    foreach ($datos as &$estado) {
        echo '<option value="'.$estado["id_estado"].'">'.$estado["estado"].'</option>';
    unset($estado);   
    }    
}
#consulta ajax para obtener listado de ciudades
if(isset($_POST["obtenerCiudad"]) && is_numeric($_POST["obtenerCiudad"])){    
    #consulta por id
    $datos = $conn->getAll("SELECT id_ciudad, ciudad FROM localidad_ciudades WHERE id_estado='$_POST[obtenerCiudad]'");  
    foreach ($datos as &$ciudad) {
        echo '<option value="'.$ciudad["id_ciudad"].'">'.$ciudad["ciudad"].'</option>';
    unset($ciudad);   
    }    
}
#consulta ajax para obtener listado de municipios
if(isset($_POST["obtenerMunicipio"]) && is_numeric($_POST["obtenerMunicipio"])){    
    #consulta por id
    $datos = $conn->getAll("SELECT id_municipio, municipio FROM localidad_municipios WHERE id_estado='$_POST[obtenerMunicipio]'");  
    foreach ($datos as &$municipio) {
        echo '<option value="'.$municipio["id_municipio"].'">'.$municipio["municipio"].'</option>';
    unset($municipio);   
    }    
}
#consulta ajax para obtener listado de parroquias
if(isset($_POST["obtenerParroquia"]) && is_numeric($_POST["obtenerParroquia"])){    
    #consulta por id
    $datos = $conn->getAll("SELECT id_parroquia, parroquia FROM localidad_parroquias WHERE id_municipio='$_POST[obtenerParroquia]'");  
    foreach ($datos as &$parroquia) {
        echo '<option value="'.$parroquia["id_parroquia"].'">'.$parroquia["parroquia"].'</option>';
    unset($parroquia);   
    }    
}
#consulta ajax para mantener bandera de usuario online
if(isset($_POST["useronline"]) && is_numeric($_POST["useronline"])){    
    #consulta a para mantener encendida bandera de usuario online
    $conn->Execute("UPDATE usuarios SET online=1 WHERE ced_usu='$_POST[useronline]'");
}
#consulta ajax para usuario online
if(isset($_POST["getuseronline"]) && is_numeric($_POST["getuseronline"])){
$conexion=0;    
    #consulta de usuarios online
    $datos = $conn->getAll("SELECT usuario, ced_usu, fecha_ultimo_acceso, corr_usu FROM usuarios WHERE online=1"); 
    foreach ($datos as &$usuarios) {
        $conexion++;
        echo '<tr><td>'.$usuarios["usuario"].'</td><td>'.$usuarios["usuario"].'</td><td>'.$usuarios["ced_usu"].'</td><td>'.$usuarios["corr_usu"].'</td><td>'.$usuarios["usuario"].'</td><td>'.$usuarios["fecha_ultimo_acceso"].'</td></tr>';
    unset($usuarios);
    }
    echo '=conectados='.$conexion.'';
}
?>