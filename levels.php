<?php

include 'functions.php';

$redis = redisConnection();

$level = $_POST[level];
$board = $_POST[board];
$led = $_POST[led];
$area = $_POST[area];

if($board == "" && $area == "")
{
  for($k = 0; $k < $numBoards; $k++)
  {
  for($i = 0; $i < 8; $i++)
  {
    $channel = (($k*8)+$i);
    $format = '%s';
    $redis->HSET($curstate, sprintf($format, $channel), $level);
    $format = '%s:%s';
    $pubData = $pubData . "," . sprintf($format, $channel, $level);
  } 
  }
}
else if($board != "" && $led == "" && $area == "")
{
  for($i = 0; $i < 8; $i++)
  {
    $channel = (($board*8)+$i);
    $format = '%s';
    $redis->HSET($curstate, sprintf($format, $channel), $level);
    $format = '%s:%s';
    $pubData = $pubData . "," . sprintf($format, $channel, $level);
  } 
}
else if($board != "" && $led != "" && $area =="")
{
    $channel = (($board*8)+$led);
    $format = '%s';
    $redis->HSET($curstate, sprintf($format, $channel), $level);
    $format = '%s:%s';
    $pubData = $pubData . "," . sprintf($format, $channel, $level);
}
else if($area != "" && $board == "" && $led == "")
{
$percent = $level / 100;
$hash = $area;
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
    $level = ceil($percent * $level);
    $format = '%s';
    $redis->HSET($curstate, sprintf($format, $channel), $level);
    $format = '%s:%s';
    $pubData = $pubData . "," . sprintf($format, $channel, $level);
    $count++;
  }
  $channel++;
}
}

$redis->PUBLISH("changes", substr($pubData, 1));

?>
