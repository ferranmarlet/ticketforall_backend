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

    $message = $sessionController->hola();
    $app->response->setStatus(200);
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody(json_encode(array('result'=>'ok','token'=>$message)));



    $loginToken = $sessionController->login($data['email'],$data['password']);

    if($loginToken) {
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode(array('token'=>$loginToken)));
    }else{
      $app->response->setStatus(404); // Not found
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode(array('result'=>'error','message'=>'user not found')));
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

  $jsonData = $app->request()->params();

  //Here we should use the Slim container to obtain a singleton instance of the dto
  $data = $dto->jsonToArray($jsonData);

  if(isset($token) and isset($data['start_date']) and isset($data['end_date'])) {

    // TODO: instantiate controller. Ask controller to link this layer and the data layer
    // TODO: get sessionCtrl through slim container





    $period_creation_result = $snewPeriodCtrl->createPeriod($user_id,$data['start_date'],$data['end_date']);

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
?>
