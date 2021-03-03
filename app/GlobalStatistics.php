<?php

require_once __DIR__ . '/Occurence.php';

/**
 * Global statistics data storage class.
 */
class GlobalStatistics
{
    /**
     * @var int   $differenceCharRuns
     * @var int   $searchRuns
     * @var int   $searchMatchesN
     * @var array $searchOccurencesMap Occurences map (as in: [[$startingPosition, $length, $count], ...])
     */
    private $differenceCharRuns;
    private $searchRuns;
    private $searchMatchesN;
    private $searchOccurencesMap;

    public function __construct()
    {
        $this->differenceCharRuns = 0;
        $this->searchRuns = 0;
        $this->searchMatchesN = 0;
        $this->searchOccurencesMap = array();
    }

    public function differenceCharRunsPlus(): void
    {
        $this->differenceCharRuns++;
    }

    public function searchRunsPlus(): void
    {
        $this->searchRuns++;
    }

    public function searchMatchesNPlus(): void
    {
        $this->searchMatchesN++;
    }

    public function addSearchOccurence(int $char, int $length): void
    {
        $this->searchMatchesNPlus();
        $this->setSearchOccurencesMap(Occurence::addToArray($char, $length, $this->getSearchOccurencesMap()));
    }

    public function getSearchOccurencesMap(): array
    {
        return $this->searchOccurencesMap;
    }

    public function setSearchOccurencesMap(array $searchOccurencesMap): void
    {
        $this->searchOccurencesMap = $searchOccurencesMap;
    }

    public function getDifferenceCharRuns(): int
    {
        return $this->differenceCharRuns;
    }

    public function getSearchRuns(): int
    {
        return $this->searchRuns;
    }

    public function getSearchMatchesN(): int
    {
        return $this->searchMatchesN;
    }
}

?>