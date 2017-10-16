<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>


  precio articulo
  <?php 
  echo "prueba";
echo "<br>";
$cantidad = 10;
$precio = 1000;
$importe = $precio * $cantidad;
echo $importe; 
 echo "<br>";
 echo "<br>";
  echo "precio <br>";

$Precio_articulo = 1;
$tasa_financiamiento = 2.8;
$plazo = 12;
$Precio = $Precio_articulo *(1 + ($tasa_financiamiento * $plazo) /100);
echo $Precio;
echo "<br>";
echo "<br>";
echo "enganche \n";
$porcentaje_enganche = 20;
$enganche = ($porcentaje_enganche/100) * $importe;
echo $enganche;
echo "<br>";
echo "<br>";
echo "bonificacion enganche \n ";
echo "<br>";
$Bonificacion_enganche = $enganche * (($tasa_financiamiento * $plazo) /100);
printf ("%.2f",$Bonificacion_enganche);
echo "<br>"; 
echo $Bonificacion_enganche;
echo "<br>";
echo "<br>";
 echo "total adeudo \n ";
 echo "<br>";
$total_adeudo = $importe - $enganche - $Bonificacion_enganche;
echo $total_adeudo;
echo "<br>";
echo "<br>";
echo "precio contado \n ";
echo "<br>";
/*p>Precio Contado = Total Adeudo / (1 + ((Tasa Financiamiento X Plazo Máximo) / 100))</p>
<p> Donde cada uno de los datos, fueron calculados previamente.</p>
<p>Ejemplo:
  Total Adeudo = 4,160.84
  Tasa Financiamiento = 2.8
  Plazo Máximo = 12
  Precio Contado = 4,160.84 / (1+ (2.8 X 12)/100))
  = 4,160.84 / 1.336
  = 3,114.40*/
$precio_contado = $total_adeudo / (1 + (( $tasa_financiamiento * $plazo) /100));
echo $precio_contado;
echo "<br>";
echo "<br>";
/*Precio Contado = 3,114.40
Tasa Financiamiento = 2.8
Plazo = Es cada uno de los plazos, a los cuales se requiere calcular (3,6,9,12)
3 Meses
Total a Pagar = 3,114.40 X (1 + (2.8 X 3) /100)
 = 3,114.40 X 1.084
 = 3,376.00*/
 echo "<br>";
echo "3 meses";
echo "<br>";
 $total_pagar3 = $precio_contado * (1 + (( $tasa_financiamiento * 3) /100));
echo $total_pagar3;
echo "<br>";
echo "6 meses";
echo "<br>";
//6 Meses
$total_pagar6 = $precio_contado * (1 + (( $tasa_financiamiento * 6) /100));
echo $total_pagar6;
echo "<br>";
echo "<br>";
echo "9 meses";
echo "<br>";
//9 Meses
$total_pagar9 = $precio_contado * (1 + (( $tasa_financiamiento * 9) /100));
echo $total_pagar9;
echo "<br>";
echo "<br>";
echo "12 meses";
echo "<br>";
//12 Meses
$total_pagar12 = $precio_contado * (1 + (( $tasa_financiamiento * 12) /100));
echo $total_pagar12;
echo "<br>";
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
echo "<br>";
echo "<abonos";
echo "<br>";
echo "<br>";
echo "abono a 3 meses";
echo "<br>";
$importe_abono3 = $total_pagar3 / 3;
echo $importe_abono3;
echo "<br>";

echo "abono a 6 meses";
echo "<br>";
$importe_abono6 = $total_pagar6 / 6;
echo $importe_abono6;
echo "<br>";
echo "abono a 9 meses";
echo "<br>";
$importe_abono9 = $total_pagar9 / 9;
echo $importe_abono9;
echo "<br>";
echo "abono a 12 meses";
echo "<br>";
$importe_abono12 = $total_pagar12 / 12;
echo $importe_abono12;
echo "<br>";
echo "<br>";
echo "importe ahorra";
echo "<br>";

/*Importe Ahorra = Total Adeudo – Total a Pagar*/
echo "abono a 3 meses";
echo "<br>";
$importe_ahorra3 = $total_adeudo - $total_pagar3 ;
echo $importe_ahorra3;
echo "<br>";
echo "abono a 6 meses";
echo "<br>";
$importe_ahorra6 = $total_adeudo - $total_pagar6 ;
echo $importe_ahorra6;
echo "abono a 9 meses";
echo "<br>";
$importe_ahorra9 = $total_adeudo - $total_pagar9 ;
echo $importe_ahorra9;
echo "<br>";
echo "abono a 12 meses";
echo "<br>";
$importe_ahorra12 = $total_adeudo - $total_pagar12 ;
echo $importe_ahorra12;
echo "<br>";
echo "<br>";

?>
</p>

  </p>
 
  
</p>
<p>&nbsp;</p>
<p>
  
</body>
</html>