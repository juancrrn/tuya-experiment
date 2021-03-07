<h4>Statistics</h4>

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