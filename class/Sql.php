<?php
class Sql extends PDO{
  private $conn;
  public function __construct()
  {
    $this->conn = new PDO("mysql:host=localhost;dbname=desejos","root","root");
  }
  public function setParams($statment,$params){
    foreach ($params as $key => $value) {
      $this->setParam($statment,$key,$value);
    }
  }

  public function setParam($statment,$key,$value){
    $statment->bindParam($key,$value);
  }

  public function queryPDO($rawQuery,$params=array()){
    $stmt = $this->conn->prepare($rawQuery);
    $this->setParams($stmt,$params);
    $stmt->execute();
    return $stmt;
  }
  public function returnResponse($query,$params=array()){
    $stmt = $this->queryPDO($query,$params);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return json_encode($result);
  }
  public function lastId() {
    return $this->conn->lastInsertId();
}
}
?>