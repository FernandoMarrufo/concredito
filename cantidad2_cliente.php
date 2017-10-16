<?php require_once('Connections/concredito.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pre_venta (id, descripcion, modelo, cantidad, precio, importe) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['modelo'], "text"),
                       GetSQLValueString($_POST['cantidad'], "int"),
                       GetSQLValueString($_POST['precio'], "double"),
                       GetSQLValueString($_POST['importe'], "double"));

  mysql_select_db($database_concredito, $concredito);
  $Result1 = mysql_query($insertSQL, $concredito) or die(mysql_error());

  $insertGoTo = "registro_ventas_prueba.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_buscador_articulo = 1;
$pageNum_buscador_articulo = 0;
if (isset($_GET['pageNum_buscador_articulo'])) {
  $pageNum_buscador_articulo = $_GET['pageNum_buscador_articulo'];
}
$startRow_buscador_articulo = $pageNum_buscador_articulo * $maxRows_buscador_articulo;

$colname_buscador_articulo = "-1";
if (isset($_GET['id'])) {
  $colname_buscador_articulo = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_concredito, $concredito);
$query_buscador_articulo = sprintf("SELECT * FROM articulos WHERE id_articulo = %s", $colname_buscador_articulo);
$query_limit_buscador_articulo = sprintf("%s LIMIT %d, %d", $query_buscador_articulo, $startRow_buscador_articulo, $maxRows_buscador_articulo);
$buscador_articulo = mysql_query($query_limit_buscador_articulo, $concredito) or die(mysql_error());
$row_buscador_articulo = mysql_fetch_assoc($buscador_articulo);

if (isset($_GET['totalRows_buscador_articulo'])) {
  $totalRows_buscador_articulo = $_GET['totalRows_buscador_articulo'];
} else {
  $all_buscador_articulo = mysql_query($query_buscador_articulo);
  $totalRows_buscador_articulo = mysql_num_rows($all_buscador_articulo);
}
$totalPages_buscador_articulo = ceil($totalRows_buscador_articulo/$maxRows_buscador_articulo)-1;
?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv= "content-type" content="text/html; charset =UTF-8">

<title>Documento sin título</title>
</head>
</meta>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
		   <script  src="js/jquery.js" language="javascript"></script> 
<script type="text/ecmascript">

function valor()
{
var n1 = document.getElementById("cantidad").value;
var n2 = document.getElementById("precio").value;
var n3 = (parseInt(n1)*parseInt(n2))
importe.value = n3;
alert("resultado"+n3)
}
</script>


<body>
<table width="987" height="477" border="0">
</p>
<tr>
  <td bgcolor="#FFFFFF"><form action="" method="post">
    <table width="47%" align="center" border="0" cellspacing="0" cellpadding="0" >
      <tr valign="baseline">
        <td width="211" ><input name="busca" type="text"  placeholder="ingrese articulo.." id="busca">
        <input type="submit" name="submit" value="Buscar" id="boton_busca"></td>
      </tr>
    </table>
 
    <p>
      <?php
$busca="";
$busca=$_POST['busca'];
mysql_connect("localhost","root","1234");
mysql_select_db("concredito");
if($busca!=""){
	$busqueda=mysql_query("SELECT * FROM clientes WHERE clave_cliente  LIKE '".$busca."%'" );
	
		
		echo '<table>	
			<th>
			<th>Resultado de busqueda
			<th>
		 </th> 
		 </th>
		 </tr>';
		while($f=mysql_fetch_array($busqueda)){
		echo"<tr id='t' onClick='location='buscador.php''>";
		echo  "<td>","Descripción","</td>";
		echo  "<td>".$f['clave_cliente']."</td>";
		$id=str_replace(" ","+",$f['id_articulo']);
		  $cadena= "<td><a href=cantidad2_cliente.php?id=".$id.">agregar </a></td>";
		  echo $cadena;				
	echo "</tr>";
		} 
     echo "</table>"; 
		//echo "no se encontraron registros";
} 
	
?>

<table width="987" height="477" border="0">
      <tr>
        <td bgcolor="#FFFFFF"><form action="" method="post">
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
            <table align="center">
              <tr valign="baseline">
                <td width="75" align="right" nowrap>&nbsp;</td>
                <td width="224"><input type="text" style="visibility:hidden" name="id"  disabled value="" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Descripcion:</td>
                <td><?php echo $row_buscador_articulo['descripcion_articulo']; ?>
                  <input type="text" name="descripcion" style="visibility:hidden" value="<?php echo $row_buscador_articulo['descripcion_articulo']; ?>" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Modelo:</td>
                <td><?php echo $row_buscador_articulo['modelo']; ?><input type="text" name="modelo" style="visibility:hidden" value=" <?php echo $row_buscador_articulo['modelo']; ?>" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Cantidad:</td>
                <td><input type="text" name="cantidad" id="cantidad" value="" size="32">
                <input type="button" onClick="valor() " name="r" id="r" value="añadir"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Precio:</td>
                <td><?php echo $row_buscador_articulo['precio']; ?><input type="text" id="precio" name="precio" style="visibility:hidden" value="<?php echo $row_buscador_articulo['precio']; ?>" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Importe:</td>
                <td><input type="text" name="importe" id="importe" value="" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">&nbsp;</td>
                <td><input type="submit" value="Insertar registro"></td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form1">
          </form>
          <table border="1" cellpadding="1"   style="visibility:hidden">
            <tr>
              <td>id_articulo</td>
              <td>descripcion_articulo</td>
              <td>modelo</td>
              <td>precio</td>
              <td>existencia</td>
            </tr>
            <?php do { ?>
            <tr>
              <td><?php echo $row_buscador_articulo['id_articulo']; ?></td>
              <td><?php echo $row_buscador_articulo['descripcion_articulo']; ?></td>
              <td><?php echo $row_buscador_articulo['modelo']; ?></td>
              <td><?php echo $row_buscador_articulo['precio']; ?></td>
              <td><?php echo $row_buscador_articulo['existencia']; ?></td>
            </tr>
            <?php } while ($row_buscador_articulo = mysql_fetch_assoc($buscador_articulo)); ?>
          </table>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($buscador_articulo);
?>