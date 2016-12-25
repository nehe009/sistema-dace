$(document).ready(function(){
//$('#inputAnoGrado').datepicker({format: "yyyy",startView: 2,minViewMode: 2,maxViewMode: 2,autoclose: true,language: 'es'});
$(document).on('click','#fecha_nacimiento_familiar',function(){
    $('#fecha_nacimiento_familiar').datepicker({pickTime: false,format: "yyyy-mm-dd",startView: 2,autoclose: true,language: 'es'});
}); 
//asigna valores a los select, con los datos leidos de la base de datos.
    //trabaja
    if($('#inputTrabaja').val()=="0"){$("#inputTrabaja option[value='0']").attr("selected",true);}
    if($('#inputTrabaja').val()=="1"){$("#inputTrabaja option[value='1']").attr("selected",true);}
//discapacidad
    if($('#inputDiscapacidad').val()=="0"){$("#inputDiscapacidad option[value='0']").attr("selected",true);}
    if($('#inputDiscapacidad').val()=="1"){$("#inputDiscapacidad option[value='1']").attr("selected",true);}
//tipos de discapacidad
    if($('#inputTipoDiscapacidad').val()=="Auditiva"){$("#inputTipoDiscapacidad option[value='Auditiva']").attr("selected",true);}
    if($('#inputTipoDiscapacidad').val()=="Visual"){$("#inputTipoDiscapacidad option[value='Visual']").attr("selected",true);}
    if($('#inputTipoDiscapacidad').val()=="Psicosocial"){$("#inputTipoDiscapacidad option[value='Psicosocial']").attr("selected",true);}
    if($('#inputTipoDiscapacidad').val()=="Cognitiva"){$("#inputTipoDiscapacidad option[value='Cognitiva']").attr("selected",true);}
    if($('#inputTipoDiscapacidad').val()=="Motora"){$("#inputTipoDiscapacidad option[value='Motora']").attr("selected",true);}
    if($('#inputTipoDiscapacidad').val()=="No Aplica"){$("#inputTipoDiscapacidad option[value='No Aplica']").attr("selected",true);}
    if($('#inputTipoDiscapacidad').val()=="No tiene"){$("#inputTipoDiscapacidad option[value='No tiene']").attr("selected",true);}


    $('#inputTrabaja').change(function(){
    if($('#inputTrabaja').val()=="0"){
        $('#inputEmpresa').attr({value: '',readonly: true});  
        $('#inputEmpresaTelefono').attr({value: '',readonly: true}); 
        $('#inputEmpresaDireccion').attr({value: '',readonly: true});  
        $('#inputEmpresaDepartamento').attr({value: '',readonly: true}); 
        $('#inputEmpresaCargo').attr({value: '',readonly: true});
    }else if ($('#inputTrabaja').val()=="1") {
        $('#inputEmpresa').attr({readonly: false});  
        $('#inputEmpresaTelefono').attr({readonly: false}); 
        $('#inputEmpresaDireccion').attr({readonly: false});  
        $('#inputEmpresaDepartamento').attr({readonly: false}); 
        $('#inputEmpresaCargo').attr({readonly: false});
    }
    }); 
    
    $('#inputDiscapacidad').change(function(){
        if($('#inputDiscapacidad').val()=="0"){
            $("#inputTipoDiscapacidad option[value='No tiene']").attr("selected",true);
        }
        if($('#inputDiscapacidad').val()=="1"){
            $("#inputTipoDiscapacidad option[value='No Aplica']").attr("selected",true);
        }
    });    
    
    $('#inputTipoDiscapacidad').change(function(){
        if($('#inputTipoDiscapacidad').val()=="No tiene"){
            $("#inputDiscapacidad option[value='0']").attr("selected",true);
        }
        if($('#inputTipoDiscapacidad').val()!="No tiene"){
            $("#inputDiscapacidad option[value='1']").attr("selected",true);
        }           
    });  
});