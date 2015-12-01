<?php

namespace Dapphp\PhpZipUtils;

class ZipFileIterator implements \Iterator
{
    private $zipfile;
    private $centraldirectory;
    private $position;

    public function __construct(ZipFile $zip, ZipCentralDirectory $cd)
    {
        $this->zipfile = $zip;
        $this->centraldirectory = $cd;
        $this->position = 0;
    }

    function rewind()
    {
        $this->position = 0;
    }

    function current()
    {
        $cdent = $this->centraldirectory->getEntryIndex($this->position);

        /* @var $file ZipDirectoryEntry */
        $file = $this->zipfile->getFromIndex($this->position);
        $file->comment = $cdent->comment;

        return $file;
    }

    function key()
    {
        return $this->position;
    }

    function next()
    {
        ++$this->position;
    }

    function valid()
    {
        return ($this->centraldirectory->getEntryIndex($this->position) !== false);
    }
}
