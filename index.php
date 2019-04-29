<?php

require_once("config.php");

//Retorna um único usuário

// $usuario = new Usuario();
// $usuario->loadById(18);
// echo $usuario;

//////////////////////////////////////////

//Carrega uma lista de usuarios
//Não preciso instanciar a classe Usuario pois o método é estático

// $lista = Usuario::listaUsuarios(); 
// echo json_encode($lista);

//////////////////////////////////////////

//Retorna usuarios por like
// echo "<br><br> Lista de like<br><br>";
// $search = Usuario::search("ar");
// echo json_encode($search);

///////////////////////////////////////////
//Buncar o usuario por login e senha

 //$usuario = new Usuario();
// $usuario->login("Renato Gaúcho", "qwert");
//Renato GaÃºcho
//echo $usuario;

/////////////////////////////////////////////
//INSERINDO UM USUARIO UTILIZANDO A PROCEDURE DO METODO PARA INSERIR E TRAZER O ID SETADO

// $aluno = new Usuario("Kleber Silva", "329433");
// $aluno->insert();
// echo $aluno;

/////////////////////////////////////////////////
//ATUALIZANDO DADOS DO BANCO
$usuario = new Usuario();
$usuario->loadById(1);
$usuario->update("Abel Braga Junior", "cricri");

echo $usuario;

?>