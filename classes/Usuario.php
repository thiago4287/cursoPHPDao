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


    public function loadById($id){
        $sql = new Sql();

        $result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
            ":ID"=>$id));

            if(count($result) > 0){
                $valor = $result[0];

                $this->setIdusuario($valor['idusuario']);
                $this->setDeslogin($valor['deslogin']);
                $this->setDessenha($valor['dessenha']);
                $this->setDtcadastro(new DateTime($valor['dtcadastro']));
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
            $valor = $resultado[0];

            $this->setIdusuario($valor['idusuario']);
            $this->setDeslogin($valor['deslogin']);
            $this->setDessenha($valor['dessenha']);
            $this->setDtcadastro(new DateTime($valor['dtcadastro']));

        }else {
            throw new Exception("Login e/ou senha inválidos!");
        }
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