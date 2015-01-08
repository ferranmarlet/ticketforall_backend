<?php

require '../app/lib/controllers/sessionCtrl.php';
require '../app/lib/controllers/gestioPeriodesAbsenciaCtrl.php';

class controllerFactory{
  function __construct(){
  }

  function getSessionCtrl(){
    return new sessionCtrl();
  }

  function getGestioPeriodesAbsenciaCtrl(){
    return new gestioPeriodesAbsenciaCtrl();
  }

  function hola(){
    return "hola";
  }

}

?>
