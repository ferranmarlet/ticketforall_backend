<?php

class gestioPeriodesAbsenciaCtrl {
  private $app;

  function crearPeriode($startDate,$endDate,$username){
    $this->app = \Slim\Slim::getInstance();

    $periodEntity = $this->app->entityFactory->getPeriodEntity();

    return $periodEntity->createPeriod($startDate,$endDate,$username);
  }

  function hola(){
    return "hola";
  }
}

?>
