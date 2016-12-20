$(document).ready(function(){
    //Calendario de bootstrap-datepicker
    $('#inputFechaNacimiento').datepicker({pickTime: false,format: "yyyy-mm-dd",startView: 2,autoclose: true,language: 'es'});
    //evento para cargar pais de nacimiento
    $('#inputPaisNacimiento').focus(function(){ 
        $.ajax({
            type:'POST',
            url:'ajaxData.php',
            data:'obtenerPais=1',
            success:function(html){
                $('#inputPaisNacimiento').html(html);
                }
        }); }); 
    //evento para comprobar si el pais seleccionado es venezuela.
    $('#inputPaisNacimiento').change(function(){
        if($('#inputPaisNacimiento').val()=="240"){
            $('#inputEstadoNacimiento').attr({disabled:false});
            $('#inputCiudadNacimiento').attr({disabled:false});  
            $("#inputNacionalidad option[value='V']").attr({selected:true});
        } else {
            $('#inputEstadoNacimiento').attr({disabled:true});
            $('#inputCiudadNacimiento').attr({disabled:true});  
            $("#inputNacionalidad option[value='E']").attr("selected",true);
        }  
    });
    //Evento para cargar estado de nacimiento
    $('#inputEstadoNacimiento').focus(function(){ 
        $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'obtenerEstado=1',
                success:function(html){
                    $('#inputEstadoNacimiento').html(html);
                    }
            });        
    });
        
    //evento para cargar ciudad de nacimiento
    $('#inputCiudadNacimiento').focus(function(){ 
        var estadoSeleccionado = $('#inputEstadoNacimiento').val();
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'obtenerCiudad='+estadoSeleccionado,
                success:function(html){
                    $('#inputCiudadNacimiento').html(html);
                    }
            });             
    });

    //Evento para cargar estado de habitacion
    $('#inputEstadoHabitacion').focus(function(){ 
        $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'obtenerEstado=1',
                success:function(html){
                    $('#inputEstadoHabitacion').html(html);
                    }
            });        
    });
 
     //evento para cargar ciudad de habitacion
    $('#inputCiudadHabitacion').focus(function(){ 
        var estadoSeleccionado = $('#inputEstadoHabitacion').val();
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'obtenerCiudad='+estadoSeleccionado,
                success:function(html){
                    $('#inputCiudadHabitacion').html(html);
                    }
            });             
    });
 
    //evento para cargar municipio de habitacion
    $('#inputMunicipioHabitacion').focus(function(){ 
        var estadoSeleccionado = $('#inputEstadoHabitacion').val();
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'obtenerMunicipio='+estadoSeleccionado,
                success:function(html){
                    $('#inputMunicipioHabitacion').html(html);
                    }
            });             
    });
    
    //evento para cargar parroquia de habitacion
    $('#inputParroquiaHabitacion').focus(function(){ 
        var municipioSeleccionado = $('#inputMunicipioHabitacion').val();
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'obtenerParroquia='+municipioSeleccionado,
                success:function(html){
                    $('#inputParroquiaHabitacion').html(html);
                    }
            });             
    });

//asigna valores a los select, con los datos leidos de la base de datos.
    //nacionalidad
    if($('#inputNacionalidad').val()=="V"){$("#inputNacionalidad option[value='V']").attr("selected",true);}
    if($('#inputNacionalidad').val()=="E"){$("#inputNacionalidad option[value='E']").attr("selected",true);} 
    //sexo
    if($('#inputSexo').val()=="M"){$("#inputSexo option[value='M']").attr("selected",true);}
    if($('#inputSexo').val()=="F"){$("#inputSexo option[value='F']").attr("selected",true);}
    //estado civil
    if($('#inputEstadoCivil').val()=="S"){$("#inputEstadoCivil option[value='S']").attr("selected",true);}
    if($('#inputEstadoCivil').val()=="C"){$("#inputEstadoCivil option[value='C']").attr("selected",true);} 
    if($('#inputEstadoCivil').val()=="D"){$("#inputEstadoCivil option[value='D']").attr("selected",true);}
    if($('#inputEstadoCivil').val()=="V"){$("#inputEstadoCivil option[value='V']").attr("selected",true);} 
    //Afrodescendiente
    if($('#inputAfrodescendiente').val()=="0"){$("#inputAfrodescendiente option[value='0']").attr("selected",true);}
    if($('#inputAfrodescendiente').val()=="1"){$("#inputAfrodescendiente option[value='1']").attr("selected",true);}
    
});