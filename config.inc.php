<?php
/* Informacion de la pagina web */
define("web_title", "Sistema integral de control de estudios de la UPT Aragua");
define("web_description", "");
define("web_author", "");
/* configuracion de la base de datos #1 */
define("db_host_1", "localhost");
define("db_engine_1", "mysqli");
define("db_user_1", "root");
define("db_password_1", "");
define("db_database_1", "departamento");
/* configuracion de la base de datos #2 */
define("db_host_2", "localhost");
define("db_engine_2", "mysqli");
define("db_user_2", "root");
define("db_password_2", "");
define("db_database_2", "sistema_dace");
/* configuracion del sitio */
define("site_url", "localhost");
/* configuracion para envio de correo electronico */
define("mail_host", "localhost");
define("mail_port", "587");
define("mail_encrypt", "tls");
define("mail_user", "root");
define("mail_pass", "");
define("mail_from", "root@localhost");
/* configuracion de zona horaria */
date_default_timezone_set('America/Caracas');
?>