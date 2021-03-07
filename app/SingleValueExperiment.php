<?php

require_once __DIR__ . '/Utils.php';
require_once __DIR__ . '/GlobalStatistics.php';

/**
 * Wrapper for the processing of a single data value.
 */
class SingleValueExperiment
{
    /**
     * @var int              $experimentId
     * @var string           $currentValue
     * @var string           $lastValue
     * @var array            $changingColumns
     * @var GlobalStatistics $globalStatistics
     */
    private $experimentId;
    private $currentValue;
    private $lastValue;
    private $changingColumns;
    private $globalStatistics;

    public function __construct(
        int              $experimentId,
        string           $currentValue,
        /*string|null*/  $lastValue,
        /*array|null*/   $changingColumns,
        GlobalStatistics $globalStatistics
    ) {
        $this->experimentId = $experimentId;
        $this->currentValue = $currentValue;
        $this->lastValue = $lastValue;
        $this->changingColumns = $changingColumns;
        $this->globalStatistics = $globalStatistics;
    }

    /**
     * Processes a single data value and compares it to the previous one.
     */
    public function processDifferences(): string
    {
        /*
         * Convert the values to binary strings.
         */
        $currentBinValue = Utils::stringToBinaryA7($this->currentValue);
        $lastBinValue = Utils::stringToBinaryA7($this->lastValue);

        /*
         * Separate binary bits to an array.
         */
	    $currentBinChars = str_split($currentBinValue);
        $lastBinChars = str_split($lastBinValue);

        /*
         * Generate an output buffer.
         */

        $buf = '';

        $experimentId = $this->experimentId;
        $currentValue = $this->currentValue;

        $buf .= <<< HTML
        <div class="experiment-header">
            <span class="id">$experimentId</span>
            <span class="raw">$currentValue</span>
        </div>
        <div class="experiment-differences-body">
        HTML;

        /*
         *
         * Analysis: detect different bits.
         * 
         */

        /*
         * Loop through each character.
         */
        for ($char = 0; $char < count($currentBinChars); $char++) {

            $this->globalStatistics->differenceCharRunsPlus();

            if ($char < count($lastBinChars) && $lastBinChars[$char] != $currentBinChars[$char]) {
                /*
                 * If there is an element to compare to and they are different.
                 */
                $buf .= '<span class="std diff">' . $currentBinChars[$char] . '</span>';
            } elseif (in_array($char, $this->changingColumns)) {
                /*
                 * If the column changes in at least one position.
                 */
                $buf .= '<span class="std common">' . $currentBinChars[$char] . '</span>';
            } else {
                /*
                 * If the column does never change.
                 */
                $buf .= '<span class="std eqcol">' . $currentBinChars[$char] . '</span>';
            }
        }
    
        $buf .= <<< HTML
        </div>
        HTML;

        return $buf;
    }

    /**
     * Processes a search in a data value based in a regular expression.
     */
    public function processSearch(string $regex, int $minLength, int $maxLength): string
    {
        /*
         * Convert the value to a binary string.
         */
        $currentBinValue = Utils::stringToBinaryA7($this->currentValue);

        /*
         * Separate binary bits to an array.
         */
	    $currentBinChars = str_split($currentBinValue);

        /*
         * Generate an output buffer.
         */

        $buf = '';

        $experimentId = $this->experimentId;
        $currentValue = $this->currentValue;

        $buf .= <<< HTML
        <div class="experiment-search-body">
            <ul>
        HTML;

        /*
         *
         * Analysis: combine starting positions and lengths.
         * 
         */

        /*
         * Loop through each character as starting position.
         * Limit to total length minus the min length.
         */
        for ($char = 0; $char < count($currentBinChars) - $minLength; $char++) {

            /*
             * Shortcut: if the bit is 0, jump to the next starting position,
             * as leading 0 are non-significative.
             */
            if ($currentBinChars[$char] != '0') {
                /*
                 * Test different lengths, from min. to max. and not exceeding
                 * remaining bits.
                 */
                for ($length = $minLength; $length < (count($currentBinChars) - $char) && $length < $maxLength; $length++) {

                    $this->globalStatistics->searchRunsPlus();

                    /*
                     * Form a binary string.
                     */
                    $currentBinString = implode(array_slice($currentBinChars, $char, $length));
                    
                    /*
                     * Convert the binary string to decimal.
                     */
                    $currentDecimal = bindec($currentBinString);

                    /*
                     * Run the regular expression.
                     */
                    if (preg_match_all($regex, $currentDecimal, $matches)) {
                        $count = count($matches);

                        $buf .= <<< HTML
                        <li class="experiment-search-row">
                            <span class="test-ijl">[$experimentId, $char, $length]</span>
                            <span class="test-bin">$currentBinString</span>
                            <span class="test-dec">$currentDecimal</span>
                            <span class="test-result-yes">Pass ($count found)</span>
                        </li>
                        HTML;

                        $this->globalStatistics->addSearchOccurence($char, $length);
                    }
                }
            }
        }
    
        $buf .= <<< HTML
            </ul>
        </div>
        HTML;

        return $buf;
    }
}

?>