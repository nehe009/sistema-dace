$(document).ready(function(){
//$('#inputAnoGrado').datepicker({format: "yyyy",startView: 2,minViewMode: 2,maxViewMode: 2,autoclose: true,language: 'es'});
//$('#fecha_nacimiento_familiar').datepicker({pickTime: false,format: "yyyy-mm-dd",startView: 2,autoclose: true,language: 'es'});
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
    //agregar campos de grupo familiar
    $('#inputGrupoFamiliar').blur(function(){
        var grupoFamiliar = $('#inputGrupoFamiliar').val();
        grupoFamiliar++;
        for(var i=1; i < grupoFamiliar; i++) {
            //alert("mensaje"+i);
            $("#campos_grupo_familiar").append('<div class="col-md-4 grupo_familiar'+i+'"><h4 class="">Familiar #'+i+'</h4><label for="cedula_familiar" class="">Cedula de identidad</label><input id="cedula_familiar" class="form-control" placeholder="Cedula de identidad" type="text" name="cedula_familiar[]" pattern="[0-9]{7,8}"><label for="nombres_apellidos_familiar" class="">Nombres y Apellidos</label><input id="nombres_apellidos_familiar" class="form-control" placeholder="Nombres y Apellidos" type="text" name="nombres_apellidos_familiar[]" pattern="[A-Z a-záÁéÉíÍóÓúÚñÑ]{1,32}" required><label for="parentesco_familiar" class="">Parentesco familiar</label><select id="parentesco_familiar" name="parentesco_familiar[]" class="form-control" required><option value=""></option><option value="Padre">Padre</option><option value="Madre">Madre</option><option value="Hermano(a)">Hermano(a)</option><option value="">Hijo(a)</option></select><label for="fecha_nacimiento_familiar" class="">Fecha de nacimiento</label><input id="fecha_nacimiento_familiar" value="" class="form-control" placeholder="Fecha de nacimiento" type="text" name="fecha_nacimiento_familiar[]" required><label for="sexo_familiar" class="">Sexo</label><select id="sexo_familiar" name="sexo_familiar[]" class="form-control" required><option value=""></option><option value="Masculino">Masculino</option><option value="Femenino">Femenino</option></select><label for="estudios_familiar" class="">Grado académico</label><select id="estudios_familiar" name="estudios_familiar[]" class="form-control" required><option value=""></option><option value="Ninguno">Ninguno</option><option value="Primaria">Primaria</option><option value="Secundaria">Secundaria</option><option value="Bachiller">Bachiller</option><option value="Técnico medio">Técnico medio</option><option value="Técnico superior universitario">Técnico superior universitario</option><option value="Ingeniero">Ingeniero</option></select><label for="ocupacion_familiar" class="">Ocupación u oficio</label><input id="ocupacion_familiar" class="form-control" placeholder="Ocupación u oficio" type="text" name="ocupacion_familiar[]" pattern="[A-Z a-záÁéÉíÍóÓúÚñÑ]{1,32}" required></div>');
        }        
    });
    //eliminar campos de grupo familiar
    $('#inputGrupoFamiliar').focus(function(){
        var grupoFamiliar = $('#inputGrupoFamiliar').val();
        grupoFamiliar++;
        for(var i=1; i < grupoFamiliar; i++) {
            //alert("mensaje"+i);
            $("div.grupo_familiar"+i).remove();
        }       
    });


grupo_familiar=0;
function agregar() {
	grupo_familiar=grupo_familiar+1;
        
	$("#campos_grupo_familiar").append('<div class="grupo_familiar'+grupo_familiar+'"><input placeholder="Cedula" type="text" name="cedula_familiar[]" size="10" />&nbsp;&nbsp;&nbsp;<input placeholder="Nombres y Apellidos" type="text" name="nombres_apellidos_familiar[]" size="20" />&nbsp;&nbsp;&nbsp;<input placeholder="Parentesco" type="text" name="parentesco_familiar[]" size="8" />&nbsp;&nbsp;&nbsp;<input placeholder="F. Nacimiento" type="date" name="fecha_nacimiento_familiar[]" size="12" />&nbsp;&nbsp;&nbsp;<select name="sexo_familiar[]" size="1"><option>Masculino</option><option>Femenino</option></select>&nbsp;&nbsp;&nbsp;<input placeholder="Estudios" type="text" name="estudios_familiar[]" size="10" />&nbsp;&nbsp;&nbsp;<input placeholder="Ocupacion" type="text" name="ocupacion_familiar[]" size="10" />&nbsp;&nbsp;&nbsp;<a href="#" onclick="javascript:borrar('+grupo_familiar+');">-</a></div>');
	}
function borrar(cual) {
	$("li.grupo_familiar"+cual).remove();
	return false;
}



});