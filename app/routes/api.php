<?php
/*
* Returns the api_token for the matching user, or false if there is none.
* Params: email and password
*/
$app->post('/api/users/login',function () use ($app) {

  $dto = $app->dto;
  $data = $dto->jsonToArray($app->request()->params()['data']);

  if(isset($data['username']) && !is_null($data['username']) && isset($data['password']) && !is_null($data['password'])){

    $controllerFactory = $app->controllerFactory;
    $sessionController = $controllerFactory->getSessionCtrl();

    $loginToken = '';
    $role = '';
    $loginResult = $sessionController->login($data['username'],$data['password'],$loginToken,$role);

    if($loginResult) {
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody($dto->toJson(array('result'=>'ok','token'=>$loginToken,'rol'=>$role)));
    }else{
      $app->response->setStatus(404); // Not found
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody($dto->toJson(array('result'=>'error','message'=>'user or password are incorrect')));
    }
  }else{
    $app->response->setStatus(400); //Http status code 400 means "Bad request"
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody($dto->toJson(array('result'=>'error','message'=>'email and password must be set')));
  }
});

/*
* Creates a new abscense period
* Params: user token, start_date, end_date
*/
$app->post('/api/periode_absencia/:token',function ($token) use ($app) {

  $dto = $app->dto;
  $data = $dto->jsonToArray($app->request()->params()['data']);

  $controllerFactory = $app->controllerFactory;
  // verify user token is valid and correlates to nomUsuari
  $sessionController = $controllerFactory->getSessionCtrl();
  $userIsValid = $sessionController->verifyUser($data['nomUsuari'],$token);

  if($userIsValid) {

    $gestioPeriodesAbsenciaCtrl = $controllerFactory->getGestioPeriodesAbsenciaCtrl();
    $result = $gestioPeriodesAbsenciaCtrl->crearPeriode($data['dataIni'],$data['dataFi'],$data['nomUsuari']);

    if($result){
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody($dto->toJson(array('result'=>'ok','message'=>'Period created')));
    }else{
      $app->response->setStatus(400); // Bad parameters
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody($dto->toJson(array('result'=>'error','message'=>'some error happened')));
    }
  } else {
    $app->response->setStatus(401); // Unauthorized
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody($dto->toJson(array('result'=>'error','message'=>'username or token not valid')));
  }
});

$app->get('/api/periode_absencia/:token',function ($token) use ($app) {

  $dto = $app->dto;

  $controllerFactory = $app->controllerFactory;
  $gestioPeriodesAbsenciaCtrl = $controllerFactory->getGestioPeriodesAbsenciaCtrl();
  $infoPeriodes = $gestioPeriodesAbsenciaCtrl->consultarPeriodes($token);

  if($infoPeriodes){
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody($dto->toJson($infoPeriodes));
  }
  else {
    $app->response->setStatus(400); // No hi han periodes
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody($dto->toJson(array('result'=>'error','message'=>'any period found')));
  }

});

$app->put('/api/periode_absencia/:token',function ($token) use ($app) {

  $dto = $app->dto;
  $data = $dto->jsonToArray($app->request()->params()['data']);

  $controllerFactory = $app->controllerFactory;
  $gestioPeriodesAbsenciaCtrl = $controllerFactory->getGestioPeriodesAbsenciaCtrl();

  $result = $gestioPeriodesAbsenciaCtrl->updatePeriode($data['id'],$data['dataIni'],$data['dataFi'],$token);
  if($result){
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody($dto->toJson(array('result'=>'ok','message'=>'Period updated')));
  }
  else {
      $app->response->setStatus(400); // No hi han periodes
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody($dto->toJson(array('result'=>'error','message'=>'any period found')));
  }

});

$app->delete('/api/periode_absencia/:token',function ($token) use ($app) {

  $dto = $app->dto;
  $data = $dto->jsonToArray($app->request()->params()['data']);

  $controllerFactory = $app->controllerFactory;
  $gestioPeriodesAbsenciaCtrl = $controllerFactory->getGestioPeriodesAbsenciaCtrl();
  $result = $gestioPeriodesAbsenciaCtrl->eliminarPeriode($data['id'],$token);

  if($result){
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody($dto->toJson(array('result'=>'ok','message'=>'Period deleted')));
  }
  else {
      $app->response->setStatus(400); // No hi han periodes
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody($dto->toJson(array('result'=>'error','message'=>'period not found or wrong user token')));
  }

});

$app->get('/api/codi_diari/:token',function ($token) use ($app) {

  $dto = $app->dto;

  $controllerFactory = $app->controllerFactory;
  $consultarCodiDiariCtrl = $controllerFactory->getConsultarCodiDiariCtrl();

  $codi = $consultarCodiDiariCtrl->consultarCupo($token);
  if($codi){
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody($dto->toJson(array('result'=>'ok',"code"=>$codi)));
  }
  else {
      $app->response->setStatus(404);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody($dto->toJson(array('result'=>'error','message'=>'coupon not found or already used')));
  }

});

?>
