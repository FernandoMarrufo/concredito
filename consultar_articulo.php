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
<title>Documento sin título</title>
</head>

<body>
<div align="right"><a href="alta_articulos.php"><img src="images/boton_venta.png" width="130" height="46" border="0"></a></div>
<p>Articulos Registrados </p>
<div align="center">

  <table width="554" border="0" cellpadding="1" cellspacing="0">
    <tr>
      <td width="177">Clave Articulo</td>
      <td colspan="2">Descripción</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_articulos['id_articulo']; ?></td>
        <td width="335"><?php echo $row_articulos['descripcion_articulo']; ?></td>
        <td width="36"><a href="modificar_articulos.php?id=<?php echo $row_articulos['id_articulo']; ?>"><img src="images/modificar.png" width="36" height="36" border="0"></a></td>
      </tr>
      <?php } while ($row_articulos = mysql_fetch_assoc($articulos)); ?>
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($articulos);
?>