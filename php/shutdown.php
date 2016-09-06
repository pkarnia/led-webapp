<?php

require_once 'functions.php';

$redis = redisConnection();
if($_POST[shutdown] == "yes")
{
  $redis->PUBLISH("changes", "@");
}
?>
