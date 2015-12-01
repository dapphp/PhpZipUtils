<?php

namespace Dapphp\PhpZipUtils;

class ZipFileEntry {
    /**
     * The full path and name of the entry in the archive
     *
     * @var string
     */
    public $filename;


    /**
     * The stored CRC32 from the archive in hex format
     *
     * @var string
     */
    public $crc;

    /**
     * The uncompressed size of the file
     *
     * @var int
     */
    public $size;

    /**
     * The compressed size of the file
     *
     * @var int
     */
    public $csize;

    /**
     * Any error encountered while processing the file
     *
     * @var int
     */
    public $error;

    /**
     * Description of the file error code
     *
     * @var string
     */
    public $errorMessage;

    /**
     * The decompressed file data
     *
     * @var string
     */
    public $data;

    /**
     * The name of the file in the archive (minus path)
     *
     * @var string
     */
    public $name;

    /**
     * The path of the file in the archive
     *
     * @var string
     */
    public $path;

    /**
     * Is the entry a directory, or a file
     */
    public $is_directory;

    /**
     * Unix timestamp of file modification
     *
     * @var int
     */
    public $timestamp;

    /**
     * DOS file modification date
     *
     * @var int
     */
    public $date;

    /**
     * DOS file modification time
     *
     * @var int
     */
    public $time;

    /**
     * File comment
     *
     * @var string
     */
    public $comment;

    public function __construct()
    {
        $this->filename = '';
        $this->comment = null;
        $this->crc = '';
        $this->size = 0;
        $this->csize = 0;
        $this->compression_ratio = 0;
        $this->error = ZipFile::ER_OK;
        $this->errorMessage = '';
        $this->data = '';
        $this->name = '';
        $this->path = '';
        $this->is_directory = false;
        $this->date = 0;
        $this->time = 0;
        $this->timestamp = 0;
    }

    public function getCompressionRatio()
    {
        if ($this->size == 0) {
            return 0;
        } else {
            return round(100 - (($this->csize / $this->size) * 100), 0);
        }
    }

    public static function consoleBanner()
    {
        $format = "%8s  %8s  %4s  %10s  %8s  %8s  %4s\n";
        $banner = sprintf($format,
                          "Size", "CSize", "Cmpr", "Date", "Time", "CRC32", "Name");
        $banner .= sprintf($format,
                           '--------', '--------', '----', '----------', '--------', '--------', '----');

        return $banner;
    }

    public function __toString()
    {
        return sprintf("%8d  %8d  %3d%%  %4s  %s  %08x  %s\n%s",
                        $this->size,
                        $this->csize,
                        $this->getCompressionRatio(),
                        date('Y-m-d', $this->timestamp),
                        date('H:i:s', $this->timestamp),
                        $this->crc,
                        $this->filename,
                        (!empty($this->comment) ? $this->comment . "\n" : ''));
    }
}
