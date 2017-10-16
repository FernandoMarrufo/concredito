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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE clientes SET nombre=%s, apellido_pat=%s, apellido_mat=%s, rfc=%s WHERE clave_cliente=%s",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido_pat'], "text"),
                       GetSQLValueString($_POST['apellido_mat'], "text"),
                       GetSQLValueString($_POST['rfc'], "text"),
                       GetSQLValueString($_POST['clave_cliente'], "text"));

  mysql_select_db($database_concredito, $concredito);
  $Result1 = mysql_query($updateSQL, $concredito) or die(mysql_error());

  $updateGoTo = "clientes.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_clientes = "-1";
if (isset($_GET['clave_cliente'])) {
  $colname_clientes = (get_magic_quotes_gpc()) ? $_GET['clave_cliente'] : addslashes($_GET['clave_cliente']);
}
mysql_select_db($database_concredito, $concredito);
$query_clientes = sprintf("SELECT * FROM clientes WHERE clave_cliente = '%s'", $colname_clientes);
$clientes = mysql_query($query_clientes, $concredito) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);
$totalRows_clientes = mysql_num_rows($clientes);
?><!DOCTYPE html>
<html >
<head>
<head>
  <meta charset="UTF-8">
  <title>La Vendimia</title>
  <script src="https://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>

<link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' rel='stylesheet'/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link href="css/style.css" rel="stylesheet" type="text/css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>


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
    <p>&nbsp;</p><p>&nbsp;</p>
<div align="right"><a href="alta_clientes.php"><img src="images/boton_cliente.png" width="130" height="46" border="0"></a></div>
<p align="center">&nbsp;</p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <div align="center">
  <div class="datagrid">
    <table align="center">
      <tr valign="baseline">
      <thead>
      <tr>
        <th height="33" colspan="2">Modificar Clientes</th>
      </tr>
    </thead>
        <td nowrap align="right">Clave Cliente:</td>
        <td><?php echo $row_clientes['clave_cliente']; ?></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Nombre:</td>
        <td><input type="text" name="nombre" value="<?php echo $row_clientes['nombre']; ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Apellido Paterno:</td>
        <td><input type="text" name="apellido_pat" value="<?php echo $row_clientes['apellido_pat']; ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Apellido Materno:</td>
        <td><input type="text" name="apellido_mat" value="<?php echo $row_clientes['apellido_mat']; ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">RFC:</td>
        <td><input type="text" name="rfc" value="<?php echo $row_clientes['rfc']; ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">&nbsp;</td>
        <td><input type="submit" class="btn success" value="Actualizar registro"></td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form1">
    <input type="hidden" name="clave_cliente" value="<?php echo $row_clientes['clave_cliente']; ?>">
  </div>
  </div>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($clientes);
?>
