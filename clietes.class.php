<?php
class Clientes

{
	public function _construct() {
		$dbhost = 'localhost';
		$dbuser = 'root';
		$dbpass = '1234';
		$dbname = 'concredito';
		
		mysql_connect($dbhost, $dbuser,$dbpass );
		
		mysql_select_db($dbname);
		
		}
	public function buscarCliente ($nombreCliente){
		
		$datos = array();
		
		$sql ="SELECT * FROM clientes WHERE nombre LIKE '%$nombreCliente%' OR apellido_pat LIKE '%$nombreCliente%' OR apellido_mat LIKE '%$nombreCliente%'" ;
		
		$resultado = mysql_query($sql);
		
		while ($row = mysql_fetch_array($resultado,MYSQL_ASSOC))
		{
			$datos[] = array("value" => $row['$ombre']);
			}
		}
	  return $datos ;
}
?>