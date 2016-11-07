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

$datos = $conn->getAll("SELECT id, usuario FROM usuarios LIMIT ".(($page-1)*$num_pages).", $num_pages");
echo '
<br>
<table class="table table-bordered">
    <thead>
    <tr>
    <th>Acciones</th><th>C.I</th><th>Email</th><th>Usuario</th><th>Activo</th><th>Estatus</th>
    </tr>
    </thead>
    <tbody>
    

';

foreach ($datos as &$usuarios) {
    
 echo '<tr><td>'.$usuarios["id"].'</td><td>'.$usuarios["usuario"].'</td><td>aa</td><td>xx</td><td>aa</td><td>xx</td></tr>';   
 unset($usuarios);   
}

echo '    </tbody>
</table>';

echo '<center><h4>';
for($i=0; $i<$max_num_paginas;$i++){
echo '<a href="index.php?page=usuarios.administrador&amp;pg='.($i+1).'">'.($i+1).'</a> &nbsp; &nbsp;';
		    } 
echo '</h4></center>';

?>




