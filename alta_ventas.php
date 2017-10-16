<?php require_once('Connections/concredito.php'); ?>

<?php
error_reporting(0);
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
  $insertSQL = sprintf("INSERT INTO ventas_activas (folio_venta, clave_cliente, nombre, total, fecha, estatus) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['folio_venta'], "text"),
                       GetSQLValueString($_POST['clave_cliente'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['total'], "double"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['estatus'], "text"));

  mysql_select_db($database_concredito, $concredito);
  $Result1 = mysql_query($insertSQL, $concredito) or die(mysql_error());

  $insertGoTo = "ventas.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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

mysql_select_db($database_concredito, $concredito);
$query_configuracion = "SELECT * FROM configuracion";
$configuracion = mysql_query($query_configuracion, $concredito) or die(mysql_error());
$row_configuracion = mysql_fetch_assoc($configuracion);
$totalRows_configuracion = mysql_num_rows($configuracion);

$maxRows_pre_venta = 10;
$pageNum_pre_venta = 0;
if (isset($_GET['pageNum_pre_venta'])) {
  $pageNum_pre_venta = $_GET['pageNum_pre_venta'];
}
$startRow_pre_venta = $pageNum_pre_venta * $maxRows_pre_venta;

mysql_select_db($database_concredito, $concredito);
$query_pre_venta = "SELECT * FROM pre_venta";
$query_limit_pre_venta = sprintf("%s LIMIT %d, %d", $query_pre_venta, $startRow_pre_venta, $maxRows_pre_venta);
$pre_venta = mysql_query($query_limit_pre_venta, $concredito) or die(mysql_error());
$row_pre_venta = mysql_fetch_assoc($pre_venta);

if (isset($_GET['totalRows_pre_venta'])) {
  $totalRows_pre_venta = $_GET['totalRows_pre_venta'];
} else {
  $all_pre_venta = mysql_query($query_pre_venta);
  $totalRows_pre_venta = mysql_num_rows($all_pre_venta);
}
$totalPages_pre_venta = ceil($totalRows_pre_venta/$maxRows_pre_venta)-1;

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
// calculos
$res=mysql_query("select importe from pre_venta");
										    while($row=mysql_fetch_assoc($res))
											$importe2 += $row['importe'];
											//echo $importe2;
											//echo "<br>";
$cantidad = 1;
$precio = $importe2;
$importe = $precio * $cantidad;
//echo $importe;
//echo "<br>";
  //echo "precio \n";
$Precio_articulo = $importe2;
$tasa_financiamiento = $row_configuracion['tasa'];
$plazo = $row_configuracion['plazo'];
$Precio = $Precio_articulo *(1 + ($tasa_financiamiento * $plazo) /100);
//echo $Precio;
//echo "\n";
//echo "enganche \n";
$porcentaje_enganche = $row_configuracion['enganche'];
$enganche = ($porcentaje_enganche/100) * $importe;
//echo $enganche;

//echo "bonificacion enganche \n ";
$Bonificacion_enganche = $enganche * (($tasa_financiamiento * $plazo) /100);
//echo $Bonificacion_enganche;

 //echo "total adeudo \n ";
$total_adeudo = $importe - $enganche - $Bonificacion_enganche;
//echo $total_adeudo;
$precio_contado = $total_adeudo / (1 + (( $tasa_financiamiento * $plazo) /100));
//echo $precio_contado;

//echo "3 meses";

 $total_pagar3 = $precio_contado * (1 + (( $tasa_financiamiento * 3) /100));
//echo $total_pagar3;

//echo "6 meses";

//6 Meses
$total_pagar6 = $precio_contado * (1 + (( $tasa_financiamiento * 6) /100));
//echo $total_pagar6;

//echo "9 meses";

//9 Meses
$total_pagar9 = $precio_contado * (1 + (( $tasa_financiamiento * 9) /100));
//echo $total_pagar9;
//echo "<br>";
//echo "<br>";
//echo "12 meses";
//echo "<br>";
//12 Meses
$total_pagar12 = $precio_contado * (1 + (( $tasa_financiamiento * 12) /100));
//echo $total_pagar12;
//echo "<br>";
/*
3 meses
Importe Abono = 3,376.00 / 3
=1,125.33
6 meses
Importe Abono = 3,637.60 / 6
= 606,26
9 meses
Importe Abono = 3,899.20 / 9
= 433.24
12 meses
Importe Abono = 4,160.84 / 12
= 346.73*/
//echo "<abonos";

//echo "abono a 3 meses";
//echo "<br>";
$importe_abono3 = $total_pagar3 / 3;
//echo $importe_abono3;
//echo "abono a 6 meses";
$importe_abono6 = $total_pagar6 / 6;
//echo $importe_abono6;

//echo "abono a 9 meses";
$importe_abono9 = $total_pagar9 / 9;
//echo $importe_abono9;

//echo "abono a 12 meses";

$importe_abono12 = $total_pagar12 / 12;
//echo $importe_abono12;

//echo "importe ahorra";

/*Importe Ahorra = Total Adeudo – Total a Pagar*/
//echo "abono a 3 meses";

$importe_ahorra3 = $total_adeudo - $total_pagar3 ;
//echo $importe_ahorra3;

// echo "abono a 6 meses";

$importe_ahorra6 = $total_adeudo - $total_pagar6 ;
//echo $importe_ahorra6;
//echo "abono a 9 meses";

$importe_ahorra9 = $total_adeudo - $total_pagar9 ;
//echo $importe_ahorra9;

//echo "abono a 12 meses";

$importe_ahorra12 = $total_adeudo - $total_pagar12 ;
//echo $importe_ahorra12;

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Registro de ventas</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
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
	color: #000000;
}
</style>
</head>

<body>
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
<div class="datagrid">
<table width="904" border="1" cellpadding="1">
<thead>
      <tr>
        <th height="33" colspan="2">Datos del cliente</th>
        <th height="33">RFC: <?php echo $row_clientes['rfc']; ?></th>
       
      </tr>
    </thead>
  <tr>
    <th colspan="2" scope="col"> </th>
  </tr>
  <tr>
    <th width="86" scope="col">nombre:</th>
    <th width="460" scope="col"><?php echo $row_clientes['nombre']; ?> <?php echo $row_clientes['apellido_pat']; ?> <?php echo $row_clientes['apellido_mat']; ?> <a href="buscador.php">agregar</a></th>
    
  </tr>
</table>
</div>
</div>
</div>

 <table width="987" height="477" border="0">
</p>
<tr>
  <td bgcolor="#FFFFFF"><form action="" method="post">
  <div class="datagrid">
    <div align="right">
      <table  align="center" width="900" border="1">
        <thead>
          <tr>
            <th height="33" colspan="2">Articulos</th>
            </tr>
          </thead>
        <tr>
          <td height="75"><table width="47%" align="center" border="0" cellspacing="0" cellpadding="0" >
            <tr valign="baseline">
              <td width="211" height="24" ><input name="busca" type="text"  placeholder="ingrese articulo.." id="busca">
                <input type="submit" value="Buscar" id="boton_busca"></td>
              </tr>
            </table>
            <div align="center">
              <?php
$busca="";
$busca=$_POST['busca'];
mysql_connect("localhost","root","1234");
mysql_select_db("concredito");
if($busca!=""){
	$busqueda=mysql_query("SELECT * FROM articulos WHERE descripcion_articulo  LIKE '".$busca."%'" );
	
		
		echo '<table>	
			<th>
			<th>Resultado de busqueda
			<th>
		 </th> 
		 </th>
		 </tr>';
		while($f=mysql_fetch_array($busqueda)){
		echo"<tr id='t' onClick='location='alta_ventas.php''>";
		echo  "<td>","Descripción","</td>";
		echo  "<td>".$f['descripcion_articulo']."</td>";
		echo  "<td style=visibility:hidden>".$f['id_articulo']."</td>";
		$id=str_replace(" ","+",$f['id_articulo']);
		  $cadena= "<td><a href=cantidad.php?id=".$id.">agregar </a></td>";
		  echo $cadena;				
	echo "</tr>";
		} 
     echo "</table>"; 
		//echo "no se encontraron registros";
} 
	
?>
            </div></td>
          </tr>
      </table>
    </div>
  </div>
    <div align="center">
  <table width="987" height="477" border="0">
  </p>
    </div>
    <tr>
      <td bgcolor="#FFFFFF">
    <div align="center">
    <form action="" method="post">
    </div>
    <p align="center">
    <p align="center">&nbsp;</p>
  <div class="datagrid">
      <div align="center">
        <table border="1" cellpadding="1">
          <thead>
            <tr>
              <th height="33" colspan="6">Concepto de venta</th>
            </tr>
          </thead>
                        <tr>
                          <td>descripcion</td>
                          <td>modelo</td>
                          <td>cantidad</td>
                          <td>precio</td>
                          <td>importe</td>
                          <td>&nbsp;</td>
                        </tr>
                        <?php do { ?>
                          <tr>
                            <td><?php echo $row_pre_venta['descripcion']; ?></td>
                            <td><?php echo $row_pre_venta['modelo']; ?></td>
                            <td><?php echo $row_pre_venta['cantidad']; ?></td>
                            <td><?php echo $row_pre_venta['precio']; ?></td>
                            <td><?php echo $row_pre_venta['importe']; ?></td>
                            <td><a href="eliminar_preventa.php?id=<?php echo $row_pre_venta['id']; ?>"><img src="images/cancelar.png" width="36" height="36" border="0"></a></td>
                          </tr>
                          <?php } while ($row_pre_venta = mysql_fetch_assoc($pre_venta)); ?>
        </table>
      </div>
                                           <p align="center">&nbsp;</p>
										   <p align="center">&nbsp;										                                                                   </p>
										   <p align="center">&nbsp;</p>
</div>
                    <p align="center">&nbsp;</p>
    <div align="center">
      <table width="251" height="78"   border="1" cellpadding="1">
                        <tr>
                          <td width="163" bgcolor="#CCCCCC"><div align="right">Enganche:</div></td>
                          <td width="27"><?php printf ("%.2f",$enganche); ?> </td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC"><div align="right">Bonificacion Enganche: </div></td>
                          <td><?php printf ("%.2f",$Bonificacion_enganche) ; ?></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC"><div align="right">Total:</div></td>
                          <td><?php printf ("%.2f",$total_adeudo) ; ?> </td>
                        </tr>
      </table>
    </div>
                  <p align="center">&nbsp;</p>
                    <p align="center">&nbsp;</p>
    <div class="datagrid">
                    <div align="center">
                      <table width="987" border="1" cellspacing="0">
                        <thead>
                          <tr>
                            <th height="33" colspan="4">Abonos Mensuales</th>
                          </tr>
                        </thead>
                        <tfoot>
                        </tfoot>
                        <tr>
                          <td width="322">3 ABONOS DE <?php printf ("%.2f",$importe_abono3) ; ?></td>
                          
                          <td width="366">TOTAL A PAGAR <?php printf ("%.2f", $total_pagar3) ; ?> </td>
                          <td width="221">SE AHORRA  <?php printf ("%.2f",$importe_ahorra3) ; ?> </td>
                          <td width="60">
                            <label>
                              <input name="radiobutton" type="radio" value="radiobutton">
                            </label>
                            
                          </td>
                        </tr>
                        <tr>
                          <td>6 ABONOS DE <?php printf ("%.2f",$importe_abono6) ; ?></td>
                          
                          <td>TOTAL A PAGAR <?php printf ("%.2f",$total_pagar6) ; ?></td>
                          <td>SE AHORRA  <?php printf ("%.2f", $importe_ahorra6) ; ?></td>
                          <td><input name="radiobutton" type="radio" value="radiobutton"></td>
                        </tr>
                        <tr>
                          <td>9 ABONOS DE <?php printf ("%.2f",$importe_abono9) ; ?></td>
                          
                          <td>TOTAL A PAGAR <?php printf ("%.2f",$total_pagar9) ; ?></td>
                          <td>SE AHORRA  <?php printf ("%.2f",$importe_ahorra9) ; ?></td>
                          <td><input name="radiobutton" type="radio" value="radiobutton"></td>
                        </tr>
                        <tr>
                          <td>12 ABOoNOS DE <?php echo $importe_abono12 ; ?></td>
                          
                          <td>TOTAL A PAGAR <?php echo $total_pagar12 ; ?></td>
                          <td>SE AHORRA  <?php echo $importe_ahorra12 ; ?></td>
                          <td><input name="radiobutton" type="radio" value="radiobutton"></td>
                        </tr>
                        </table>
                    

    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <div align="right">
        <div align="center">
          <table align="right">
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><input type="text" style="visibility:hidden"  name="folio_venta" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><input type="text" name="clave_cliente"  style="visibility:hidden" value="<?php echo $row_clientes['clave_cliente']; ?>" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><span id="sprytextfield1">
                <input type="text" name="nombre" style="visibility:hidden" value="<?php echo $row_clientes['nombre']; ?> <?php echo $row_clientes['apellido_pat']; ?> <?php echo $row_clientes['apellido_mat']; ?>" size="32">
              <span class="textfieldRequiredMsg">Se requiere cliente.</span></span></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><input type="text" name="total" style="visibility:hidden" value="<?php printf ("%.2f",$total_adeudo) ; ?>" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><input type="text" name="fecha" style="visibility:hidden" value="<?php echo date("d/m/Y ");?>" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><input type="text" name="estatus" style="visibility:hidden" value="activo" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><input type="submit" class="btn success" value="Continuar"></td>
            </tr>
            </table>
          <input type="hidden" name="MM_insert" value="form1">
          
        </div>
    </form>
    <p align="center">&nbsp;</p>
  
    <div align="center">
      <script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
    </script>
    </div></div>
    </div>
    <p align="center">&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($articulos);

mysql_free_result($configuracion);

mysql_free_result($pre_venta);

mysql_free_result($clientes);
?>