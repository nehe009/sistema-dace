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
        $('#inputEmpresa').attr({value: ''});  
        $('#inputEmpresaTelefono').attr({value: ''}); 
        $('#inputEmpresaDireccion').attr({value: ''});  
        $('#inputEmpresaDepartamento').attr({value: ''}); 
        $('#inputEmpresaCargo').attr({value: ''});  
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
function Discapacidad(){    
    var seleccion = document.getElementById("inputTipoDiscapacidad"); 
    var lista = document.getElementById("inputDiscapacidad");
    var valorSeleccionado = lista.options[lista.selectedIndex].value;
    if(valorSeleccionado=="0"){
        seleccion.selectedIndex=7;
    }else if (valorSeleccionado=="1") {
        seleccion.selectedIndex=6;          
    }
}
function tipoDiscapacidad(){    
    var seleccion =document.getElementById("inputDiscapacidad");
    var lista = document.getElementById("inputTipoDiscapacidad"); 
    var valorSeleccionado = lista.options[lista.selectedIndex].value;
    if(valorSeleccionado=="No tiene"){
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
    //tipo de plantel
    var lista = document.getElementById("inputTipoPlantel");
    var valorSeleccionado = lista.options[lista.selectedIndex].value; 
    if(valorSeleccionado=="PUBLICO"){
        lista.selectedIndex=1;
    }else if (valorSeleccionado=="PRIVADO") {
        lista.selectedIndex=2;         
    }
    //titulo obtenido
    var lista = document.getElementById("inputTitulo");
    var valorSeleccionado = lista.options[lista.selectedIndex].value;       
    if(valorSeleccionado=="CS"){
        lista.selectedIndex=1;
    }else if (valorSeleccionado=="HU") {
        lista.selectedIndex=2;         
    }else if (valorSeleccionado=="CO") {
        lista.selectedIndex=3;         
    }else if (valorSeleccionado=="EI") {
        lista.selectedIndex=4;         
    }else if (valorSeleccionado=="BI") {
        lista.selectedIndex=5;         
    }else if (valorSeleccionado=="EA") {
        lista.selectedIndex=6;         
    }else if (valorSeleccionado=="CB") {
        lista.selectedIndex=7;         
    }else if (valorSeleccionado=="BA") {
        lista.selectedIndex=8;         
    }
    //trabaja??
    var lista = document.getElementById("inputTrabaja");
    var valorSeleccionado = lista.options[lista.selectedIndex].value; 
    if(valorSeleccionado=="0"){
        lista.selectedIndex=1;
        Trabaja();
    }else if (valorSeleccionado=="1") {
        lista.selectedIndex=2;
        Trabaja();
    }
    //discapacidad??
    var lista = document.getElementById("inputDiscapacidad");
    var valorSeleccionado = lista.options[lista.selectedIndex].value; 
    if(valorSeleccionado=="0"){
        lista.selectedIndex=1;
        //Discapacidad();
    }else if (valorSeleccionado=="1") {
        lista.selectedIndex=2;
        //Discapacidad();
    }
    //discapacidades
    var lista = document.getElementById("inputTipoDiscapacidad");
    var valorSeleccionado = lista.options[lista.selectedIndex].value;       
    if(valorSeleccionado=="Motora"){
        lista.selectedIndex=1;
    }else if (valorSeleccionado=="Auditiva") {
        lista.selectedIndex=2;         
    }else if (valorSeleccionado=="Visual") {
        lista.selectedIndex=3;         
    }else if (valorSeleccionado=="Psicosocial") {
        lista.selectedIndex=4;         
    }else if (valorSeleccionado=="Cognitiva") {
        lista.selectedIndex=5;         
    }else if (valorSeleccionado=="No Aplica") {
        lista.selectedIndex=6;         
    }else if (valorSeleccionado=="No tiene") {
        lista.selectedIndex=7;         
    }
    // Afrodescendiente???
    var lista = document.getElementById("inputAfrodescendiente");
    var valorSeleccionado = lista.options[lista.selectedIndex].value; 
    if(valorSeleccionado=="0"){
        lista.selectedIndex=1;
        //Discapacidad();
    }else if (valorSeleccionado=="1") {
        lista.selectedIndex=2;
        //Discapacidad();
    }