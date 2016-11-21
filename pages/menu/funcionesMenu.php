<?php
function mostrarMenuUsuarios($array) {
   $i=1;
#recorrido del arreglo para mostrar los menus
foreach ($array as &$menu) {
    if($i==1){ echo '<div class="row">';}
    include $menu;
    if($i==3){ echo '</div>'; $i=0;}
    #muestro la informacion de cada cuenta
    unset($menu); 
    $i++;
    }
if($i==2 or $i==3){echo '</div>';}
}
?>