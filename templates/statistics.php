<div class="container mt-4 mb-3">
    <h4 class="mb-3">Experiment result statistics</h4>

    <p>Execution completed.</p>

    <div class="row mb-3">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Difference experiment</h5>
                    <p class="card-text">
                        <ul>
                            <li>Tested chars count: <?php echo $globalStatistics->getDifferenceCharRuns(); ?>.</li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Search experiment</h5>
                    <p class="card-text">
                        <ul>
                            <li>Tested strings count: <?php echo $globalStatistics->getSearchRuns(); ?>.</li>
                            <li>Found matches count: <?php echo $globalStatistics->getSearchMatchesN(); ?>.</li>
                            <li>
                                Starting-position-length count:
                                <ul class="experiment-search-statistics">
                                    <?php

foreach ($globalStatistics->getSearchOccurencesMap() as $occurence) {

echo '<li class="occurence-row"><span class="occurence-jl">[i, ' . $occurence->startPosition . ', ' . $occurence->length . ']</span><span class="occurence-n">' . $occurence->nOccurences . '</span></li>';

}

                                    ?>
                                </ul>
                            </li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>