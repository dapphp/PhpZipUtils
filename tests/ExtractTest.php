<?php

require_once '../src/ZipFile.php';

use Dapphp\PhpZipUtils\ZipFile;
use Dapphp\PhpZipUtils\ZipFileEntry;

$zipfile = '../files/test-withcomment.zip';
//$zipfile = '../files/big.zip';
//$zipfile = '../files/test.zip';
//$zipfile = '../files/write-encrypted.zip';
$zip     = new ZipFile();

if ($zip->open($zipfile)) {
//if ($zip->openFromString(file_get_contents($zipfile))) {
    if (!$zip->extractTo('/tmp/test')) {
        $error = $zip->getErrorStatus();
        echo "Extract failed: {$error[0]} - {$error[1]}\n";
    }

    echo "Peak memory usage: " . memory_get_peak_usage(true) . "\n\n";

    echo ZipFileEntry::consoleBanner();

    foreach($zip->getFiles() as $file) {
        //echo "Peak memory usage: " . memory_get_usage(true) . ' ' . memory_get_peak_usage(true) . "\n\n";

        if ($file->error != ZipFile::ER_OK) {
            echo "{$file->filename} had error {$file->error}: {$file->errorMessage}\n";
        } else {
            echo $file;
        }
    }

    //var_dump($zip->getCreatedDirectories(), $zip->getCreatedFiles());
} else {
    $error = $zip->getErrorStatus();
    echo sprintf("error: %d - %s\n", $error[0], $error[1]);
}

//echo "Peak memory usage: " . memory_get_peak_usage(true) . "\n\n";
