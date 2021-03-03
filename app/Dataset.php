<?php

require_once __DIR__ . '/DatasetContents.php';
require_once __DIR__ . '/DatasetAppCaptures.php';

class Dataset
{
    private $name;
    private $comment;
    private $contents;
    private $appCaptures;

    public function __construct(stdClass $jsonDataset)
    {
        if (property_exists($jsonDataset, 'setName')) {
            $this->name = $jsonDataset->setName;
        } else {
            $this->name = '';
        }

        if (property_exists($jsonDataset, 'setComment')) {
            $this->comment = $jsonDataset->setComment;
        } else {
            $this->comment = '';
        }

        $this->contents = array();

        if (property_exists($jsonDataset, 'setContents')) {
            if (is_array($jsonDataset->setContents)) {
                foreach ($jsonDataset->setContents as $row) {
                    $this->contents[] = new DatasetContents($row);
                }
            }
        }

        $this->appCaptures = array();

        if (property_exists($jsonDataset, 'setAppCaptures')) {
            if (is_array($jsonDataset->setAppCaptures)) {
                foreach ($jsonDataset->setAppCaptures as $row) {
                    $this->appCaptures[] = new DatasetAppCaptures($row);
                }
            }
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getContents(): array
    {
        return $this->contents;
    }

    public function countContents(): int
    {
        return count($this->getContents());
    }

    public function getAppCaptures(): array
    {
        return $this->appCaptures;
    }

    public function countAppCaptures(): int
    {
        return count($this->getAppCaptures());
    }
}

?>