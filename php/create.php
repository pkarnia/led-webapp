<?php

require_once 'functions.php';
$redis = redisConnection();

$format = '%s/%s';
$redis->HSET(sprintf($format, "state", $_POST['hash']), "0", 0);

?>
