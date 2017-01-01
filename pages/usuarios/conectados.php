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
#muestro de tabla de datos
echo '
<script src="js/usuariosEnLinea.js"></script>
<h4 align="center" role="presentation">Usuarios en línea <span id="usuarios_online" class="badge">0</span></h4>
<div class="table-responsive">
<table class="table table-bordered table-hover table-condensed">
<thead><tr><th>Nombres</th><th>Apellidos</th><th>Cedula de Identidad</th><th>Email</th><th>Usuario</th><th>Fecha ultimo ingreso</th></tr></thead>
<tbody id="usuarios"></tbody></table></div>
<br>
<div ></div>';
#salida para los errores.
error:
?>