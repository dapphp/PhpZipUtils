<?php

require_once '../src/ZipFile.php';

use Dapphp\PhpZipUtils\ZipFile;
use Dapphp\PhpZipUtils\ZipFileEntry;

$archive_password = 'password23232';
$files_path       = dirname(__FILE__) . '/../files/';
$file             = $files_path . '/test.zip';

$zip = new ZipFile();
$zip->setArchivePassword($archive_password);

if ($zip->open($file)) {
    $data = $zip->getFromName('test/notempty/packsi.sh');

    var_dump($data);

    echo ZipFileEntry::consoleBanner();

    foreach($zip->getFiles() as $file) {
        echo $file;

        if ($zip->getStatusCode() != ZipFile::ER_OK) {
            echo 'Error: ' . $zip->getStatusString() . "\n";
        }
    }
} else {
    echo sprintf("Failed to open zip file. Error %d: %s\n",
            $zip->getStatusCode(), $zip->getStatusString());
}
