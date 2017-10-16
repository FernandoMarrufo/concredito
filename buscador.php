<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>La Vendimia</title>
  <script src="https://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>

<link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' rel='stylesheet'/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link href="css/style.css" rel="stylesheet" type="text/css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
<link rel="stylesheet" href="css/forms.css">
</head>

<body>
&nbsp;
</p>
<img src="images/logo.png" width="187" height="58" align="right">
<p>&nbsp;</p>
<p>&nbsp;</p>
<nav>

  <a id="resp-menu" class="responsive-menu" href="index.html"><i class="fa fa-reorder"></i> Home</a>    
  <ul class="menu">
   <li><a class="homer" href="index.html"> <strong>Inicio</strong></a>
   <ul class="sub-menu">
   <li><a href="ventas.php">ventas</a></li>
   <li><a href="clientes.php">clientes</a></li>
   <li><a href="articulos.php">articulos</a></li>
   <li><a href="configuracion.php">configuracion</a></li>
    
  

   </ul>
   </li>
  </ul>
</nav>

<span class="topright">fecha:
<?php 

echo date("d/m/Y ");
?>
</span>
   

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<link rel="stylesheet" href="css/forms.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script  src="js/index.js"></script>
    <p>&nbsp;</p><div align="right">
      <p>&nbsp;</p>
      <
    </div>
   
 <table width="987" height="477" border="0">
</p>
<tr>
  <td bgcolor="#FFFFFF"><form action="" method="post">
  <div class="datagrid" align="center">
  
    <table width="900" border="1">
     <thead>
      <tr>
        <th height="33" colspan="2">Agregar cliente</th>
      </tr>
    </thead>
      <tr>
        <td>Agregar cliente</td>
      </tr>
      <tr>
        <td height="64"><table width="47%" align="center" border="0" cellspacing="0" cellpadding="0" >
            <tr valign="baseline">
              <td width="211" height="24" ><input name="busca" type="text"  placeholder="ingrese nombre.." id="busca">
                <input type="submit" class="btn success" name="submit" value="Buscar" id="boton_busca"></td>
            </tr>
        </table>
          <div align="center">
            <?php
$busca="";
$busca=$_POST['busca'];
mysql_connect("localhost","root","1234");
mysql_select_db("concredito");
if($busca!=""){
	$busqueda=mysql_query("SELECT * FROM clientes WHERE apellido_pat  LIKE '".$busca."%'or apellido_mat  LIKE '".$busca."%'or nombre  LIKE '".$busca."%'" );
	
		
		echo '<table>	
			<th>
			<th>Resultado de busqueda
			<th>
		 </th> 
		 </th>
		 </tr>';
		while($f=mysql_fetch_array($busqueda)){
		echo"<tr id='t' onClick='location='buscador.php''>";
		echo  "<td>".$f['clave_cliente']."-","</td>";
		echo  "<td>".$f['nombre']." ".$f['apellido_pat']." ".$f['apellido_mat']."</td>";
		$id=str_replace(" ","+",$f['clave_cliente']);
		  $cadena= "<td><a href=alta_ventas.php?clave_cliente=".$id.">agregar</td>";
		  echo $cadena;				
	echo "</tr>";
		} 
     echo "</table>"; 
		//echo "no se encontraron registros";
} 
	
?>
        </div>
         </div></td>
      </tr>
    </table>