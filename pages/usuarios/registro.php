<?php

    if(isset($_POST['ok'])){ #Comprobamos si se a pulsado el boton OK
        #chequeo si el Captcha esta correcto.
        if(isset($_SESSION['security_code_login']) && !empty($_SESSION['security_code_login']) && $_POST['inputCaptcha'] != $_SESSION['security_code_login']){
            mensajeError("Captcha incorrecto.",null);
        } else {       
            extract($_POST);
            //print_r($_POST);
            $conn = &ADONewConnection(db_engine);  # create a connection
            $conn->PConnect(db_host,db_user,db_password,db_database);# connect to MySQL
            #chequeo si la cedula se encuentre en la bd de estudiantes
            $sql = "SELECT id FROM data_estudiantes WHERE ced_est=$inputCedula";        
            $ar = $conn->getRow($sql);
            if(empty($ar)){
                mensajeError("Usted no es estudiante de esta institución.",null);
            } else {
                echo"si es estudiante";
                #chequeo si la cedula esta registrada en la bd de usuarios
                $sql = "SELECT id FROM data_usuarios WHERE ced_usu=$inputCedula";        
                $ar = $conn->getRow($sql);
                if(!empty($ar)){
                    mensajeError("Esta cedula de identidad ya se encuentra registrada.",null);
                    } else {
                        #chequeo si el email esta registrado en la bd de usuarios
                        $sql = "SELECT id FROM data_usuarios WHERE corr_usu=$inputEmail";        
                        $ar = $conn->getRow($sql);
                        if(empty($ar)){
                            mensajeError("Este correo electrónico ya se encuentra registrado.",null);
                            } else {
                                echo"correo no esta registrado";
                            }
                    }
            }
        }
//print $rs;
        //print_r($ar);
        } else { #si no se pulso ok se muestra formulario de registro
            include("pages/usuarios/formRegistro.html");
        }

?>


