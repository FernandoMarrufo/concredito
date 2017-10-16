
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
?>
<!DOCTYPE html>
<html >
<meta charset="UTF-8">
<head>
 <title>La Vendimia</title>
  <script src="https://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>

<link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' rel='stylesheet'/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link href="css/style.css" rel="stylesheet" type="text/css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
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
<style type="text/css">
body,td,th {
	color: #5B9BD5;
}
</style>
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
    <p>&nbsp;</p><p>&nbsp;</p>
<p>&nbsp;</p>


<div align="right"><a href="alta_articulos.php"><img src="images/boton_articulo.png" width="130" height="46" border="0"></a></div>
<p align="center">&nbsp;</p>
<h2 align="center"><strong>Articulos  Registrados</strong></h2>
<div align="center">
  <p>&nbsp;</p>
       <div class="datagrid">
<div align="center">
  <table width="554" border="0" cellpadding="1" cellspacing="0">
    <tr>
      <td width="177" bgcolor="#999999">Clave Articulo</td>
      <td colspan="2" bgcolor="#999999">Descripción</td>
    </tr>
    <?php do { ?>
      <tr bgcolor="#CCCCCC">
        <td><?php echo $row_articulos['id_articulo']; ?></td>
        <td width="335"><?php echo $row_articulos['descripcion_articulo']; ?></td>
        <td width="36"><a href="modificar_articulos.php?id=<?php echo $row_articulos['id_articulo']; ?>"><img src="images/modificar.png" width="36" height="36" border="0"></a></td>
      </tr>
      <?php } while ($row_articulos = mysql_fetch_assoc($articulos)); ?>
  </table>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($articulos);
?>