<?php
require '../app/lib/entities/userEntity.php';
require '../app/lib/entities/periodEntity.php';
require '../app/lib/entities/couponEntity.php';

class entityFactory{
  function _construct(){

  }

  function getUserEntity(){
    return new userEntity;
  }

  function getPeriodEntity(){
    return new periodEntity;
  }

  function getCouponEntity(){
    return new couponEntity;
  }

  function hola(){
    return "hola";
  }

}

?>
