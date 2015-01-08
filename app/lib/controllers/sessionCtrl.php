<?php


class sessionCtrl {
  private $app;

  function verifyUser($username,$token){
    $this->app = \Slim\Slim::getInstance();
    $userEntity = $this->app->entityFactory->getUserEntity();
    return $userEntity->verifyUser($username,$token);
  }

  function login($email,$password, &$loginToken, &$role) {
    $this->app = \Slim\Slim::getInstance();
    $userEntity = $this->app->entityFactory->getUserEntity();
    return $userEntity->login($email,$password,$loginToken,$role);
  }
  function hola(){
    return "hola";
  }
}
?>
