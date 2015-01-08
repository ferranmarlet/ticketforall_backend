<?php
/*
* Returns the api_token for the matching user, or false if there is none.
* Params: email and password
*/
$app->post('/api/users/login',function () use ($app) {

  $dto = $app->dto;
  $data = $dto->jsonToArray($app->request()->params()['data']);

  if(isset($data['email']) && !is_null($data['email']) && isset($data['password']) && !is_null($data['password'])){

    $controllerFactory = $app->controllerFactory;
    $sessionController = $controllerFactory->getSessionCtrl();

    $loginToken = '';
    $role = '';
    $loginResult = $sessionController->login($data['email'],$data['password'],$loginToken,$role);

    if($loginResult) {
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode(array('result'=>'ok','token'=>$loginToken,'rol'=>$role)));
    }else{
      $app->response->setStatus(404); // Not found
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode(array('result'=>'error','message'=>'user or password are incorrect')));
    }
  }else{
    $app->response->setStatus(400); //Http status code 400 means "Bad request"
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody(json_encode(array('result'=>'error','message'=>'email and password must be set')));
  }
});

/*
* Return the daily code for the newspaper
* Params: user token
*/
$app->get('/api/code/:token',function ($token) use ($app) {

  $jsonData = $app->request()->params();

  //Here we should use the Slim container to obtain a singleton instance of the dto
  $data = $dto->jsonToArray($jsonData);

  if(isset($data['email']) and isset($data['password'])) {

    // TODO: instantiate controller. Ask controller to link this layer and the data layer
    // TODO: get sessionCtrl through slim container
    $loginResult = $sessionCtrl->login($data['email'],$data['password']);

    //TODO:
    //Here we should use the slim container to obtain the suscribed user entity
    $user = $userEntity->getUser($data);
    if($user->id != 0) {
      return $dto->toJson($user->api_token);

    } else {
      $app->response->setStatus(404);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode(array('message'=>'Customer not found')));
    }

  } else {

  }
});

/*
* Creates a new abscense period
* Params: user token, start_date, end_date
*/
$app->post('/api/periode_absencia/:token',function ($token) use ($app) {

  $dto = $app->dto;
  $data = $dto->jsonToArray($app->request()->params()['data']);

  //Here we should use the Slim container to obtain a singleton instance of the dto
  $data = $dto->jsonToArray($jsonData);

  $controllerFactory = $app->controllerFactory;
  $gestioPeriodesAbsenciaController = $controllerFactory->getGestioPeriodesAbsenciaCtrl();
  $return = $gestioPeriodesAbsenciaController->crearPeriode($data['dataIni'],$data['dataFi'],$data['nomUsuari']);
     if($return){
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode(array('result'=>'Ok','message'=>'Period created')));
    }else{
      $app->response->setStatus(400); // Bad parameters
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode(array('result'=>'error','message'=>'user not found')));
    }
});
$app->get('/api/periode_absencia/:token',function ($token) use ($app) {
  $dto = $app->dto;
  $data = $dto->jsonToArray($app->request()->params()['data']);
  $controllerFactory = $app->controllerFactory;
  $gestioPeriodesAbsenciaController = $controllerFactory->getGestioPeriodesAbsenciaCtrl();
  $infoPeriodes = $gestioPeriodesAbsenciaController->consultarPeriodes();
  if($infoPeriodes){
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode($infoPeriodes));
  }
  else {
    $app->response->setStatus(400); // No hi han periodes
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode(array('result'=>'error','message'=>'any period found')));
  }
 
});
$app->put('/api/periode_absencia/:token',function ($token) use ($app) {
  $dto = $app->dto;
  $data = $dto->jsonToArray($app->request()->params()['data']);
  $controllerFactory = $app->controllerFactory;
  $gestioPeriodesAbsenciaController = $controllerFactory->getGestioPeriodesAbsenciaCtrl();
  $string = $gestioPeriodesAbsenciaController->updatePeriode($data['dataIni'],$data['dataFi'],$data['nomUsuari']);
  if($string){
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode(array('result'=>'Ok','message'=>'Period updated')));
  }
  else {
      $app->response->setStatus(400); // No hi han periodes
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode(array('result'=>'error','message'=>'any period found')));
  }
 
});
$app->delete('/api/periode_absencia/:token',function ($token) use ($app) {
  $dto = $app->dto;
  $data = $dto->jsonToArray($app->request()->params()['data']);
  $controllerFactory = $app->controllerFactory;
  $gestioPeriodesAbsenciaController = $controllerFactory->getGestioPeriodesAbsenciaCtrl();
  $string = $gestioPeriodesAbsenciaController->eliminarPeriode($data['dataIni'],$data['dataFi'],$data['nomUsuari']);
  if($string){
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode(array('result'=>'Ok','message'=>'Period deleted')));
  }
  else {
      $app->response->setStatus(400); // No hi han periodes
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode(array('result'=>'error','message'=>'period not found')));
  }
 
});
$app->get('/api/diaris_bescanviats/:token',function ($token) use ($app) {
  $dto = $app->dto;
  $data = $dto->jsonToArray($app->request()->params()['data']);
  $controllerFactory = $app->controllerFactory;
  $consultarDiarisBescanviatsController = $controllerFactory->getConsultarDiarisBescanviatsCtrl();
  $infoDiarisBesc = $consultarDiarisBescanviatsController->obtenirDiarisBescanviats();
  if($infoDiarisBesc){
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode($infoDiarisBesc));
  }
  else {
      $app->response->setStatus(400); // No hi han diaris bescanviats
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode(array('result'=>'error','message'=>'any diari bescanviat found')));
  }
 
});
$app->get('/api/quioscos_propers/:token',function ($token) use ($app) {
  $dto = $app->dto;
  $data = $dto->jsonToArray($app->request()->params()['data']);
  $controllerFactory = $app->controllerFactory;
  $consultarQuioscosPropersController = $controllerFactory->getConsultarQuioscosPropersCtrl();
  $infoQuioscosProp = $consultarQuioscosPropersController->getQuioscosPropers();
  if($infoQuioscosProp){
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode($infoQuioscosProp));
  }
  else {
      $app->response->setStatus(400); // No hi han diaris bescanviats
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode(array('result'=>'error','message'=>'any Quiosc near found')));
  }
 
});
$app->get('/api/codi_diari/:token',function ($token) use ($app) {
  $dto = $app->dto;
  $data = $dto->jsonToArray($app->request()->params()['data']);
  $controllerFactory = $app->controllerFactory;
  $consultarCodiDiariController = $controllerFactory->getConsultarCodiDiariCtrl();
  $codi = $consultarCodiDiariController->consultarCupo();
  if($codi){
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode($codi));
  }
  else {
      $app->response->setStatus(400); // bad request   
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode(array('result'=>'error','message'=>'bad request')));
  }
 
});

?>
