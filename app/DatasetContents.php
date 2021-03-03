<?php

class DatasetContents
{
    private $rawDps6;
    private $t;

    public function __construct(stdClass $o)
    {
        $this->rawDps6 = $o->rawDps6;
        $this->t = $o->t;
    }

    public function getRawDps6(): string
    {
        return $this->rawDps6;
    }

    public function getT(): string
    {
        return $this->t;
    }
}

?>