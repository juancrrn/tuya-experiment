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
	</body>
</html>