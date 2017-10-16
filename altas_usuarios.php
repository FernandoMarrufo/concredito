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
  $insertSQL = sprintf("INSERT INTO clientes (clave_cliente, nombre, apellido_pat, apellido_mat, rfc) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['clave_cliente'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido_pat'], "text"),
                       GetSQLValueString($_POST['apellido_mat'], "text"),
                       GetSQLValueString($_POST['rfc'], "text"));

  mysql_select_db($database_concredito, $concredito);
  $Result1 = mysql_query($insertSQL, $concredito) or die(mysql_error());
}

mysql_select_db($database_concredito, $concredito);
$query_altas = "SELECT * FROM clientes";
$altas = mysql_query($query_altas, $concredito) or die(mysql_error());
$row_altas = mysql_fetch_assoc($altas);
$totalRows_altas = mysql_num_rows($altas);
?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title> La vendimia </title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>


<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Clave:</td>
      <td><input type="text" name="clave_cliente" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nombre:</td>
      <td><span id="sprytextfield1">
      <input type="text" name="nombre" value="" size="32">
      <span class="textfieldRequiredMsg">“No es posible continuar, debe ingresar Nombre es obligatorio".</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Apellido Paterno:</td>
      <td><span id="sprytextfield2">
        <input type="text" name="apellido_pat" value="" size="32">
      <span class="textfieldRequiredMsg">“No es posible continuar, debe ingresar Apellido Paterno es obligatorio".</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Apellido Materno:</td>
      <td><span id="sprytextfield3">
        <input type="text" name="apellido_mat" value="" size="32">
      <span class="textfieldRequiredMsg">“No es posible continuar, debe ingresar Apellido Materno es obligatorio".</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">RFC:</td>
      <td><span id="sprytextfield4">
        <input type="text" name="rfc" value="" size="20">
      <span class="textfieldRequiredMsg">“No es posible continuar, debe ingresar RFC es obligatorio".</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "custom", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
</script>
</body>
</html>
<?php
mysql_free_result($altas);
?>
