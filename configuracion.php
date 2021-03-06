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
  $insertSQL = sprintf("INSERT INTO configuracion (tasa, enganche, plazo) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['tasa'], "double"),
                       GetSQLValueString($_POST['enganche'], "double"),
                       GetSQLValueString($_POST['plazo'], "double"));

  mysql_select_db($database_concredito, $concredito);
  $Result1 = mysql_query($insertSQL, $concredito) or die(mysql_error());

  $insertGoTo = "configuracion.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
<?php echo date("d/m/Y ");?>
</span>
   
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<link rel="stylesheet" href="css/forms.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script  src="js/index.js"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script  src="js/index.js"></script>
    <p>&nbsp;</p><p>&nbsp;</p>
<p>&nbsp;</p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <div align="center">
  <div class="datagrid">
    <table align="center">
     <thead>
      <tr>
        <th height="33" colspan="4">Configuración General</th>
      </tr>
    </thead>
      <tr valign="baseline">
        <td nowrap align="right">Tasa Financiamiento:</td>
        <td><input type="text" name="tasa" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">% Enganche:</td>
        <td><input type="text" name="enganche" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Plazo M&aacute;ximo:</td>
        <td><select name="plazo" id="carrera">
          <option value="3">3 meses</option>
          <option value="6">6 meses</option>
		  <option value="9">9 meses</option>
		  <option value="12">12 meses</option>
     
   
        </select></td>
      </tr>
    </table>
       
        <div align="right">
          <input type="reset" class="btn success" name="Submit" value="Cancelar">
          <input type="hidden" name="MM_insert" value="form1">
          <input type="submit" class="btn success" value="Guardar">
        </div>
  </div>
  </div>
</form>

</body>
</html>
