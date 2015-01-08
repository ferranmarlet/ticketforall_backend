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

  function getAll($user_token) {

    $user = R::findOne('user',' token = ? ',array($user_token));

    if(!is_null($user)) {
      $periods = R::findAll('period',' user_id = ? ',array($user->id));
      return R::exportAll($periods);
    } else {
      return false;
    }
  }

  function updatePeriod($id,$startdate,$enddate,$user_token) {
    try {
      $user = R::findOne('user',' token = ? ',array($user_token));

      if(!is_null($user)) {

        $period = R::load('period',$id);

        if($period->id != 0)) {

          $parsedStartDate = date('d/m/y',strtotime($startdate));
          $parsedEndDate = date('d/m/y',strtotime($enddate));
          $period->startdate = $parsedStartDate;
          $period->enddate = $parsedEndDate;
          $result = R::store($period);

          return true;
        }
      }
    } catch (Exception $e) {
      return false;
    }
    return false;
  }

  function deletePeriod($id,$user_token) {
    try {
      $user = R::findOne('user',' token = ? ',array($user_token));

      if(!is_null($user)) {
        $period = R::load('period',$id);
        R::trash($period);

        return true;
      }
    } catch (Exception $e) {
      return false;
    }
    return false;
  }
}
?>
