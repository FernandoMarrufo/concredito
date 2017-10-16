<?php require_once('Connections/concredito.php'); ?>
<?php
$maxRows_clientes = 1;
$pageNum_clientes = 0;
if (isset($_GET['pageNum_clientes'])) {
  $pageNum_clientes = $_GET['pageNum_clientes'];
}
$startRow_clientes = $pageNum_clientes * $maxRows_clientes;

$colname_clientes = "-1";
if (isset($_GET['clave_cliente'])) {
  $colname_clientes = (get_magic_quotes_gpc()) ? $_GET['clave_cliente'] : addslashes($_GET['clave_cliente']);
}
mysql_select_db($database_concredito, $concredito);
$query_clientes = sprintf("SELECT * FROM clientes WHERE clave_cliente = %s", $colname_clientes);
$query_limit_clientes = sprintf("%s LIMIT %d, %d", $query_clientes, $startRow_clientes, $maxRows_clientes);
$clientes = mysql_query($query_limit_clientes, $concredito) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);

if (isset($_GET['totalRows_clientes'])) {
  $totalRows_clientes = $_GET['totalRows_clientes'];
} else {
  $all_clientes = mysql_query($query_clientes);
  $totalRows_clientes = mysql_num_rows($all_clientes);
}
$totalPages_clientes = ceil($totalRows_clientes/$maxRows_clientes)-1;

$maxRows_preventa = 1;
$pageNum_preventa = 0;
if (isset($_GET['pageNum_preventa'])) {
  $pageNum_preventa = $_GET['pageNum_preventa'];
}
$startRow_preventa = $pageNum_preventa * $maxRows_preventa;

$colname_preventa = "-1";
if (isset($_GET['id'])) {
  $colname_preventa = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_concredito, $concredito);
$query_preventa = sprintf("SELECT * FROM pre_venta WHERE id = %s", $colname_preventa);
$query_limit_preventa = sprintf("%s LIMIT %d, %d", $query_preventa, $startRow_preventa, $maxRows_preventa);
$preventa = mysql_query($query_limit_preventa, $concredito) or die(mysql_error());
$row_preventa = mysql_fetch_assoc($preventa);

if (isset($_GET['totalRows_preventa'])) {
  $totalRows_preventa = $_GET['totalRows_preventa'];
} else {
  $all_preventa = mysql_query($query_preventa);
  $totalRows_preventa = mysql_num_rows($all_preventa);
}
$totalPages_preventa = ceil($totalRows_preventa/$maxRows_preventa)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>
<script type="text/ecmascript">

function valor()
{
var n1 = document.getElementById("a").value;
var n2 = document.getElementById("b").value;
var n3 = (parseInt(n1)+parseInt(n2))
c.value = n3;
alert("resultado"+n3)
}
</script>
<body>
<table border="1" cellpadding="1">
  <tr>
    <td>clave_cliente</td>
    <td>nombre</td>
    <td>apellido_pat</td>
    <td>apellido_mat</td>
    <td>rfc</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_clientes['clave_cliente']; ?></td>
      <td><?php echo $row_clientes['nombre']; ?></td>
      <td><?php echo $row_clientes['apellido_pat']; ?></td>
      <td><?php echo $row_clientes['apellido_mat']; ?></td>
      <td><?php echo $row_clientes['rfc']; ?></td>
    </tr>
    <?php } while ($row_clientes = mysql_fetch_assoc($clientes)); ?>
</table>
<p>&nbsp;</p>

<table border="1" cellpadding="1">
  <tr>
    <td>id</td>
    <td>descripcion</td>
    <td>modelo</td>
    <td>cantidad</td>
    <td>precio</td>
    <td>importe</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_preventa['id']; ?></td>
      <td><?php echo $row_preventa['descripcion']; ?></td>
      <td><?php echo $row_preventa['modelo']; ?></td>
      <td><?php echo $row_preventa['cantidad']; ?></td>
      <td><?php echo $row_preventa['precio']; ?></td>
      <td><?php echo $row_preventa['importe']; ?></td>
    </tr>
    <?php } while ($row_preventa = mysql_fetch_assoc($preventa)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($clientes);

mysql_free_result($preventa);
?>
