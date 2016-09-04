<?php
require "predis/autoload.php";
Predis\Autoloader::register();

// since we connect to default setting localhost
// and 6379 port there is no need for extra
// configuration. If not then you can specify the
// scheme, host and port to connect as an array
// to the constructor.
$numBoards = 2;
$pubData = "";

try {
    $redis = new Predis\Client(array(
        "scheme" => "tcp",
        "host" => "10.0.1.126",
        "port" => 6379));
    echo "Successfully connected to Redis";
}
catch (Exception $e) {
    echo "Couldn't connected to Redis";
    echo $e->getMessage();
}

$redis->AUTH(columbian);
$hash = $_POST[area];
$format = '%s';
$length = $redis->HLEN(sprintf($format, $hash));
$count = 0;
$channel = 0;
while($length > $count)
{
  $format = '%s';
  $level = $redis->HGET(sprintf($format, $hash), sprintf($format, $channel));
  if($level != "")
  {
    if($redis->HGET("state\default", sprintf($format, $channel)) != 0)
    {
      $level = 0;
    }
    $format = '%s';
    $redis->HSET("state\default", sprintf($format, $channel), $level);
    $format = '%s:%s';
    $pubData = $pubData . "," . sprintf($format, $channel, $level);
    $count++;
  }
  $channel++;
}
$redis->PUBLISH("changes", $pubData);

?>
