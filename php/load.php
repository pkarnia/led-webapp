<?php

require_once 'functions.php';

$redis = redisConnection();
global $pubData;
global $numBoards;
global $curstate;

$redis->SET("curstate", $_POST[redisState]);
$redis->PUBLISH("changes", "!");

?>
