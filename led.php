<?php
require "predis/autoload.php";
Predis\Autoloader::register();

// since we connect to default setting localhost
// and 6379 port there is no need for extra
// configuration. If not then you can specify the
// scheme, host and port to connect as an array
// to the constructor.
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

if($_POST[board] == "")
{
  exit;
}
else if($_POST[board] != "" && $_POST[led] == "")
{
  for($i = 0; $i < 8; $i++)
  {
    $channel = (($_POST[board]*8)+$i);
    $format = '%s';
    $temp = $redis->HGET("state/default", sprintf($format, $channel));
    if($temp > 0)
    {
      $temp = 0;
    }
    else
    {
      $temp = $_POST[level];
    }
    $redis->HSET("state/default", sprintf($format, $channel), $temp);
    $format = '%s:%s';
    $pubData = $pubData . "," . sprintf($format, $channel, $temp);
  }
}
else if($_POST[board] != "" && $_POST[led] != "")
{
    $channel = (($_POST[board]*8)+$_POST[led]);
    $format = '%s';
    $temp = $redis->HGET("state/default", sprintf($format, $channel));
    if($temp > 0)
    {
      $temp = 0;
    }
    else
    {
      $temp = $_POST[level];
    }
    $redis->HSET("state/default", sprintf($format, $channel), $temp);
    $format = '%s:%s';
    $pubData = $pubData . "," . sprintf($format, $channel, $temp);
}
$redis->PUBLISH("changes", $pubData);
?>
