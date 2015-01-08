<?php
require '../app/lib/entities/userEntity.php';

class entityFactory{
  function _construct(){

  }

  function getUserEntity(){
    return new userEntity;
  }

  function hola(){
    return "hola";
  }

}

?>
