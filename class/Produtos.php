<?php
class Produtos{
  private $id;
  private $nome;
  private $link;
  private $data_criacao;
  private $adquirido;

  public function getId()
  {
    return $this->id;
  }
  public function setId($id)
  {
    $this->id = $id;
  }
  public function getNome()
  {
    return $this->nome;
  }
  public function setNome($nome)
  {
    $this->nome = $nome;
  }
  public function getLink()
  {
    return $this->link;
  }
  public function setLink($link)
  {
    $this->link = $link;
  }
  public function getDataCriacao()
  {
    return $this->data_criacao;
  }
  public function setDataCriacao($data_criacao)
  {
    $this->data_criacao = $data_criacao;
  }
  public function getAdquirido()
  {
    return $this->adquirido;
  }
  public function setAdquirido($adquirido)
  {
    $this->adquirido = $adquirido;
  }

  public static function getProdutos(){
    $sql = new Sql();
    $results = $sql->returnResponse("SELECT * FROM produtos");
    return $results;
  }
  public static function getProdutoById($id){
    try {
      $sql = new Sql();
      $result = $sql->returnResponse("SELECT * FROM produtos WHERE id = :ID",array(":ID"=>$id));
      $result = json_decode($result,true);
      if(count($result)>0){
        $result = $result[0];
        return json_encode($result);
      }
     throw new IdNotFoundException();
    } catch (IdNotFoundException $e) {
      echo "Erro: " .$e->getMessage();
    }
  }

  public function postProduto($nome,$link=""){
    $sql = new Sql();
    $sql->queryPDO("INSERT INTO produtos (nome,link) VALUES (:NOME, :LINK)",
    array(
      ":NOME"=>$nome,":LINK"=>$link
    ));
    $result = $this->getProdutoById($sql->lastId());
    try {
      return $this->setDataProduto($result);
    } catch (Exception $e) {
      return $e;
    }
  }

  public static function putProdutoById($id,$nome,$link,$adquirido){
    $sql = new Sql();
    $sql->queryPDO("UPDATE produtos SET nome = :NOME, link = :LINK, adquirido=:ADQUIRIDO WHERE id = :ID", array(":NOME"=>$nome,":LINK"=>$link,":ID"=>$id,":ADQUIRIDO"=>$adquirido));
    $result = Produtos::getProdutoById($id);
    return $result;
  }
  public function setDataProduto($result){
    $resultArray = json_decode($result,true);
    if(isset($resultArray)){
      $this->setId($resultArray['id']);
      $this->setNome($resultArray['nome']);
      $this->setLink($resultArray['link']);
      $this->setDataCriacao($resultArray['data_adicao']);
      $this->setAdquirido($resultArray['adquirido']);
      return $result;
    }
    else{
      throw new Exception();
    }

  }
  public function putThisProduto($nome,$link,$adquirido){
    $sql = new Sql();
    $sql->queryPDO("UPDATE produtos SET nome = :NOME, link = :LINK, adquirido=:ADQUIRIDO WHERE id = :ID", array(":NOME"=>$nome,":LINK"=>$link,":ID"=>$this->getId(),":ADQUIRIDO"=>$adquirido));
    $result = Produtos::getProdutoById($this->getId());
    try {
      return $this->setDataProduto($result);
    } catch (Exception $e) {
      return $e;
    }
  }

  public static function deleteProduto($id){
    Produtos::getProdutoById($id);
    $sql = new Sql();
    $sql->queryPDO("DELETE FROM produtos WHERE id= :ID",array(":ID"=>$id));
  }

  public function __toString()
  {
    return "
      ID: ". $this->getId().", </br>" .
      "Nome: ". $this->getNome().", </br>".
      "Link: ". $this->getLink().", </br>".
      "Data de criação: ". $this->getDataCriacao().", </br>".
      "Adquirido: ". ($this->getAdquirido() == 0 ? "Não": "Sim") . " </br>";
  }
}
?>