<div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Menú de navegación</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand visible-xs" href="index.php">Inicio</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="hidden-xs"><a href="index.php">Inicio</a></li>
<?php
if (isset($sesion_usuario)){
    if($permisos_usuario["estudiante"]==1){include("pages/menuEstudiantes.html");}
    if($permisos_usuario["profesor"]==1){include("pages/menuAdministrativo.html");}
    if($permisos_usuario["administrativo"]==1){include("pages/menuProfesor.html");}
    echo('<li><a href="index.php?page=usuarios.perfil">Mi Perfil</a></li>');
    echo('<li><a href="index.php?page=usuarios.cerrarsesion">Cerrar sesión</a></li>');
} else {
    echo('<li><a href="index.php?page=usuarios.nuevo">Registro de Usuarios</a></li>');
    echo('<li><a href="index.php?page=usuarios.login">Iniciar Sesion</a></li>');
}
?>
          </ul>
<?php
                    if (isset($sesion_usuario)){
                        echo ('<ul class="nav navbar-nav navbar-right"><li><a href="index.php?page=usuarios.perfil">Bienvenido(a). ');
                        echo $sesion_usuario['nombre'];
                        echo " ";
                        echo $sesion_usuario['apellido'];
                        echo ('</a></li></ul>');
                    }
?>
        </div>
</div>