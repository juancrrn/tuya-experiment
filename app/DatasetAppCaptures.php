<?php

class DatasetAppCaptures
{
    public $i;
    public $p;
    public $v;

    public function __construct(stdClass $o)
    {
        $this->i = $o->i;
        $this->p = $o->p;
        $this->v = $o->v;
    }

    public function getI(): float
    {
        return $this->i;
    }

    public function getP(): float
    {
        return $this->p;
    }

    public function getV(): float
    {
        return $this->v;
    }

}

?>