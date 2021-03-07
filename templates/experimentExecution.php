<?php

$globalStatistics = new GlobalStatistics();

$experiment = new GlobalExperiment(
	'D:\dprogramfiles64\Wamp\www\tuya-experiment\datasets\dataset7.json',
	$globalStatistics
);

?>
<div class="container mt-4 mb-3">
	<h4>Execution</h4>
</div>
<?php

echo $experiment->processDifferences(true, Utils::REGEX_RAW_DATA_7_POWER, 8, 63, $globalStatistics);

?>