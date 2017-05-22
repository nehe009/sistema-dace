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
    if($permisos_usuario["estudiante"]==1){echo('<li><a href="index.php?page=menu.estudiante">Estudiante</a></li>');}
    if($permisos_usuario["profesor"]==1){echo('<li><a href="index.php?page=menu.profesor">Profesor</a></li>');}
    if($permisos_usuario["administrativo"]==1){echo('<li><a href="index.php?page=menu.administrativo">Administrativo</a></li>');}
    echo('<li><a href="index.php?page=usuarios.perfil">Mi Perfil</a></li>');
    echo('<li><a href="index.php?page=usuarios.cerrarsesion">Cerrar sesión</a></li>');
} else {
    echo('<li><a href="index.php?page=usuarios.nuevo">Registro de Usuarios</a></li>');
    echo('<li><a href="index.php?page=usuarios.activacion">Activar Cuenta</a></li>');
    echo('<li><a href="index.php?page=usuarios.login">Iniciar Sesión</a></li>');
}
?>
        <li><a href="index.php?page=documentos.verificar">Verificar Documento</a></li>
        </ul>
<?php
                    if (isset($sesion_usuario)){
                        $nombre = explode(" ", $sesion_usuario['nombre']);
                        $apellido= explode(" ", $sesion_usuario['apellido']);
                        echo ('<ul class="nav navbar-nav navbar-right"><li><a href="index.php?page=usuarios.perfil">Bienvenido(a). ');
                        echo $nombre[0];
                        echo "&nbsp;";
                        echo $apellido[0];
                        echo ('</a><div id="cedulausuario" class="hide">'.$sesion_usuario['ced_usu'].'</div></li></ul>');
                    }
?>
        </div>
</div>