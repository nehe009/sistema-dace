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
include("formBuscarUsuario.html");
#Comprobamos si se a pulsado el boton OK del formulario de busqueda
if(isset($_POST['ok'])){
    #extraigo variables POST
    extract($_POST);
    $sql="SELECT id, usuario, ced_usu, corr_usu, fecha_registro, fecha_activacion, fecha_ultimo_acceso, bloqueo FROM usuarios WHERE ced_usu LIKE '%$inputBuscar%'";
    #realizo consulta a la base de datos
$datos = $conn->getAll($sql);

 if(empty($datos)){
     mensajeError("Este usuario no está registrado.", "inicio");
    goto error;
 }
#muestro cabecera de tabla de datos
echo '
<div class="table-responsive">
<table class="table table-bordered table-hover table-condensed">
    <thead>
    <tr>
    <th>Acciones</th><th>C.I</th><th>Email</th><th>Usuario</th><th>Fecha de Registro</th><th>Fecha de activación</th><th>Fecha ultimo ingreso</th><th>Estado</th>
    </tr>
    </thead>
    <tbody>';
#Muestro los datos en la tabla
foreach ($datos as &$usuarios) {
    #chequeo los estados de cada cuenta.
    if($usuarios["bloqueo"]==1){$estado="Bloqueado";} else {$estado="Activo";}
    #muestro la informacion de cada cuenta
    echo '<tr><td><a class="glyphicon glyphicon-user" title="Permisos de usuario" href="index.php?page=usuarios.permisos&amp;id='.$usuarios["id"].'"></a>&nbsp;<a class="glyphicon glyphicon-lock" title="Bloquear" href="index.php?page=usuarios.bloquear&amp;id='.$usuarios["id"].'"></a>&nbsp;<a class="glyphicon glyphicon-remove" title="Eliminar" href="index.php?page=usuarios.eliminar&amp;id='.$usuarios["id"].'"></a></td><td>'.$usuarios["ced_usu"].'</td><td>'.$usuarios["corr_usu"].'</td><td>'.$usuarios["usuario"].'</td><td>'.$usuarios["fecha_registro"].'</td><td>'.$usuarios["fecha_activacion"].'</td><td>'.$usuarios["fecha_ultimo_acceso"].'</td><td>'.$estado.'</td></tr>';
 unset($usuarios);
}
#cierro la tabla
echo '</tbody></table></div>';
}
#salida para los errores.
error:
?>