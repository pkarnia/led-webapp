<?php
header("Content-Type: application/json");
require_once 'functions.php';
$redis = redisConnection(1);

if(is_string($temp = $redis->GET("curstate")))
{
	$cs = $temp;
}
else
{
	$cs = "state/default";
	error_log("No Saved State Found");
}

$js = array("curstate"=>$cs, "states"=>array());
foreach($redis->KEYS("state/*") as $value)
{
	array_push($js['states'],array("statename" => $value, "dispname" => substr($value, 6)));
}
echo(json_encode($js));
?>
