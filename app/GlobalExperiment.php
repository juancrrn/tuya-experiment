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
    private $globalStatistics;
    private $changingColumns;

    private const DATASET_PATH = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'datasets' . DIRECTORY_SEPARATOR;
    
    public function __construct(
        string $jsonDatasetFilename,
        GlobalStatistics $globalStatistics
    ) {
        $jsonDataset = json_decode(file_get_contents(self::DATASET_PATH . $jsonDatasetFilename));

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
        $regexLi = $withSearch ? '<li>Regular expression: <span class="details-regex">' . $regex . '</span></li>' : '';
        $minLengthLi = $withSearch ? '<li>Min. length: <span class="decimal-figure">' . $minLength . '</span></li>' : '';
        $maxLengthLi = $withSearch ? '<li>Max. length: <span class="decimal-figure">' . $maxLength . '</span></li>' : '';

        $appCapturesBuf = '<ol>';

        if (! empty($this->dataset->getAppCaptures())) {
            foreach ($this->dataset->getAppCaptures() as $cap) {
                $appCapturesBuf .= '<li>I = <span class="decimal-figure">' . $cap->getI() . '</span>, P = <span class="decimal-figure">' . $cap->getP() . '</span>, V = <span class="decimal-figure">' . $cap->getV() . '</span></li>';
            }
        }

        $appCapturesBuf .= '</ol>';

        $buf = <<< HTML
        <div id="execution-details" class="container mt-4 mb-3">
            <h5 class="mb-4"><a href="#execution-details" class="title-hash-link">#</a>Execution details</h5>
            <div class="row mb-3">
                <div class="col-md">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Dataset</h5>
                            <p class="card-text">
                                <ul>
                                    <li>Name: $datasetName</li>
                                    <li>Comment: $datasetComment</li>
                                    <li>Contents count: <span class="decimal-figure">$datasetCountContents</span></li>
                                    <li>
                                        App captures count: <span class="decimal-figure">$datasetCountAppCaptures</span>
                                        $appCapturesBuf
                                    </li>
                                </ul>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Settings</h5>
                            <p class="card-text">
                                <ul>
                                    <li>Character to binary function: <code>ord()</code>and <code>decbin()</code> with padding to 7 bits (<code>Utils::stringToBinaryA7()</code>)
                                    <li>Search enabled: $searchEnabled</li>
                                    $regexLi
                                    $minLengthLi
                                    $maxLengthLi
                                </ul>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <span id="execution-result"></span>
            <h5 class="mb-4"><a href="#execution-result" class="title-hash-link">#</a>Execution result</h5>
        </div>
        <div class="experiment-result-wrapper">
        HTML;

        return $buf;
    }

    private function generatePostInfo(): string
    {
        $buf = '';

        $buf = <<< HTML
        </div>
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

            $buf .= <<< HTML
            <div class="experiment-row">
            HTML;

            $buf .= $singleValueExperiment->processDifferences();

            if ($withSearch) {
                $buf .= $singleValueExperiment->processSearch($regex, $minLength, $maxLength);
            }

            $buf .= <<< HTML
            </div>
            HTML;

        }

        $buf .= $this->generatePostInfo();

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