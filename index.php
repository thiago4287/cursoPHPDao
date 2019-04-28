<?php

require_once("config.php");

$usuario = new Usuario();

$usuario->loadById(18);
echo $usuario;
?>