<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../app/GlobalStatistics.php';
require_once __DIR__ . '/../app/GlobalExperiment.php';
require_once __DIR__ . '/../app/Utils.php';

$globalStatistics = new GlobalStatistics();

$experiment = new GlobalExperiment(
	TE_DATASET_FILENAME,
	$globalStatistics
);

?>
<div class="container mt-4 mb-3">
	<h4>Execution</h4>
</div>
<?php

echo $experiment->processDifferences(TE_SEARCH_ENABLE, TE_SEARCH_REGEX, TE_SEARCH_MIN_LENGTH, TE_SEARCH_MAX_LENGTH, $globalStatistics);

?>