<!DOCTYPE html>  
 <html>  
      <head>  
           <title>Webslesson Tutorial | Autocomplete textbox using jQuery, PHP and MySQL</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
		   <script  src="js/jquery.js" language="javascript"></script> 
           <script>
$(document).ready(function(){
     $("#mo").click(function(){
        $("#div").show("slow");
     });

     $("#ocu").click(function(){
        $("#div").hide("slow");
     });
});
//mostrar ocultar
$(function(){
  init(ocultar);
});
function init()
  {
   var x = $('.btn');
   x.click(ocultar);

   var z = $('.btn2');
   z.click(mostrar);
   }
function ocultar()
   {
    var x = $('.picture');
    x.hide("slow");
    }

     function mostrar()
   {
    var z = $('.picture');
    z.show("slow");
    }



					</script>
		   <style>  
           ul{  
                background-color:#eee;  
                cursor:pointer;  
           }  
           li{  
                padding:12px;  
           }  
           </style>  
		   
      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:500px;">  
                <h3 align="center"><br />
                  <input name="clientes" type="text" class="form-control" id="clientes" placeholder="Buscar cliente" size="12" />  
                </h3>
                <div id="clientesList">
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                </div>  
           </div>  
		      
				  <button  class="btn2">  mostrar </button>
                 <button  class="btn">  ocultar </button>
	 <div class="picture" >
	              <table width="200" border="1">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
				  <button  class="btn">  ocultar </button>
				  <button  class="btn2">  mostrar </button>
				  
      </div>
<p>
        <label></label>
        <label></label>
      </p>
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
      $('#clientes').keyup(function(){  
           var query = $(this).val();  
           if(query != '')  
           {  
                $.ajax({  
                     url:"search.php",  
                     method:"POST",  
                     data:{query:query},  
                     success:function(data)  
                     {  
                          $('#clientesList').fadeIn();  
                          $('#clientesList').html(data);  
                     }  
                });  
           }  
      });  
      $(document).on('click', 'li', function(){  
           $('#clientes').val($(this).text());  
           $('#clientesList').fadeOut();  
      });  
 });  
 </script>  