<?php
define('FILES_PATH', __DIR__.'/files');
$file = $_POST['file'];
if ($file) {
    $path = FILES_PATH.$file;
    if (is_file($path))
        unlink($path);
}