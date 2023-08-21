<?php
spl_autoload_register(function($nameClass){
  $fileName = "class".DIRECTORY_SEPARATOR.$nameClass.".php";
  if(isset($fileName)){
    require_once($fileName);
  }
  else{
    throw new Exception("Arquivo não encontrado");
  }
});
?>