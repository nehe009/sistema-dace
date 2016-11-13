<?php 

#====================== Paginado ==================================#
#primero obtenemos el parametro que nos dice en que pagina estamos
$page = 1; //inicializamos la variable $page a 1 por default
$num_pages = 50; //numero de registros a mostrar por pagina

if(array_key_exists('pg', $_GET)){
    if(!is_numeric($_GET['pg'])) Header("Location: index.php");
	$page = $_GET['pg']; #si el valor pg existe en nuestra url, significa que estamos en una pagina en especifico.
}
$conteo_query=$conn->getRow("SELECT COUNT(*) as conteo FROM usuarios");
$conteo = $conteo_query["conteo"];
#ahora dividimos el conteo por el numero de registros que queremos por pagina.
#y chequeamos si hay que agregar una pagina mas.
$max_num_paginas = intval($conteo/$num_pages); 		     
if(is_float($conteo/$num_pages)){ 
    $max_num_paginas++;
}
#====================== Fin Paginado ==============================#
#consulta por defecto.
$sql="SELECT id, usuario, ced_usu, corr_usu, fecha_registro, fecha_activacion, fecha_ultimo_acceso, bloqueo FROM usuarios LIMIT ".(($page-1)*$num_pages).", $num_pages";
#realizo consulta a la base de datos
$datos = $conn->getAll($sql);
echo '
<center><h4 class="form-signin-heading">Listar usuarios</h4></center>
<br>
<table class="table table-bordered">
    <thead>
    <tr>
    <th>Acciones</th><th>C.I</th><th>Email</th><th>Usuario</th><th>Fecha de Registro</th><th>Fecha de activación</th><th>Fecha ultimo ingreso</th><th>Estado</th>
    </tr>
    </thead>
    <tbody>';

foreach ($datos as &$usuarios) {
    #chequeo los estados de cada cuenta.
    if($usuarios["bloqueo"]==1){$estado="Bloqueada";} else {$estado="Activa";}
    #muestro la informacion de cada cuenta
    echo '<tr><td>'.$usuarios["id"].'</td><td>'.$usuarios["ced_usu"].'</td><td>'.$usuarios["corr_usu"].'</td><td>'.$usuarios["usuario"].'</td><td>'.$usuarios["fecha_registro"].'</td><td>'.$usuarios["fecha_activacion"].'</td><td>'.$usuarios["fecha_ultimo_acceso"].'</td><td>'.$estado.'</td></tr>';   
 unset($usuarios);   
}

echo '</tbody></table>';

echo '<center><h5>';
for($i=0; $i<$max_num_paginas;$i++){
    if($page==$i+1){
        echo '<a href="index.php?page=usuarios.administrador&amp;pg='.($i+1).'"><ins>'.($i+1).'</ins></a> &nbsp; &nbsp;';
    }else {
        echo '<a href="index.php?page=usuarios.administrador&amp;pg='.($i+1).'">'.($i+1).'</a> &nbsp; &nbsp;';
    }    
} 
echo '</h5></center>';

?>




