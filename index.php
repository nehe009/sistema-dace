<?php
#manejo de sesiones del sistema
session_start();
if(!empty($_SESSION["sesion_usuario"])){
$sesion_usuario = $_SESSION["sesion_usuario"];
$permisos_usuario = $_SESSION["permisos_usuario"];
}
#define el index principal para evitar ejecucion de otros script indivicuales.
define("ROOT_INDEX", 1);
#librerias usadas en el sistema.
require('lib/adodb/adodb.inc.php'); # load code common to ADOdb
require ('lib/PHPMailer/PHPMailerAutoload.php');
#configuraciones del sistema.
require("config.inc.php");
#Revisa y ejecuta conexion con la base de datos.
$conn = &ADONewConnection(db_engine);  
@$conn->PConnect(db_host,db_user,db_password,db_database);# connect to MySQL
if (!$conn->isConnected()){ die("Problema con la BD");}
#funciones propias del sistema
require("includes/funciones.php");
#Carga estructura de la pagina
include("includes/top_page.php"); 
?>
<div class="container-fluid fondo02">		
    <header class=""><?php include("includes/header.php"); ?></header>     
    <nav class="navbar navbar-default navbar-static-top" role="navigation"><?php include("includes/menu.php"); ?></nav>		    
    <section class="container-fluid fondo"><?php include("includes/pages.php"); ?></section>		
    <footer class="container"><?php include("includes/footer.php"); ?></footer>        
</div>
<?php include("includes/bottom_page.php"); ?>