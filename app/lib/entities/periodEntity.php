<?php
class periodEntity{

  function createPeriod($startDate,$endDate,$username){
    try{
      if(!is_null($startDate) && !is_null($endDate) && !is_null($username)) {
        $parsedStartDate = date('d/m/y',strtotime($startDate));
        $parsedEndDate = date('d/m/y',strtotime($endDate));

        if($parsedStartDate <= $parsedEndDate) {
          $user = R::findOne('user','username = ?',array($username));

          if(!is_null($user)) {
            $samePeriodCount = R::count('period','startdate = ? and enddate = ? and user_id = ?',array($parsedStartDate,$parsedEndDate,$user->id));

            if($samePeriodCount == 0) {

              $period = R::dispense('period');
              $period->startdate = $parsedStartDate;
              $period->enddate = $parsedEndDate;
              $period->user_id = $user->id;

              $id = R::store($period);
              return true;
            }
          }
        }
      }

    }catch(Exception $e){
      return false;
    }
    return false;
  }



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
