$(document).ready(function(){
if($('#estudiante').val()==1){ $('#estudiante').attr({checked: true});} else {$('input.estudiante').attr({disabled: true});}
if($('#activo').val()==1){ $('#activo').attr({checked: true});}
if($('#inactivo').val()==1){ $('#inactivo').attr({checked: true});}
if($('#graduado').val()==1){ $('#graduado').attr({checked: true});}
if($('#profesor').val()==1){ $('#profesor').attr({checked: true});} else {$('input.profesor').attr({disabled: true});}
if($('#evaluador').val()==1){ $('#evaluador').attr({checked: true});}
if($('#jefe_dpto').val()==1){ $('#jefe_dpto').attr({checked: true});}
if($('#jefe_adm').val()==1){ $('#jefe_adm').attr({checked: true});}
if($('#administrativo').val()==1){ $('#administrativo').attr({checked: true});} else {$('input.administrativo').attr({disabled: true});}
if($('#operador').val()==1){ $('#operador').attr({checked: true});}
if($('#taquilla').val()==1){ $('#taquilla').attr({checked: true});}
if($('#control_total').val()==1){ $('#control_total').attr({checked: true});}
});