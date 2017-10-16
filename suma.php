<?php require_once('Connections/concredito.php'); ?>
<?php
mysql_select_db($database_concredito, $concredito);
$query_clientes = "SELECT * FROM clientes";
$clientes = mysql_query($query_clientes, $concredito) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);
$totalRows_clientes = mysql_num_rows($clientes);

mysql_select_db($database_concredito, $concredito);
$query_preventa = "SELECT * FROM pre_venta";
$preventa = mysql_query($query_preventa, $concredito) or die(mysql_error());
$row_preventa = mysql_fetch_assoc($preventa);
$totalRows_preventa = mysql_num_rows($preventa);
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
</body>
</html>
<?php
mysql_free_result($clientes);

mysql_free_result($preventa);
?>
