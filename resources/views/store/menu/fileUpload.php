<?php
define('FILES_PATH', __DIR__ . '/files');
$result = array();
if (!empty($_FILES)) {
    $file = new FILEUPLOAD();
    $result = $file->upload();
}
die(json_encode($result));
