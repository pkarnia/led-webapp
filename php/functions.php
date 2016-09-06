<?php

require_once '../predis/autoload.php';
Predis\Autoloader::register();

$GLOBALS[pubData] = "";
$GLOBALS[numBoards] = 1;

function redisConnection() {
  try {
    $redis = new Predis\Client(array(
        "scheme" => "tcp",
        "host" => "10.0.1.126",
        "port" => 6379));
    $redis->AUTH(columbian);
	
    if(is_string($temp = $redis->GET("curstate")))
    {
      $GLOBALS[curstate] = $temp;
    }
    else
    {
      $GLOBALS[curstate] = "state/default";
      error_log("No Saved State Found");
    }
    echo "Successfully connected to Redis";
  }
  catch (Exception $e) {
    echo "Couldn't connected to Redis";
    echo $e->getMessage();
  }
  return $redis;
}

?>
