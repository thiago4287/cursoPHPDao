<?php

require_once("config.php");

$sql = new Sql();

$usuarios = $sql->select("SELECT * FROM tb_usuarios");
//var_dump($usuarios);

echo json_encode($usuarios);
?>