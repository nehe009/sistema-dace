<?php 


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
     mensajeError("Este usuario no está registrado.",null);
    goto error;    
 }
#muestro cabecera de tabla de datos
echo '
<br>
<table class="table table-bordered">
    <thead>
    <tr>
    <th>Acciones</th><th>C.I</th><th>Email</th><th>Usuario</th><th>Fecha de Registro</th><th>Fecha de activación</th><th>Fecha ultimo ingreso</th><th>Estado</th>
    </tr>
    </thead>
    <tbody>';        
#Muestro los datos en la tabla
foreach ($datos as &$usuarios) {
    #chequeo los estados de cada cuenta.
    if($usuarios["bloqueo"]==1){$estado="Bloqueada";} else {$estado="Activa";}
    #muestro la informacion de cada cuenta
    echo '<tr><td>'.$usuarios["id"].'</td><td>'.$usuarios["ced_usu"].'</td><td>'.$usuarios["corr_usu"].'</td><td>'.$usuarios["usuario"].'</td><td>'.$usuarios["fecha_registro"].'</td><td>'.$usuarios["fecha_activacion"].'</td><td>'.$usuarios["fecha_ultimo_acceso"].'</td><td>'.$estado.'</td></tr>';   
 unset($usuarios);   
}
#cierro la tabla
echo '</tbody></table>';    
}
#salida para los errores.
error: 
?>
