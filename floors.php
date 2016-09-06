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
  <div class="flex-section flex-2 nav"><a href="units.php">Units</a></div>
  <div class="flex-section flex-2 nav"><a href="admin.php">Admin Tools</a></div>
</span>
<div class="flex-container"style="background:none">
<?php
  for($i = 1; $i < 21; $i++)
  {
    echo "<div class=\"flex-section flex-2 button-array\" button-array\"><button class=\"button\" value=\"".$i."\">Floor ".$i."</button></div>\n"; 
  }

?>
</div>
</body>

</html>
