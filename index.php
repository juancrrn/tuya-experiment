<?php

require_once __DIR__ . '/../config.php';

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">

		<title>Tuya Smart WiFi meter data decoding experiment</title>
	</head>
	<body>
		<nav class="navbar navbar-light bg-light shadow-sm">
  			<span class="navbar-brand mb-0 h1">Tuya Smart WiFi meter data decoding experiment</span>
		</nav>

		<?php
		
include __DIR__ . '/templates/dataWeAreLookingFor.php';

include __DIR__ . '/templates/aboutTheFollowingTables.php';

include __DIR__ . '/templates/experimentExecution.php';

include __DIR__ . '/templates/statistics.php';
		
		?>

		<div class="my-5">
			<p class="text-center">Made with ❤ by <a href="https://juancrrn.io" target="_blank">Juan Carrión</a></p>
		</div>
		
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>