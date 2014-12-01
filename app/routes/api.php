<?php
/*
* Returns the api_token for the matching user, or false if there is none.
* Params: email and password
*/
$app->get('/users/login',function () use ($app) {
  /*$app->response->setStatus(400); //Http status code 400 means "Bad request"
  $app->response->headers->set('Content-Type', 'application/json');
  $app->response->setBody(json_encode(array('message'=>'The field id must pertain to a customer')));*/
  die();
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

?>
