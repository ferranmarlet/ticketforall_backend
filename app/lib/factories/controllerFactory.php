<?php

require '../app/lib/controllers/sessionCtrl.php';
require '../app/lib/controllers/gestioPeriodesAbsenciaCtrl.php';
require '../app/lib/controllers/consultarCodiDiariCtrl.php';

class controllerFactory{
  function __construct(){
  }

  function getSessionCtrl(){
    return new sessionCtrl();
  }

  function getGestioPeriodesAbsenciaCtrl(){
    return new gestioPeriodesAbsenciaCtrl();
  }

  function getConsultarCodiDiariCtrl(){
    return new consultarCodiDiariCtrl();
  }

  function hola(){
    return "hola";
  }

}

?>
