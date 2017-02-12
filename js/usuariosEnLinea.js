  //obtener usuarios en linea
  function getUserOnline() {
      $.ajax({
          type:'POST',
          url:'ajaxData.php',
          data:'getuseronline=1',
          success:function(html){
              $('#usuarios').html(html);
              var conectados = html.indexOf('=conectados=');
              conectados=html.substring(conectados+12);
              $('#usuarios_online').html(conectados)
              }
      });  
  }  
setInterval(getUserOnline,10000);
