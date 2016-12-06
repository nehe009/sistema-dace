<?php 
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si ya inicio sesion
if (!isset($sesion_usuario)) {
    mensajeError("No has iniciado sesión.",'inicio','Ir a Inicio');
    goto error;
}
#Permite que solamente administradores entren a este modulo.
if(!$permisos_usuario["administrativo"]==1){
    mensajeError("No tienes permiso para entrar a este módulo.",'inicio','Ir a Inicio');
    goto error;
}
#Permite que solamente administradores con control total entren a este modulo.
if(!$permisos_usuario["control_total"]==1){
    mensajeError("No tienes permiso para entrar a este módulo.",'inicio','Ir a Inicio');
    goto error;
}
#muestro formulario
include("formBuscarAuditoria.html");
#Comprobamos si se a pulsado el boton OK del formulario de busqueda
if(isset($_POST['ok'])){
    #extraigo variables POST
    extract($_POST);
    $sql="SELECT * FROM auditoria_usuarios WHERE cedula_usuario LIKE '%$inputBuscar%' ORDER BY fecha DESC";
    #realizo consulta a la base de datos
$datos = $conn->getAll($sql);

 if(empty($datos)){
     mensajeError("Este usuario no tiene registros para auditar.", "inicio");
    goto error;
 }
#muestro cabecera de tabla de datos
echo '
<div class="table-responsive">
<table class="table table-bordered table-hover table-condensed">
    <thead><tr>
    <th>Cedula de Identidad</th><th>Dirección IP</th><th>Navegador Web</th><th>Sistema Operativo</th><th>Fecha de Registro</th><th>Acción realizada</th>
    </tr></thead>
    <tbody>';
#Muestro los datos en la tabla
foreach ($datos as &$usuarios) {
    #muestro la informacion de cada cuenta
    echo '<tr><td>'.$usuarios["cedula_usuario"].'</td><td>'.$usuarios["ip"].'</td><td>'.$usuarios["navegador"].'</td><td>'.$usuarios["so"].'</td><td>'.$usuarios["fecha"].'</td><td>'.$usuarios["accion"].'</td></tr>';
 unset($usuarios);
}
#cierro la tabla
echo '</tbody></table></div>';
}
#salida para los errores.
error:
?>