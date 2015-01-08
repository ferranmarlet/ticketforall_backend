<?php

class consultarCodiDiariCtrl {
  private $app;

  function consultarCupo($token){
    $this->app = \Slim\Slim::getInstance();

    $couponEntity = $this->app->entityFactory->getCouponEntity();

    return $couponEntity->getCode($token);
  }

  function hola(){
    return "hola";
  }
}

?>
