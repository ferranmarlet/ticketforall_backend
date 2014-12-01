<?php
function getUser($api_token) {
  $user = R::findOne('user',' api_token = ? ', array($api_token));

  if($user->id != 0) {
    return $user;
  }else{
    return false;
  }
}
?>
