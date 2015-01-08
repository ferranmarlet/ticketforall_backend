<?php


class sessionCtrl {
  private $app;

  function verifyUser($username,$token){
    $this->app = \Slim\Slim::getInstance();
    $userEntity = $this->app->entityFactory->getUserEntity();
    return $userEntity->verifyUser($username,$token);
  }

  function login($username,$password, &$loginToken, &$role) {
    $this->app = \Slim\Slim::getInstance();
    $userEntity = $this->app->entityFactory->getUserEntity();
    return $userEntity->login($username,$password,$loginToken,$role);
  }
}
?>
