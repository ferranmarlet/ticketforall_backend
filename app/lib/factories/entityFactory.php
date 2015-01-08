<?php
require '../app/lib/entities/userEntity.php';
require '../app/lib/entities/periodEntity.php';

class entityFactory{
  function _construct(){

  }

  function getUserEntity(){
    return new userEntity;
  }

  function getPeriodEntity(){
    return new periodEntity;
  }

  function hola(){
    return "hola";
  }

}

?>
