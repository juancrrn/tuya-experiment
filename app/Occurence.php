<?php

class Occurence
{
	public $startPosition;
	public $length;
	public $nOccurences;

	function __construct(
		$startPosition,
		$length,
		$nOccurences
	) {
		$this->startPosition = $startPosition;
		$this->length = $length;
		$this->nOccurences = $nOccurences;
	}

    public static function searchInArray(int $j, int $l, array $occurences)/*: int|false*/
    {
        foreach ($occurences as $occurence) {
            if ($occurence->startPosition == $j && $occurence->length == $l) {
                return $occurence;
            }
        }
    
        /*return array_filter(
            $occurences,
            function ()
        );*/
    }

    /* Contar ocurrencias de match según $i y $l (posición inicial y longitud) */
    public static function addToArray(int $j, int $l, array $occurences)
    {
        $occurence = self::searchInArray($j, $l, $occurences);

        if ($occurence) {
            $occurence->nOccurences++;
        } else {
            $occurences[] = new self($j, $l, 1);
        }

        return $occurences;
    }
}

?>