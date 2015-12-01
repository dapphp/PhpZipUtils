<?php

namespace Dapphp\PhpZipUtils;

use Dapphp\PhpZipUtils\ZipDirectoryEntry;

class ZipCentralDirectory
{
    /**
     * Directory entries
     *
     * @var ZipDirectoryEntry
     */
    private $entry;

    /**
     * Number of entries
     *
     * @var int
     */
    private $numEntries;

    /**
     * Size of central directory
     *
     * @var int
     */
    private $size;

    /**
     * Offset of central directory
     *
     * @var int
     */
    private $offset;

    /**
     * Zip archive comment
     *
     * @var string
     */
    private $comment;

    public function __construct()
    {
        $this->entry   = array();
        $this->offset  = 0;
        $this->comment = '';
        $this->numEntries = 0;
    }

    public function addEntry($index, ZipDirectoryEntry $entry)
    {
        $this->entry[$index] = $entry;
        $this->numEntries++;
        return $this;
    }

    public function getEntryIndex($index)
    {
        if (isset($this->entry[$index])) {
            return $this->entry[$index];
        } else {
            return false;
        }
    }

    public function setNentry($nentry)
    {
        $this->numEntries = $nentry;
        return $this;
    }

    public function getNentry()
    {
        return $this->numEntries;
    }

    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getComment()
    {
        return $this->comment;
    }
}
