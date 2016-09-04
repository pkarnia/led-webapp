<?php

require_once 'functions.php';

$redis = redisConnection();
global $pubData;
global $numBoards;

if($_POST[state] == "allOn")
    $level = 100;
else if($_POST[state] == "allOff")
    $level = 0;
else
    exit;
for($k = 0; $k < $numBoards; $k++)
{
  for($i = 0; $i < 8; $i++)
  {
    $channel = (($k*8)+$i);
    $format = '%s';
    $redis->HSET($curstate, sprintf($format, $channel),$level);
    $format = '%s:%s';
    $pubData = $pubData . "," . sprintf($format, $channel, $level);
  }
}

$redis->PUBLISH("changes", substr($pubData, 1));

?>
