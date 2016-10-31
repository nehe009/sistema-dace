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
    // Afrodescendiente???
    var lista = document.getElementById("inputAfrodescendiente");
    var valorSeleccionado = lista.options[lista.selectedIndex].value; 
    if(valorSeleccionado=="0"){
        lista.selectedIndex=1;
    }else if (valorSeleccionado=="1") {
        lista.selectedIndex=2;
    }