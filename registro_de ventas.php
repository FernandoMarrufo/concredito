<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Registro de ventas</title>
</head>

<body>
<table width="987" height="477" border="0">
      <tr>
        <td bgcolor="#FFFFFF"><form action="" method="post">
          <table width="100%" align="center" border="0" cellspacing="5" cellpadding="0" >
            <tr valign="baseline">
              <td width="69" ><input type="submit" name="submit" value="Buscar" id="boton_busca"></td>
              <td width="918" ><input name="busca" type="text"  placeholder="Ingresa Apellido Paterno" id="busca"></td>
            </tr>
            </table>
          <?php
$busca="";
$busca=$_POST['busca'];
mysql_connect("localhost","root","1234");
mysql_select_db("concredito");
if($busca!=""){
	$busqueda=mysql_query("SELECT * FROM clientes WHERE apellido_pat  LIKE '".$busca."%'or apellido_mat  LIKE '".$busca."%'or nombre  LIKE '".$busca."%'" );
	
		
		echo '<table>	
			
	 <tr>
			<th>Id
			<th>Nombre
			<th>Apellido Paterno
			<th>Apellido Materno
			
			
		 </th>
		 
		 </tr>';
		while($f=mysql_fetch_array($busqueda)){
		echo"<tr id='t' onClick='location='registro_ventas.php''>";
		
		echo"<td>". $f['id']."</td>";
		echo  "<td>".$f['nombre']."</td>";
		echo  "<td>".$f['apellido_pat']."</td>";
		echo  "<td>".$f['apellido_mat']."</td>";
		
	    
		  
		$id=str_replace(" ","+",$f['id']);
		  $cadena= "<td><a href=diplomas.php?id=".$id.">estatus </a></td>";
		  echo $cadena;				
	echo "</tr>";
		} 
			
     echo "</table>"; 
		echo "no se encontraron registros";
	 
} 
	
	


?>
</body>
</html>