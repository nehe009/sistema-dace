//Calendario de bootstrap-datepicker
$(document).ready(function() {
    $('#inputFechaNacimiento').datepicker({pickTime: false,format: "yyyy-mm-dd",startView: 2,autoclose: true,language: 'es'});
    $('#inputAnoGrado').datepicker({format: "yyyy",startView: 2,minViewMode: 2,maxViewMode: 2,autoclose: true,language: 'es'});    
});
//Submmenus
$(document).ready(function(){
  $('.dropdown-submenu a.submenu').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
});