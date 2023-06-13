<?php

$image = false;
$name = (!empty($_GET['name'])) ? $_GET['name'] : 'print image';
if (isset($_GET['image']) && filter_var($_GET['image'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
    $image = "includes/images/" . $_GET['image'];
    if (!file_exists($image) || (!is_file($image))) {
        $image = false;
    }
}

if (!$image) {
    $image = 'images/unavailable.png';
    $name = 'unavailable.png';
}

$info = getimagesize($image);
$fs = filesize($image);

header("Content-Type:{$info['mime']}\n");
header("Content-Deposition: inline; filename=\"$name\"\n");
header ("Content-Length: $fs\n");
readfile ($image);

?>