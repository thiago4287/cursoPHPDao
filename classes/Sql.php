<?php 

 class Sql extends PDO {
     private $conn;
//Este construtor permite que ao instanciar a classe Sql, eu já recebo a conexao com o mysql
     public function __construct(){
         $this->conn = new PDO("mysql:dbname=db_php7; host=localhost", "root", "aksb45t8v");
         //$this->conn->query("SET NAMES utf-8;");//Setar caso não apareça dados no json_encode
     }


     //Podemos criar uma função que vai setar vários parâmetros por vez
     //Usado na função query para setar os parâmetros
     public function setParams($statement, $parameters = array()){
         foreach($parameters as $key=> $value){
             $this->setParam($statement,$key, $value);
         }
     }


     //Podemos também criar uma funcção que seta apenas um parâmetro por vez
     private function setParam($statement, $key, $value){//Será usando no foreach da função acima
      // echo "Valor do statement no 'setparam' : ".var_dump($statement);
        $statement->bindParam($key, $value);
     }



     //Criamos o método abaixo para executar comando na classe, uma function que recebe o nome 'query' 
     // que recebe 2 parâmetros, onde o primeiro é a query 'bruta' e o segudo  é um são os nossos dados
      //que já receb um array para representá-los

     public function query($rawQuery, $params= array()){
        //Abaixo criamos uma variável que vai receber a conexão coma a query
        $stmtQuery = $this->conn->prepare($rawQuery);
       
        //Aqui eu chamo a função setParams() e passo os parâmetros
        $this->setParams($stmtQuery, $params);

         $stmtQuery->execute();

         return $stmtQuery;
   
     }

     public function select($rawQuery, $params = array()): array {//retorna um array
         $stmtSelect = $this->query($rawQuery, $params);

         return $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
     }
 }

?>