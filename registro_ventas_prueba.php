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
</head>

<body>
<table width="904" border="1">
  <tr>
    <th colspan="4" scope="col">nota:debes agregar articulos primero y despues cliente para poder continuar </th>
  </tr>
  <tr>
    <th width="86" scope="col">nombre:</th>
    <th width="460" scope="col"><?php echo $row_clientes['nombre']; ?> <?php echo $row_clientes['apellido_pat']; ?> <?php echo $row_clientes['apellido_mat']; ?> </th>
    <th width="128" scope="col"><div align="left">RFC: <?php echo $row_clientes['rfc']; ?></div></th>
    <th width="128" scope="col"><a href="buscador.php">agregar</a></th>
  </tr>
</table>
<p>&nbsp;</p>

 <table width="987" height="477" border="0">
</p>
<tr>
  <td bgcolor="#FFFFFF"><form action="" method="post">
    <table width="900" border="1">
      <tr>
        <td>Registro de ventas</td>
      </tr>
      <tr>
        <td height="64"><table width="47%" align="center" border="0" cellspacing="0" cellpadding="0" >
            <tr valign="baseline">
              <td width="211" height="24" ><input name="busca" type="text"  placeholder="ingrese articulo.." id="busca">
                <input type="submit" name="submit" value="Buscar" id="boton_busca"></td>
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
		echo"<tr id='t' onClick='location='buscador.php''>";
		echo  "<td>","Descripción","</td>";
		echo  "<td>".$f['descripcion_articulo']."</td>";
		echo  "<td style=visibility:hidden>".$f['id_articulo']."</td>";
		$id=str_replace(" ","+",$f['id_articulo']);
		  $cadena= "<td><a href=cantidad.php?id=".$id."&cliente?>agregar </a></td>";
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
    <table width="987" height="477" border="0">
</p>
<tr>
  <td bgcolor="#FFFFFF">
<form action="" method="post">
  <p>
  <p>&nbsp;</p>
                    
<div align="center"> 
  <table border="1" cellpadding="1">
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
										   <p>&nbsp;</p>
										   <p>&nbsp;										                                                                   </p>
										   <p>&nbsp;</p>
</div>
                    <p>&nbsp;</p>
<div align="right">
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
                    <p>&nbsp;</p>
</div>
                    <p>&nbsp;</p>
    <div class="datagrid">
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
</div>
    <p>&nbsp;</p>

    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <div align="right">
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
            <td><label>
              <input type="reset" name="Submit" value="Cancelar">
            </label>
            <input type="submit" value="Continuar"></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1">
        </div>
    </form>
    <p>&nbsp;</p>
  
    <script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
    </script>
</body>
</html>
<?php
mysql_free_result($articulos);

mysql_free_result($configuracion);

mysql_free_result($pre_venta);

mysql_free_result($clientes);
?>