<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(15);

require_once '../src/ZipFile.php';

use Dapphp\PhpZipUtils\ZipFile;
use Dapphp\PhpZipUtils\ZipFileEntry;

$archive_password = 'password23232';
$files_path       = dirname(__FILE__) . '/../files/';
$file_names       = array(
    0 => 'zip-winzip.zip',
    1 => 'zip-winzip-encrypted.zip',
    2 => 'zip-winrar.zip',
    3 => 'zip-winrar-encrypted.zip',
    4 => 'zip-infozip-3.0.zip',
    5 => 'zip-infozip-3.0-encrypted.zip',
    6 => 'zip-engrampa.zip',
    7 => 'zip-engrampa-encrypted.zip',
    //8 => 'test-aes.zip',  // TODO: AES
    9 => 'test-encrypted.zip',

);

$file = $files_path . $file_names[0];

$zip = new ZipFile();

$zip->setOverwriteExisting(true);
$zip->setArchivePassword($archive_password);

$tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'zip_test';

echo "Extracting files to $tmpDir\n\n";

`rm -rf $tmpDir/*`;

if ($zip->open($file)) {
    $zip->extractTo($tmpDir);

    echo ZipFileEntry::consoleBanner();

    foreach($zip->getFiles() as $file) {
        echo $file;

        if ($zip->getStatusCode() != ZipFile::ER_OK) {
            echo 'Error: ' . $zip->getStatusString() . "\n";
        }
        //echo $file->data . "\n\n";
    }
} else {
    echo sprintf("Failed to open zip file. Error %d: %s\n",
        $zip->getStatusCode(), $zip->getStatusString());
}
