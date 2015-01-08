<?php
class couponEntity{

  function getCode($token) {
    try{

      $user = R::findOne('user',' token = ? ', array($token));

      if(!is_null($user)) {

        $today = date('Y-m-d',strtotime('today'));

        $coupon = R::findOne('coupon',' user_id = ? and datevalid = ? and used = 0 ', array($user->id,$today));

        if(is_null($coupon)) {
          //If it doesn't exists but there is a current absence period, we create the coupon.
          // TODO: It should use the userEntity

          $currentPeriod = R::findOne('period','startdate <= ? and enddate >= ? and user_id = ?',array($today,$today,$user->id));

          if(!is_null($currentPeriod)) {
            $coupon = R::dispense('coupon');
            $coupon->code = $this->randomToken(8, false, false, false, array('0', '1', '2','3', '4', '5','6', '7', '8','9'));
            $coupon->user_id = $user->id;
            $coupon->period_id = $currentPeriod->id;
            $coupon->used = 0;
            R::store($coupon);

            return $coupon->code;
          }

        } else {
          return $coupon->code;
        }
      }
    } catch(Exception $e) {
      return false;
    }
    return false;
  }

  //private function randomToken($len = 8, $output = 5, $standardChars = false, $specialChars = false, $chars = array('0123456789')) {
  private function randomToken($len = 8, $output = 5, $standardChars = true, $specialChars = false, $chars = array()) {
        $out = '';
        $len = intval($len);
        $outputMap = array(1 => 2, 2 => 8, 3 => 10, 4=> 16, 5 => 10);
        if (!is_array($chars)) { $chars = array_unique(str_split($chars)); }
        if ($standardChars) { $chars = array_merge($chars, range(48, 57),range(65, 90), range(97, 122)); }
        if ($specialChars) { $chars = array_merge($chars, range(33, 47),range(58, 64), range(91, 96), range(123, 126)); }
        array_walk($chars, function(&$val) { if (!is_int($val)) { $val = ord($val); } });
        if (is_int($len)) {
            while ($len) {
                $tmp = ord(openssl_random_pseudo_bytes(1));
                if (in_array($tmp, $chars)) {
                    if (!$output || !in_array($output, range(1,5)) || $output == 3 || $output == 5) { $out .= ($output == 3) ? $tmp : chr($tmp);  }
                    else {
                        $based = base_convert($tmp, 10, $outputMap[$output]);
                        $out .= ((($output == 1) ? '00' : (($output == 4) ? '0x' : '')) . (($output == 2) ? sprintf('%03d', $based) : $based));
                    }
                    $len--;
                }
            }
        }
        return (empty($out)) ? false : $out;
    }

}
?>
