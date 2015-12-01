<?php

// Tests writing a zip file by adding files from string data and disk files
// Sets a zip file comment and deletes a file entry after creating it

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../src/ZipFile.php';

use Dapphp\PhpZipUtils\ZipFile;

$archive = sys_get_temp_dir() . '/output.zip';
$zip     = new ZipFile();

if ($zip->open($archive, ZipFile::CREATE)) {
    $added = $zip->addFile('../files/test/winbox.exe', 'winbox.zip');
    var_dump($added);
    $added = $zip->addFile('../files/test/empty', 'empty');
    var_dump($added);
    $added = $zip->addFile('../doc/aes_info.htm', 'aes_info.htm');
    var_dump($added);
    $added = $zip->addFile('../doc/appnote.iz', 'appnote.iz');
    var_dump($added);
    $added = $zip->addFromString('add-from-string.txt', 'replace me!!!');
    var_dump($added);
    $added = $zip->addFromString('add-from-string.txt', 'This is a test file from a string.  It is not coming from the disk but rather from text passed to a function.  This is long enough...');
    var_dump($added);
    $added = $zip->setCommentName('add-from-string.txt', "This file is special and has a comment - THAT SAYS NOTHING ABOUT IT!");
    var_dump($added);

    $added = $zip->addEmptyDir('test/');
    var_dump($added);
    $added = $zip->addFromString('test/test.txt', 'hi there');
    var_dump($added);
    $temp  = file_get_contents(__FILE__);
    $data  = chunk_split(str_repeat('A', 4096), 80, "\n");
    $data .= chunk_split(str_repeat('Z', 4096), 80, "\n");
    $added = $zip->addFromString('test/data.txt', $temp . "\n\n" . $data);
    var_dump($added);

    $zip->addFromString('test/delete.txt', 'This will be deleted and not added to the archive.');
    $deleted = $zip->deleteName('test/delete.txt');
    var_dump($deleted);

    $zip->setArchiveComment("This is a zip file, zip files are cool.  Don't question it, accept it.");

    if (!$zip->close()) {
        echo "Failed to save - " . $zip->getStatusCode() . ' ' . $zip->getStatusString() . "\n";
    }
} else {
    echo "Failed to open file!  " . $zip->getStatusString() . "\n";
}
