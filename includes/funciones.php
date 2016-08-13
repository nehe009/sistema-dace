<?php
function auditoriaUsuarios($cedula,$accion) {
    #Revisa y ejecuta conexion con la base de datos.
    $conn = &ADONewConnection(db_engine);  
    @$conn->PConnect(db_host,db_user,db_password,db_database);# connect to MySQL
    if (!$conn->isConnected()){ die("Problema con la BD");}
    #direccion ip del visitante
    $ip = $_SERVER ['REMOTE_ADDR'];
    $sql="INSERT INTO `auditoria_usuarios` (id, cedula_usuario, ip, fecha, accion) VALUES ('NULL', '$cedula', '$ip', NOW(), '$accion')";
    #inserto registro en la base de datos.    
    if ($conn->Execute($sql) === false){
        mensajeError("Registro de auditoria ha fallado.", 'inicio');
    }
}

function mensajeError($mensaje, $link) {
    #Muestra mensaje de error
    echo '<div class="page-header">
        <div class="alert alert-danger" role="alert">
        <strong>Error:</strong> '.$mensaje.' ';
    if ($link=="inicio"){
        echo '<a href="index.php"> Ir a Inicio</a></div></div>';        
    }else{
        echo '<a href="'.$_SERVER['REQUEST_URI'].'"> Volver Atrás</a></div></div>';
    }
}

function mensajeSuccess($mensaje, $link) {
    #Muestra mensaje
    echo '<div class="page-header">
        <div class="alert alert-success" role="alert">
        <strong>Listo:</strong> '.$mensaje.' ';
    if ($link=="inicio"){
        echo '<a href="index.php"> Ir a Inicio</a></div></div>';        
    }else{
        echo '<a href="'.$_SERVER['REQUEST_URI'].'"> Volver Atrás</a></div></div>';
    }
}

function generateCode($characters) {
/* list all possible characters, similar looking characters and vowels have been removed */
    $possible = '23456789bcdfghjkmnpqrstvwxyzBCDFGHJKMNPQRSTVWXYZ';
    $code = '';
    $i = 0;
    while ($i < $characters) { 
	$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
	$i++;
	}
	return $code;
}

?>