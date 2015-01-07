<?php
/*
* Returns the api_token for the matching user, or false if there is none.
* Params: email and password
*/
$app->post('/api/users/login',function () use ($app) {

  $data = $app->request()->params();

  if(isset($data['email']) && !is_null($data['email'])){
    $app->response->setStatus(200); //Http status code 400 means "Bad request"
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody(json_encode(array('message'=>'hola')));
  }else{
    $app->response->setStatus(400); //Http status code 400 means "Bad request"
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody(json_encode(array('message'=>'The field id must pertain to a customer')));
  }


  /*$jsonData = $app->request()->params();

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

  }*/
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
$app->get('/api/periode_absencia/:token',function ($token) use ($app) {
  $jsonData = $app->request()->params();
  $user = R::findOne('user','token='.$token);
  if($user->id != 0) {
      return $dto->toJson($user->api_token);

    } else {
      $app->response->setStatus(404);
      $app->response->headers->set('Content-Type', 'application/json');
      $app->response->setBody(json_encode(array('message'=>'Customer not found')));
    }

});
?>
