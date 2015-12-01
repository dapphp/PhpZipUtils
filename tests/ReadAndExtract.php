<?php

// Test script for reading & extracing zip files created by various programs
// Tests reading files from memory and disk
// Tests using both a 4k read buffer size and no read buffer
// Also tests extracting each zip file to a temp directory

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../src/ZipFile.php';

use Dapphp\PhpZipUtils\ZipFile;
use Dapphp\PhpZipUtils\ZipFileEntry;

$filepath = '../files/'; // directory with test files
$password = 'password1'; // password for encrypted files

$zipfiles = array(       // list of files for testing
    0 => 'zip-winzip.zip',
    1 => 'zip-winzip-encrypted.zip',
    2 => 'zip-winrar.zip',
    3 => 'zip-winrar-encrypted.zip',
    4 => 'zip-infozip-3.0.zip',
    5 => 'zip-infozip-3.0-encrypted.zip',
    6 => 'zip-engrampa.zip',
    7 => 'zip-engrampa-encrypted.zip',
    8 => 'test-aes.zip',
    9 => 'test-encrypted.zip',
);

$outPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'zip_tests';

foreach ($zipfiles as $zipfile) {
    for ($i = 0; $i < 4; $i++) {
        $zip = new ZipFile();
        $zip->setArchivePassword($password);
        $zip->setOverwriteExisting(true);
        $source = 'disk';

        if ($i % 2 == 0) {
            $zip->setReadBufferSize(0);
        } else {
            $zip->setReadBufferSize(4096);
        }

        if ($i < 2 == 0) {
            $source = 'string';
            $open = $zip->openFromString(file_get_contents($filepath . $zipfile));
        } else {
            $open = $zip->open($filepath . $zipfile);
        }

        printf("Opening %s from %s, buffer size = %s\n", $zipfile, $source, $zip->getReadBufferSize());

        if ($open) {
            $t0 = microtime(true);

            if (!$zip->extractTo($outPath)) {
                $error = $zip->getErrorStatus();
                echo "Extract to error {$error[0]}: {$error[1]}\n";
            } else {
                $t1 = microtime(true);

                echo "Processed file $zipfile in " . round($t1 - $t0, 4) . " seconds.\n\n";

                echo ZipFileEntry::consoleBanner();
                /* @var $file PhpZipUtils\ZipFileEntry */
                foreach($zip->getFiles() as $file) {
                    echo $file;
                }
            }
        } else {
            $error = $zip->getErrorStatus();
            echo "Failed to open $zipfile - {$error[0]}: {$error[1]}\n";
        }

        echo str_repeat('-', 80) . "\n\n";
    }
}
