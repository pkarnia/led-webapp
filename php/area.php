<?php

require_once 'functions.php';

$redis = redisConnection();

$hash = $_POST[area];
$format = '%s';
$length = $redis->HLEN(sprintf($format, $hash));
$count = 0;
$channel = 0;
while($length > $count)
{
  $format = '%s';
  $level = $redis->HGET($hash, sprintf($format, $channel));
  if($level != "")
  {
    if($redis->HGET($curstate, sprintf($format, $channel)) != 0)
    {
      $level = 0;
    }
    $format = '%s';
    $redis->HSET($curstate, sprintf($format, $channel), $level);
    $format = '%s:%s';
    $pubData = $pubData . "," . sprintf($format, $channel, $level);
    $count++;
  }
  $channel++;
}
$redis->PUBLISH("changes", substr($pubData, 1));
?>
