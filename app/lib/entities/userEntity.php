<?php
class userEntity{
  function getUser($api_token) {
    $user = R::findOne('user',' api_token = ? ', array($api_token));

    if(!is_null($user)) {
      return $user->export();
    }else{
      return false;
    }
  }

  function login($email, $password, &$loginToken, &$role){
      $user = R::findOne('user',' email = ? and password = ? ', array($email, $password));

      if(!is_null($user)) {
        $loginToken = $user->token;
        $role = $user->role;
        return true;
      }else{
        return false;
      }
  }
}
?>
