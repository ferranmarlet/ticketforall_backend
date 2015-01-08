<?php

class gestioPeriodesAbsenciaCtrl {
  private $app;

  function crearPeriode($startDate,$endDate,$username){
    $this->app = \Slim\Slim::getInstance();

    $periodEntity = $this->app->entityFactory->getPeriodEntity();

    return $periodEntity->createPeriod($startDate,$endDate,$username);
  }

  function consultarPeriodes($user_token){
    $this->app = \Slim\Slim::getInstance();

    $periodEntity = $this->app->entityFactory->getPeriodEntity();

    return $periodEntity->getAll($user_token);

  }

  function updatePeriode($id,$startdate,$enddate,$user_token) {
    $this->app = \Slim\Slim::getInstance();

    $periodEntity = $this->app->entityFactory->getPeriodEntity();

    return $periodEntity->updatePeriod($id,$startdate,$enddate,$user_token);
  }

  function eliminarPeriode($id,$user_token) {
    $this->app = \Slim\Slim::getInstance();

    $periodEntity = $this->app->entityFactory->getPeriodEntity();

    return $periodEntity->deletePeriod($id,$user_token);
  }
}

?>
