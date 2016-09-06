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
<div class="flex-container">
  <div class="flex-section flex-2 nav"><a href="index.php">Home</a></div>
  <div class="flex-section flex-2 nav"><a href="floors.php">Floors</a></div>
  <div class="flex-section flex-2 nav"><a href="admin.php">Admin Tools</a></div>
</div>

<div class="flex-section"style="background:none">
<?php
  foreach(array(101,102,103,104,105,106,201,202,203,204,205,206,301,302,303,401,402,403,"Penthouse") as $value)
  {
    echo "<div class=\"flex-section flex-2 button-array\" button-array\"><button class=\"button\" value=\"".$value."\">Unit ".$value."</button></div>\n"; 
  }

?>
</div>
</body>

</html>
