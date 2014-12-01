<?php
class parser{
  // TODO: we should prevent SQL injection here, maybe. Or maybe in the data layer


  /**
  * Parses any variable to json
  */
  function toJson($variable){
    return json_encode($variable);
  }

  /*
  * Decodes a json encoded string and returns its value into an array
  */
  function jsonToArray($json){
    $array = json_decode($json);
    return $array;
  }
}
?>
