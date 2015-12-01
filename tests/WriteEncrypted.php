<?php

require_once '../src/ZipFile.php';

use Dapphp\PhpZipUtils\ZipFile;

$password = 'password1';

$zip = new ZipFile();

if ($zip->open('../files/write-encrypted.zip', ZipArchive::CREATE)) {
    $zip->setArchivePassword($password);

    $zip->addFromString(
        'file1.txt',
        "This is a file, it has data.  Lots of data.\n" .
        str_repeat(str_repeat('abc', 20) . str_repeat('def', 20) . str_repeat('xyz', 20) . "\n", 200)
    );

    $zip->addFile('../src/ZipFile.php', 'ZipFile.php');
    $zip->addFile('test.c');

    $zip->addEmptyDir('directory/');
    $zip->addFile('../composer.json', 'composer/composer.json');

    if (!$zip->close()) {
        echo sprintf("Failed to write file - %d: %s\n", $zip->getStatusCode(), $zip->getStatusString());
    }
} else {
    echo sprintf("Failed to open file for writing. Error %d: %s\n",
        $zip->getStatusCode(), $zip->getStatusString());
}
