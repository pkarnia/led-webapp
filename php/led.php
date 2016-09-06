<?php
require_once 'functions.php';

$redis = redisConnection();
global $pubData;
global $numBoards;
global $curstate;

$level = $_POST[level];
$board = $_POST[board];
$led = $_POST[led];

if($board == "")
{
  exit;
}
else if($board != "" && $led == "")
{
  for($i = 0; $i < 8; $i++)
  {
    $channel = (($board*8)+$i);
    $format = '%s';
    $temp = $redis->HGET($curstate, sprintf($format, $channel));
    if($temp > 0)
    {
      $temp = 0;
    }
    else
    {
      $temp = $level;
    }
    $redis->HSET($curstate, sprintf($format, $channel), $temp);
    $format = '%s:%s';
    $pubData = $pubData . "," . sprintf($format, $channel, $temp);
  }
}
else if($board != "" && $led != "")
{
    $channel = (($board*8)+$led);
    $format = '%s';
    $temp = $redis->HGET($curstate, sprintf($format, $channel));
    if($temp > 0)
    {
      $temp = 0;
    }
    else
    {
      $temp = $level;
    }
    $redis->HSET($curstate, sprintf($format, $channel), $level);
    $format = '%s:%s';
    $pubData = $pubData . "," . sprintf($format, $channel, $level);
}
$redis->PUBLISH("changes", substr($pubData, 1));
?>
