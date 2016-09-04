<?php

require "predis/autoload.php";
Predis\Autoloader::register();
try {
    $redis = new Predis\Client(array(
        "scheme" => "tcp",
        "host" => "10.0.1.126",
        "port" => 6379));
    $redis->AUTH(columbian);
    echo "Successfully connected to Redis";
}
catch (Exception $e) {
    echo "Couldn't connected to Redis";
    echo $e->getMessage();
}

foreach($redis->KEYS("state/*") as $value)
{
echo "<option value=\"".$value."\">".$value."</option>\n";
}
?>
