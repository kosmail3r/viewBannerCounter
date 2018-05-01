<?php
require __DIR__ . '/vendor/autoload.php';

$image = new \Classes\Image ('giphy.gif');
$show = $image->showImage();

if ($show) {
    Classes\VisitLogger::newVisit();
}