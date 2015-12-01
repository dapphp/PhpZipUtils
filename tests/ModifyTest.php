<?php

require_once '../src/ZipFile.php';

use Dapphp\PhpZipUtils\ZipFile;

$archive = '../files/test.zip';

set_time_limit(10);

$zip = new ZipFile();
if ($zip->open($archive, ZipFile::OVERWRITE)) {
    $zip->addFromString(
        'added.txt',
        "I got added from a string of text, not a real file on the system.\n" .
        str_repeat("aaaaaaaaaaaaaaaabbbbbbbbbbbbbbbbcccccccccccccccc\n", 100));

    $zip->deleteName('test/notempty/packsi.sh');
    $zip->deleteName('test/empty');

    $zip->addFile('test.c');

    if (!$zip->close()) {
        echo "Failed to close zip file.\n";
        var_dump($zip->getErrorStatus());
    }
} else {
    echo "Couldn't open file\n";
}
