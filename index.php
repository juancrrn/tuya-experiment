<?php

require_once __DIR__ . '/app/GlobalStatistics.php';
require_once __DIR__ . '/app/GlobalExperiment.php';
require_once __DIR__ . '/app/Utils.php';

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Tuya Smart WiFi meter data decoding experiment</title>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<h1>Tuya Smart WiFi meter data decoding experiment</h1>

		<?php include __DIR__ . '/templates/dataWeAreLookingFor.php'; ?>

		<p><strong>About the following tables</strong></p>

		<ul>
			<li><span class="std eqcol">1</span> (no color): the value never changes in the column.</li>
			<li><span class="std common">1</span> (gray): the value changes some time in the column.</li>
			<li><span class="std diff">1</span> (purple): the value is different to the one in the previous row.</li>
		</ul>
		<?php

$globalStatistics = new GlobalStatistics();

$experiment = new GlobalExperiment(
	'D:\dprogramfiles64\Wamp\www\tuya-experiment\datasets\dataset7.json',
	$globalStatistics
);

echo $experiment->processDifferences(true, Utils::REGEX_RAW_DATA_7_POWER, 8, 63, $globalStatistics);

		?>
		<p><strong>Statistics</strong></p>

		<ul>
			<li>Run complete.</li>
			<li>
				Difference experiment
				<ul>
					<li>Tested chars count: <?php echo $globalStatistics->getDifferenceCharRuns(); ?>.</li>
				</ul>
			</li>
			<li>
				Search experiment
				<ul>
					<li>Tested strings count: <?php echo $globalStatistics->getSearchRuns(); ?>.</li>
					<li>Found matches count: <?php echo $globalStatistics->getSearchMatchesN(); ?>.</li>
					<li>
						Starting-position-length count:
						<ul>
							<?php

foreach ($globalStatistics->getSearchOccurencesMap() as $occurence) {

	echo '<li class="occurence-row"><span class="occurence-jl">[i, ' . $occurence->startPosition . ', ' . $occurence->length . ']</span><span class="occurence-n">' . $occurence->nOccurences . '</span></li>';

}

							?>
						</ul>
					</li>
				</ul>
			</li>
		</ul>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>