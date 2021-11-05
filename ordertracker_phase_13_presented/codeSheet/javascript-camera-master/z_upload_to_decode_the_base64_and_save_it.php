<?php

define('UPLOAD_DIR', 'assets/img/'); // define where to ssave the base64 image come from the browser.
$data = $_POST['pathCode'];

$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = UPLOAD_DIR . uniqid() . '.png';
$success = file_put_contents($file, $data);

?>