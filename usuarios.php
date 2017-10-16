<?php require_once('Connections/concredito.php'); ?>
<?php
$maxRows_clientes = 10;
$pageNum_clientes = 0;
if (isset($_GET['pageNum_clientes'])) {
  $pageNum_clientes = $_GET['pageNum_clientes'];
}
$startRow_clientes = $pageNum_clientes * $maxRows_clientes;

mysql_select_db($database_concredito, $concredito);
$query_clientes = "SELECT * FROM clientes";
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
?><!DOCTYPE html>
<html >
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
   <li><a href="#">ventas</a></li>
   <li><a href="altas_usuarios.php">clientes</a></li>
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

    <div align="center">
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
    </div>
    <p>&nbsp;</p>

</body>
</html>
<?php
mysql_free_result($clientes);
?>
