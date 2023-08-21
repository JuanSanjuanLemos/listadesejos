<?php
class IdNotFoundException extends Exception{
  public function __construct($message="Produto não encontrado!",$code=404,Throwable $previous = null)
  {
    parent::__construct($message, $code,$previous);
  }
}
?>