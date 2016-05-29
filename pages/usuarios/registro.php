<?php

    if(isset($_POST['ok'])){ //Comprobamos si se a pulsado el boton OK
        
        $conn = &ADONewConnection(db_engine);  # create a connection
        $conn->PConnect(db_host,db_user,db_password,db_database);# connect to MySQL
        $sql = 'SELECT * FROM anos';
        $rs = $conn->Execute($sql);
        print $rs;
        //include("pages/usuarios/formRegistro2.html");
        } else { #si no se pulso ok se muestra formulario para iniciar sesion.

        include("pages/usuarios/formRegistro.html");

        }

?>


