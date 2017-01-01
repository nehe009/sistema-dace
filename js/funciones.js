 //funcion para avisar de usuario online constantemente
  function setUserOnline() {
      var cedulausuario = $('#cedulausuario').html();
      if(cedulausuario){
          $.ajax({type:'POST',url:'ajaxData.php',data:'useronline='+cedulausuario}); 
        }    
  }  
  //setInterval(setUserOnline,60000);