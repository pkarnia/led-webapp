<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">
<title>Columbian Models</title>
	<script type="text/javascript" src="js/jquery-2.0.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	<script src="js/jquery.ui.touch-punch.min.js"></script>
	<link type="text/css" href="css/ColumbianLED.css" rel="stylesheet">

</head>

<body>

<span class="flex-container">
  <div class="flex-section flex-2 nav"><a href="index.php">Home</a></div>
  <div class="flex-section flex-2 nav"><a href="floors.php">Floors</a></div>
  <div class="flex-section flex-2 nav"><a href="units.php">Units</a></div>
</span>

<div class="flex-container">
  <div class="flex-section flex-1">
    <button class="button all" value="allOn">All On</button>
  </div>
  <div class="flex-section flex-1">
    <button class="button all" value="allOff">All Off</button>
  </div>
</div>
<div class="flex-container">
  <div class="flex-section flex-1">
    <h3>Brightness</h3>
    <div style="width:95%; margin: 5px auto 5px auto;" id="slide1" class="ui-slider custom ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false"></div>
  </div>
</div>
<div class="flex-container">
  <div class="flex-section flex-1">
    <h3>Enter Area Number to<br>Turn On / Off</h3>
    <select id="areas" style="width:100%">
    <option value="">Select an Area to Toggle</option>
    <?php

    require_once 'predis/autoload.php';
    Predis\Autoloader::register();

    function redisConnection() {
      try
      {
        $redis = new Predis\Client(array(
        "scheme" => "tcp",
        "host" => "10.0.1.126",
        "port" => 6379));
        $redis->AUTH(columbian);
	
        if(is_string($temp = $redis->GET("curstate")))
        {
          $GLOBALS[curstate] = $temp;
        }
        else
        {
          $GLOBALS[curstate] = "state/default";
          error_log("No Saved State Found");
        }
        echo "Successfully connected to Redis";
      }
      catch (Exception $e) {
        echo "Couldn't connected to Redis";
        echo $e->getMessage();
      }
      return $redis;
    }
    $redis = redisConnection();

    foreach($redis->KEYS("area/*") as $value)
    {
      if($curstate != $value)
      {
        $echoData = "<option value=\"".$value."\">".substr($value, 5)."</option>";
        echo $echoData;

      }
    }

    ?>
    </select>
    <button class="button area">Toggle Area</button>
  </div>
  <div class="flex-section flex-1">
    <h3>Enter LED Position to<br>Turn On / Off</h3>
    <input class="text2" id="board" type="text" placeholder="Board Number">
    <input class="text2" id="led" type="text" placeholder="LED Number">
    <button class="button led">Toggle LED</button>
  </div>
</div>

<div class="flex-container">
  <div class="flex-section flex-1">
    <h3>Save Redis State</h3>
    <input class="text1" type="text" id="save" placeholder="File Name">
    <button class="button save">Save</button>
  </div>
  <div class="flex-section flex-1">
    <h3>Load Redis State</h3>
    <select id="states" style="width:100%">
    <?php

    $redis = redisConnection();

    $echoData = "<option value=\"".$curstate."\">".substr($curstate, 6)."</option>";
    echo $echoData;
    foreach($redis->KEYS("state/*") as $value)
    {
      if($curstate != $value)
      {
        $echoData = "<option value=\"".$value."\">".substr($value, 6)."</option>";
        echo $echoData;

      }
    }

    ?>
    </select>
    <button class="button load">Load</button>
  </div>
</div>

<footer>Copyright 2016 © Columbian Models</footer>

<script type="text/javascript">
$("document").ready(function(){
	$( "#slide1" ).slider({ min: 1, max: 100, animate: "slow", range: "min", value:[100], change: function( event, ui ) {updatePwr()} });
});
function updatePwr(){
	$.ajax({
  	type: 'POST',
  	url: 'php/levels.php',
  	data: {area:$("#areas").val(),board:$("#board").val(),led:$("#led").val(),level:$("#slide1").slider("value")},
	});
};
	</script>
<script type="text/javascript">
$(document).ready(function(){
  $(".all").click(function(){
    $.ajax({
    type: 'POST',
    url: 'php/all.php',
    data: {state:$(this).attr('value')},
    });
  });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $(".area").click(function(){
    $.ajax({
    type: 'POST',
    url: 'php/area.php',
    data: {area:$("#areas").val()},
    });
  });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $(".load").click(function(){
    $.ajax({
    type: 'POST',
    url: 'php/load.php',
    data: {redisState:$("#states").val()},
    });
  });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $(".led").click(function(){
    $.ajax({
    type: 'POST',
    url: 'php/led.php',
    data: {board:$("#board").val(),led:$("#led").val(),level:$("#slide1").slider("value")},
    });
  });
});
</script>

</body>

</html>
