<?php

class Usuario {
    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    public function getIdusuario(){
        return $this->idusuario;
    }
    public function setIdusuario($id){
        $this->idusuario = $id;
    }

    public function getDeslogin(){
        return $this->deslogin;
    }
    public function setDeslogin($login){
        $this->deslogin = $login;
    }

    public function getDessenha(){
        return $this->dessenha;
    }
    public function setDessenha($senha){
        $this->dessenha = $senha;
    }

    public function getDtcadastro(){
        return $this->dtcadastro;
    }
    public function setDtcadastro($data){
        $this->dtcadastro = $data;
    }

    public function __construct($login = "", $senha = ""){
        $this->setDeslogin($login);
        $this->setDessenha($senha);
    }

    /////////////////////////////////////////////////////////////////////////////////
    //Função para setar os dados quando for solicitado

    public function setData($dados){
        $this->setIdusuario($dados['idusuario']);
        $this->setDeslogin($dados['deslogin']);
        $this->setDessenha($dados['dessenha']);
        $this->setDtcadastro(new DateTime($dados['dtcadastro']));
    }

    /////////////////////////////////////////////////////////////////////////////////
    public function loadById($id){
        $sql = new Sql();

        $result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
            ':ID'=>$id));

            if(count($result) > 0){
              $this->setData($result[0]);
            }
    }
/////////////////////////////////////////////////////////////////////////////////////////////////
//IMPLEMENTAÇÃO DA FUNÇÃO LISTAR

    public static function listaUsuarios(){//Método estático, posso acessar diretamente com o ::listaUsuarios
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
    }

/////////////////////////////////////////////////////////////////////////////////////////////////
//IMPLEMENTAÇÃO DA FUNÇÃO PROCURAR POR LOGIN

    public static function search($login){
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin",
        array(':SEARCH'=>"%".$login."%"));

    }
//////////////////////////////////////////////////////////////////////////////////////////////////
//IMPLEMENTAÇÃO DO LOGIN

    public function login($login, $password){
        $sql = new Sql();
        $resultado = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :SENHA",
        array(':LOGIN'=>$login, ':SENHA'=>$password));

        if(count($resultado) > 0){
            // $valor = $resultado[0];

            // $this->setIdusuario($valor['idusuario']);
            // $this->setDeslogin($valor['deslogin']);
            // $this->setDessenha($valor['dessenha']);
            // $this->setDtcadastro(new DateTime($valor['dtcadastro']));
            $this->setData($resultado[0]);

        }else {
            throw new Exception("Login e/ou senha inválidos!");
        }
    }


    //////////////////////////////////////////////////////////////////////////////////////////////
    //IMPLEMENTAÇÃO DO MÉTODO INSERT

    public function insert(){

        $sql = new Sql();
        //O select está usando uma procedure que está no banco de dados
        $result = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
            ':LOGIN'=>$this->getDeslogin(),
            ':PASSWORD'=>$this->getDessenha()
        ));
        if(count($result) > 0){
            $this->setData($result[0]);
        }

      
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////
    //IMPLEMENTAÇÃO DO MÉTODO UPDATE

    public function update($login, $senha){
        $this->setDeslogin($login);
        $this->setDessenha($senha);
    

        $sql = new Sql();

        $sql->query(" UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
            ':LOGIN'=>$this->getDeslogin(),
            ':PASSWORD'=>$this->getDessenha(),
            ':ID'=>$this->getIdusuario()
        ));
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //IMPLEMENTAÇÃO DO MÉTODO DELETE

    public function delete(){
        $sql = new Sql();
      
        //O  DELETE  não tem '*' pq se refere a linha e não as colunas, q também serão apagadas com as linhas
        $sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
            ':ID'=>$this->getIdusuario()
        ));

        $this->setIdusuario(0);
        $this->setDeslogin("");
        $this->setDessenha("");
        $this->setDtcadastro(new DateTime());
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //IMPLEMENTAÇÃO DO TOSTRING

    public function __toString(){
        return json_encode(array(
            'idusuario'=>$this->getIdusuario(),
            'deslogin'=>$this->getDeslogin(),
            'dessenha'=>$this->getDessenha(),
            'dtcadastro'=>$this->getDtcadastro()->format("d/m/Y  H:i:s")
        ));
    }
}

?>