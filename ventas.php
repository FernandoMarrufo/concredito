
<?php require_once('Connections/concredito.php'); ?>
<?php
$maxRows_ventas = 10;
$pageNum_ventas = 0;
if (isset($_GET['pageNum_ventas'])) {
  $pageNum_ventas = $_GET['pageNum_ventas'];
}
$startRow_ventas = $pageNum_ventas * $maxRows_ventas;

mysql_select_db($database_concredito, $concredito);
$query_ventas = "SELECT * FROM ventas_activas";
$query_limit_ventas = sprintf("%s LIMIT %d, %d", $query_ventas, $startRow_ventas, $maxRows_ventas);
$ventas = mysql_query($query_limit_ventas, $concredito) or die(mysql_error());
$row_ventas = mysql_fetch_assoc($ventas);

if (isset($_GET['totalRows_ventas'])) {
  $totalRows_ventas = $_GET['totalRows_ventas'];
} else {
  $all_ventas = mysql_query($query_ventas);
  $totalRows_ventas = mysql_num_rows($all_ventas);
}
$totalPages_ventas = ceil($totalRows_ventas/$maxRows_ventas)-1;
?>
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
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<link rel="stylesheet" href="css/forms.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script  src="js/index.js"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script  src="js/index.js"></script>
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

<script  src="js/index.js"></script>
    <p>&nbsp;</p>
<div align="right"><a href="alta_ventas.php"><img src="images/boton_venta.png" width="130" height="46" border="0"></a></div>
<p align="center">Ventas Activas  </p>


<div align="center">
    <p>&nbsp;</p>
<div class="datagrid">
  <table border="1" cellpadding="1">
   <thead>
      <tr>
        <th height="33" colspan="6">ventas Activas</th>
      </tr>
    </thead>
    <tr>
      <td>Folio Venta</td>
      <td>Clave Cliente</td>
      <td>Nombre</td>
      <td>Total</td>
      <td>Fecha</td>
      <td>Estatus</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_ventas['folio_venta']; ?></td>
        <td><?php echo $row_ventas['clave_cliente']; ?></td>
        <td><?php echo $row_ventas['nombre']; ?></td>
        <td><?php echo $row_ventas['total']; ?></td>
        <td><?php echo $row_ventas['fecha']; ?></td>
        <td><?php echo $row_ventas['estatus']; ?></td>
      </tr>
      <?php } while ($row_ventas = mysql_fetch_assoc($ventas)); ?>
  </table>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($ventas);
?>
