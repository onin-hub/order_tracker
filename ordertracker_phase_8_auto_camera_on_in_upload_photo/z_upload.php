<?php

/* Getting file name */
// $filename = $_FILES['file']['name'];
define('UPLOAD_DIR', 'assets/img/');
$data = $_POST['pathCode'];

$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = UPLOAD_DIR . uniqid() . '.png';
$success = file_put_contents($file, $data);




// if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
//     $data = substr($data, strpos($data, ',') + 1);
//     $type = strtolower($type[1]); // jpg, png, gif

//     if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
//         throw new \Exception('invalid image type');
//     }

//     $data = base64_decode($data);

//     if ($data === false) {
//         throw new \Exception('base64_decode failed');
//     }
// } else {
//     throw new \Exception('did not match data URI with image data');
// }

// file_put_contents("img.{$type}", $data);

// $filenameExploded = explode(";",$filenamelong);
// $filename = $filenameExploded[0];
// $reviseFilename = str_replace('/','.',$filename);
// $randnum = time();

// $finalFilaName = $randnum . $reviseFilename;

// echo $filenamelong;

/* Location */
// $location = "assets/img/".$filename;
// $uploadOk = 1;
// $imageFileType = pathinfo($location,PATHINFO_EXTENSION);

// /* Valid Extensions */
// $valid_extensions = array("jpg","jpeg","png");
// /* Check file extension */
// if(!in_array(strtolower($imageFileType),$valid_extensions) ) {
//    $uploadOk = 0;
// }

// if($uploadOk == 0){
//    echo 0;
// }else{
//    /* Upload file */
//    if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
//       echo $location;
//    }else{
//       echo 0;
//    }
// }


?>