<?php

namespace Dapphp\PhpZipUtils;

require_once 'ZipFileEntry.php';

use Dapphp\PhpZipUtils\ZipFileEntry;

class ZipDirectoryEntry extends ZipFileEntry
{
    const ZIP_ST_UNCHANGED = 0;
    const ZIP_ST_DELETED   = 1;
    const ZIP_ST_REPLACED  = 2;
    const ZIP_ST_ADDED     = 3;
    const ZIP_ST_RENAMED   = 4;

    public $versionMadeBy;
    public $versionNeeded;
    public $bitFlags;
    public $compressionMethod;
    public $lastMod;

    public $filenameLength;

    public $commentLength;

    public $diskNumber;

    public $internalAttributes;

    public $externalAttributes;

    public $offset;

    public $extraFieldLength;

    public $extraFieldData;

    public $state;

    public $cd_offset; // central directory offset

    public function __construct()
    {
        $this->versionMadeBy = 20;
        $this->versionNeeded = 20;
        $this->state = self::ZIP_ST_UNCHANGED;

        parent::__construct();
    }

    public function isEncrypted()
    {
        return ($this->bitFlags & ZipFile::ZIP_GPBF_ENCRYPTED) > 0;
    }

    public function toZipFileEntry()
    {
        $e = new ZipFileEntry();

        foreach($e as $prop => $val) {
            $e->$prop = $this->$prop;
        }

        return $e;
    }
}
