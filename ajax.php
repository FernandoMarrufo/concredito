<?php

include 'clientes.class.php';

$usuario = new Clientes();
 echo json_encode ($usuario->buscadorCliente($_GET['term']));
?>