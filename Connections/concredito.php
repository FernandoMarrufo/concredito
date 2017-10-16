<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_concredito = "localhost";
$database_concredito = "concredito";
$username_concredito = "root";
$password_concredito = "1234";
$concredito = mysql_pconnect($hostname_concredito, $username_concredito, $password_concredito) or trigger_error(mysql_error(),E_USER_ERROR); 
?>