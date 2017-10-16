<?php require_once('Connections/concredito.php'); ?>
<?php
$maxRows_articulos = 10;
$pageNum_articulos = 0;
if (isset($_GET['pageNum_articulos'])) {
  $pageNum_articulos = $_GET['pageNum_articulos'];
}
$startRow_articulos = $pageNum_articulos * $maxRows_articulos;

mysql_select_db($database_concredito, $concredito);
$query_articulos = "SELECT * FROM articulos";
$query_limit_articulos = sprintf("%s LIMIT %d, %d", $query_articulos, $startRow_articulos, $maxRows_articulos);
$articulos = mysql_query($query_limit_articulos, $concredito) or die(mysql_error());
$row_articulos = mysql_fetch_assoc($articulos);

if (isset($_GET['totalRows_articulos'])) {
  $totalRows_articulos = $_GET['totalRows_articulos'];
} else {
  $all_articulos = mysql_query($query_articulos);
  $totalRows_articulos = mysql_num_rows($all_articulos);
}
$totalPages_articulos = ceil($totalRows_articulos/$maxRows_articulos)-1;
?><!DOCTYPE HTML>
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
          <p>
            <?php
$busca="";
$busca=$_POST['busca'];
mysql_connect("localhost","root","1234");
mysql_select_db("concredito");
if($busca!=""){
	$busqueda=mysql_query("SELECT * FROM cliente WHERE apellido_pat  LIKE '".$busca."%'or apellido_mat  LIKE '".$busca."%'or nombre  LIKE '".$busca."%'" );
	
		
		echo '</div> <table  class="hovertable">	
			
			
			<th>Id
			<th>Nombre
			<th>Apellido Paterno
			<th>Apellido Materno
			
			
		 </th>
		 
		 </tr>';
		while($f=mysql_fetch_array($busqueda)){
		echo"<tr id='t' onClick='location='registro_ventas''>";
		
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
</p>
          <p>&nbsp;          </p>
        
                    <table border="1">
            <tr>
              <td>descripcion_articulo</td>
              <td>modelo</td>
              <td>cantidad</td>
              <td>precio</td>
              <td>importe</td>
            </tr>
            <?php do { ?>
              <tr>
                <td><?php echo $row_articulos['descripcion_articulo']; ?></td>
                <td><?php echo $row_articulos['modelo']; ?></td>
                <td><form name="form1" method="post" action="">
                  <label>
                    <input type="text" name="textfield">
                  </label>
                </form>
                </td>
                <td><?php echo $row_articulos['precio']; ?></td>
                <td><?php echo $row_articulos['importe']; ?></td>
              </tr>
              <?php } while ($row_articulos = mysql_fetch_assoc($articulos)); ?>
          </table>
</body>
</html>
<?php
mysql_free_result($articulos);
?>