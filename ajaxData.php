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
        //$estado["estado"] = mb_convert_encoding($estado["estado"], "UTF-8","ISO-8859-1");
        echo '<option value="'.$estado["id_estado"].'">'.$estado["estado"].'</option>';
    unset($estado);   
    }    
}
#consulta ajax para obtener listado de ciudades
if(isset($_POST["obtenerCiudad"]) && is_numeric($_POST["obtenerCiudad"])){    
    #consulta por id
    $datos = $conn->getAll("SELECT id_ciudad, ciudad FROM localidad_ciudades WHERE id_estado='$_POST[obtenerCiudad]'");  
    foreach ($datos as &$ciudad) {
        //$ciudad["ciudad"] = mb_convert_encoding($ciudad["ciudad"], "UTF-8","ISO-8859-1");
        echo '<option value="'.$ciudad["id_ciudad"].'">'.$ciudad["ciudad"].'</option>';
    unset($ciudad);   
    }    
}
#consulta ajax para obtener listado de municipios
if(isset($_POST["obtenerMunicipio"]) && is_numeric($_POST["obtenerMunicipio"])){    
    #consulta por id
    $datos = $conn->getAll("SELECT id_municipio, municipio FROM localidad_municipios WHERE id_estado='$_POST[obtenerMunicipio]'");  
    foreach ($datos as &$municipio) {
        //$municipio["municipio"] = mb_convert_encoding($municipio["municipio"], "UTF-8","ISO-8859-1");
        echo '<option value="'.$municipio["id_municipio"].'">'.$municipio["municipio"].'</option>';
    unset($municipio);   
    }    
}
#consulta ajax para obtener listado de parroquias
if(isset($_POST["obtenerParroquia"]) && is_numeric($_POST["obtenerParroquia"])){    
    #consulta por id
    $datos = $conn->getAll("SELECT id_parroquia, parroquia FROM localidad_parroquias WHERE id_municipio='$_POST[obtenerParroquia]'");  
    foreach ($datos as &$parroquia) {
        //$parroquia["parroquia"] = mb_convert_encoding($parroquia["parroquia"], "UTF-8","ISO-8859-1");
        echo '<option value="'.$parroquia["id_parroquia"].'">'.$parroquia["parroquia"].'</option>';
    unset($parroquia);   
    }    
}
?>