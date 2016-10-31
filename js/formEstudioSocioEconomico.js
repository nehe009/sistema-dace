function trabaja(){
    // Obtener el valor de la opción seleccionada
    var lista = document.getElementById("inputTrabaja");
    var valorSeleccionado = lista.options[lista.selectedIndex].value;
    if(valorSeleccionado==0){
        $('#inputEmpresa').attr({value: '',readonly: true});  
        $('#inputEmpresaTelefono').attr({value: '',readonly: true}); 
        $('#inputEmpresaDireccion').attr({value: '',readonly: true});  
        $('#inputEmpresaDepartamento').attr({value: '',readonly: true}); 
        $('#inputEmpresaCargo').attr({value: '',readonly: true});  
        }else if (valorSeleccionado==1) {
        $('#inputEmpresa').attr({readonly: false});  
        $('#inputEmpresaTelefono').attr({readonly: false}); 
        $('#inputEmpresaDireccion').attr({readonly: false});  
        $('#inputEmpresaDepartamento').attr({readonly: false}); 
        $('#inputEmpresaCargo').attr({readonly: false}); 
      }
return;
}function Discapacidad(){    
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
//trabaja??
    var lista1 = document.getElementById("inputTrabaja");
    var valorSeleccionado1 = lista1.options[lista1.selectedIndex].value; 
    if(valorSeleccionado1=="0"){
        lista1.selectedIndex=1;       
        trabaja();
    }else if (valorSeleccionado1=="1") {         
        lista1.selectedIndex=2;
        trabaja();
    }
//discapacidad??
    var lista2 = document.getElementById("inputDiscapacidad");
    var valorSeleccionado2 = lista2.options[lista2.selectedIndex].value; 
    if(valorSeleccionado2=="0"){
        lista2.selectedIndex=1;
        //Discapacidad();
    }else if (valorSeleccionado2=="1") {
        lista2.selectedIndex=2;
        //Discapacidad();
    }
    //discapacidades
    var lista3 = document.getElementById("inputTipoDiscapacidad");
    var valorSeleccionado3 = lista3.options[lista3.selectedIndex].value;       
    if(valorSeleccionado3=="Motora"){
        lista3.selectedIndex=1;
    }else if (valorSeleccionado3=="Auditiva") {
        lista3.selectedIndex=2;         
    }else if (valorSeleccionado3=="Visual") {
        lista3.selectedIndex=3;         
    }else if (valorSeleccionado3=="Psicosocial") {
        lista3.selectedIndex=4;         
    }else if (valorSeleccionado3=="Cognitiva") {
        lista3.selectedIndex=5;         
    }else if (valorSeleccionado3=="No Aplica") {
        lista3.selectedIndex=6;         
    }else if (valorSeleccionado3=="No tiene") {
        lista3.selectedIndex=7;         
    }