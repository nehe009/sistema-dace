  //Calendario de bootstrap-datepicker
  $(document).ready(function() {
    $('#inputFechaNacimiento').datepicker({pickTime: false,format: "yyyy-mm-dd",startView: 2,autoclose: true,language: 'es'});
    $('#inputAnoGrado').datepicker({format: "yyyy",startView: 2,minViewMode: 2,maxViewMode: 2,autoclose: true,language: 'es'});    
  });
function Trabaja(){
    // Obtener el valor de la opción seleccionada
    var lista = document.getElementById("inputTrabaja");
    var valorSeleccionado = lista.options[lista.selectedIndex].value;
    if(valorSeleccionado==0){
        $('#inputEmpresa').attr({disabled: true});  
        $('#inputEmpresaTelefono').attr({disabled: true}); 
        $('#inputEmpresaDireccion').attr({disabled: true});  
        $('#inputEmpresaDepartamento').attr({disabled: true}); 
        $('#inputEmpresaCargo').attr({disabled: true});  
        }else if (valorSeleccionado==1) {
        $('#inputEmpresa').attr({disabled: false});  
        $('#inputEmpresaTelefono').attr({disabled: false}); 
        $('#inputEmpresaDireccion').attr({disabled: false});  
        $('#inputEmpresaDepartamento').attr({disabled: false}); 
        $('#inputEmpresaCargo').attr({disabled: false}); 
      }
}     
function Nacionalidad(){
     // Obtener el valor de la opción seleccionada
    var lista = document.getElementById("inputNacionalidad");
    var valorSeleccionado = lista.options[lista.selectedIndex].value;
    if(valorSeleccionado=="V"){
        $('#inputPaisNacimiento').attr({readonly: true, value: 'Venezuela'});   
    }else if (valorSeleccionado=="E") {
        $('#inputPaisNacimiento').attr({readonly: false, value: ''});         
    } 
}
function PaisNacimiento(){    
    var seleccion = document.getElementById("inputNacionalidad");  
    var valor = document.getElementById("inputPaisNacimiento").value;
    if(valor=="Venezuela"){
        seleccion.selectedIndex=1;
    }else {
        seleccion.selectedIndex=2;         
    } 
}
//asigna valores a los select, con los datos leidos de la base de datos.
    //sexo
    var lista = document.getElementById("inputSexo");
    var valorSeleccionado = lista.options[lista.selectedIndex].value;       
    if(valorSeleccionado=="M"){
        lista.selectedIndex=1;
    }else if (valorSeleccionado=="F") {
        lista.selectedIndex=2;         
    } 
    //nacionalidad
    var lista = document.getElementById("inputNacionalidad");
    var valorSeleccionado = lista.options[lista.selectedIndex].value;       
    if(valorSeleccionado=="V"){
        lista.selectedIndex=1;
    }else if (valorSeleccionado=="E") {
        lista.selectedIndex=2;         
    }
    //estado civil
    var lista = document.getElementById("inputEstadoCivil");
    var valorSeleccionado = lista.options[lista.selectedIndex].value;       
    if(valorSeleccionado=="S"){
        lista.selectedIndex=1;
    }else if (valorSeleccionado=="C") {
        lista.selectedIndex=2;         
    }else if (valorSeleccionado=="D") {
        lista.selectedIndex=3;         
    }else if (valorSeleccionado=="V") {
        lista.selectedIndex=4;         
    }  