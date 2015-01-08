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

  function verifyUser($username,$token){
    $user = R::findOne('user','username = ? and token = ?',array($username,$token));

    if(!is_null($user)) {
      return true;
    } else {
      return false;
    }
  }

  function login($username, $password, &$loginToken, &$role){
      $user = R::findOne('user',' username = ? and password = ? ', array($username, $password));

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
