<div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Inicio</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Inicio</a></li>
            
<?php 

if (isset($sesion_usuario)){
    if($permisos_usuario["estudiante"]==1){echo('<li><a href="index.php?page=estudiante">Estudiante</a></li>');}
    if($permisos_usuario["profesor"]==1){echo('<li><a href="index.php?page=profesor">Profesor</a></li>');}
    if($permisos_usuario["administrativo"]==1){echo('<li><a href="index.php?page=administrativo">Administrativo</a></li>');}
    echo('<li><a href="index.php?page=usuarios.cerrarsesion">Cerrar sesión</a></li>');
} else {
    echo('<li><a href="index.php?page=usuarios.nuevo">Registro de Usuarios</a></li>'); 
    echo('<li><a href="index.php?page=usuarios.login">Iniciar Sesion</a></li>');                
}


?>
            
            
            
            
          </ul>
        </div>
</div>
