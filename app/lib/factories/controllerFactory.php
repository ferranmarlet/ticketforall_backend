<?php

require '../app/lib/controllers/sessionCtrl.php';

class controllerFactory{
  function _construct(){

  }

  function getSessionCtrl(){
    return new sessionCtrl();
  }

  function hola(){
    return "hola";
  }

}

?>
