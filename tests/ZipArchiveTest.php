<?php

require_once '../src/ZipFile.php';

$z = new \ZipArchive();

if ($z->open('../files/zip-infozip-3.0-encrypted.zip')) {
    echo "Open\n";
    if ($z->extractTo('/tmp/enctest')) {
        echo "Extracted\n";
    } else {
        var_dump($z->getStatusString());
    }
} else {
    echo 'open fail';
}

/*
$z = new ZipArchive();
$res = $z->open('/tmp/za.zip', ZipArchive::CREATE);

if ($res) {
    $z->addFromString('vagina/penis.txt', 'a penis in vagina');
    $z->addFile('/home/drew/Desktop/aatodo', 'aatodo');

    $res = $z->close();
    if (!$res) {
        var_dump($z->getStatusString());
    }
    var_dump($res);
} else {
    echo 'failed';
}
*/
