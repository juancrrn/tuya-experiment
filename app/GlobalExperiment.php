<?php

require_once __DIR__ . '/Dataset.php';
require_once __DIR__ . '/SingleValueExperiment.php';
require_once __DIR__ . '/GlobalStatistics.php';

/**
 * Wrapper for the processing of multiple data values altogether.
 */
class GlobalExperiment
{
    /**
     * @var Dataset          $dataset
     * @var GlobalStatistics $globalStatistics
     * @var array            $changingColumns
     */
    private $dataset;
    private $changingColumns;
    
    public function __construct(
        string $jsonDatasetPath,
        GlobalStatistics $globalStatistics
    ) {
        $jsonDataset = json_decode(file_get_contents($jsonDatasetPath));

        $this->dataset = new Dataset($jsonDataset);

        $this->globalStatistics = $globalStatistics;
    }

    private function generatePreInfo(
        /*bool|null*/ $withSearch = false,
        /*string|*/   $regex = null,
        /*int|*/      $minLength = null,
        /*int|*/      $maxLength = null
    ): string
    {
        $datasetName = $this->dataset->getName();
        $datasetComment = $this->dataset->getComment();
        $datasetCountContents = $this->dataset->countContents();
        $datasetCountAppCaptures = $this->dataset->countAppCaptures();
        $searchEnabled = $withSearch ? 'yes' : 'no';
        $regexLi = $withSearch ? "<li>Regular expression: $regex</li>" : '';
        $minLengthLi = $withSearch ? "<li>Min. length: $minLength</li>" : '';
        $maxLengthLi = $withSearch ? "<li>Max. length: $maxLength</li>" : '';

        $appCapturesBuf = '<ol>';

        if (! empty($this->dataset->getAppCaptures())) {
            foreach ($this->dataset->getAppCaptures() as $cap) {
                $appCapturesBuf .= '<li>I = ' . $cap->getI() . ', P = ' . $cap->getP() . ', V = ' . $cap->getV() . ', </li>';
            }
        }

        $appCapturesBuf .= '</ol>';

        $buf = <<< HTML
        <p><strong>Execution details</strong></p>
        <ul>
            <li>
                Dataset
                <ul>
                    <li>Name: $datasetName</li>
                    <li>Comment: $datasetComment</li>
                    <li>Contents count: $datasetCountContents</li>
                    <li>App captures count: $datasetCountAppCaptures $appCapturesBuf</li>
                </ul>
            </li>
            <li>
                Settings
                <ul>
                    <li>Character to binary function: <code>ord()</code>and <code>decbin()</code> with padding to 7 bits (<code>Utils::stringToBinaryA7()</code>)
                    <li>Search enabled: $searchEnabled</li>
                    $regexLi
                    $minLengthLi
                    $maxLengthLi
                </ul>
            </li>
        </ul>
        HTML;

        return $buf;
    }

    /**
     * Processes the difference experiment using the dataset.
     */
    public function processDifferences(
        /*bool|null*/ $withSearch = false,
        /*string|*/   $regex = null,
        /*int|*/      $minLength = null,
        /*int|*/      $maxLength = null
    ): string
    {
        /*
         * Check parameters
         */
        if ($withSearch && (! $regex || ! $minLength || ! $maxLength)) {
            throw new InvalidArgumentException();
        }

        /*
         * Prepare changing columns.
         */
        $this->prepareChangingColumns();

        /*
         * Generate an output buffer.
         */
        $buf = '';

        $buf .= $this->generatePreInfo($withSearch, $regex, $minLength, $maxLength);

        $datasetContents = $this->dataset->getContents();

        /*
         * Loop through each observation.
         */
        for ($obs = 0; $obs < count($datasetContents); $obs++) {
            
            if ($obs == 0) {
                $lastValue = $datasetContents[count($datasetContents) - 1];
            } else {
                $lastValue = $datasetContents[$obs - 1];
            }

            $singleValueExperiment = new SingleValueExperiment(
                $obs + 1,
                $datasetContents[$obs]->getRawDps6(),
                $lastValue->getRawDps6(),
                $this->changingColumns,
                $this->globalStatistics
            );

            $buf .= $singleValueExperiment->processDifferences();

            if ($withSearch) {
                $buf .= $singleValueExperiment->processSearch($regex, $minLength, $maxLength);
            }

        }

        return $buf;
    }

    /**
     * Detects non-changing columns.
     * The result of this process is an array that stores the numbers of
     * columns that have at least one change in any value row.
     */
    private function prepareChangingColumns()
    {
        $this->changingColumns = array();

        $datasetContents = $this->dataset->getContents();

        /*
         * Loop through each observation and character.
         */
        for ($obs = 0; $obs < count($datasetContents); $obs++) {

            if ($obs == 0) {
                $lastValue = $datasetContents[count($datasetContents) - 1];
            } else {
                $lastValue = $datasetContents[$obs - 1];
            }
            /*
             * Convert the values to binary strings.
             */
            $currentBinValue = Utils::stringToBinaryA7($datasetContents[$obs]->getRawDps6());
            $lastBinValue = Utils::stringToBinaryA7($lastValue->getRawDps6());

            /*
             * Separate binary bits to an array.
             */
            $currentBinChars = str_split($currentBinValue);
            $lastBinChars = str_split($lastBinValue);

            for ($char = 0; $char < count($currentBinChars); $char++) {

                if ($char < count($lastBinChars) && $lastBinChars[$char] != $currentBinChars[$char]) {
                    /*
                    * If there is an element to compare to and they are different.
                    */
                    $this->changingColumns[] = $char;
                }
            }

        }
    }

    /**
     * Processes the search experiment using the dataset and a regular
     * expression.
     */
    public function processSearch(string $regex, int $minLength, int $maxLength): string
    {
        /*
         * Generate an output buffer.
         */
        $buf = '';

        $datasetContents = $this->dataset->getContents();

        /*
         * Loop through each observation.
         */
        for ($obs = 0; $obs < count($datasetContents); $obs++) {

            $singleValueExperiment = new SingleValueExperiment(
                $obs + 1,
                $datasetContents[$obs]->getRawDps6(),
                null,
                null
            );

            $buf .= $singleValueExperiment->processSearch($regex, $minLength, $maxLength);

        }

        return $buf;
    }
}

?>