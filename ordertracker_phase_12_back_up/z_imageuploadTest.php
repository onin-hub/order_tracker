<?php


// Assume this URL for $download_image from your CSV
$download_image = 'http://example.com/images/img1.jpg';
$image_id = 12345;

// Store the original filename
$original_name = basename($download_image); // "img1.jpg"
// Original extension by string manipulation
$original_extension = substr($original_name, strrpos($original_name, '.')); // ".jpg"

// An array to match mime types from finfo_file() with extensions.
// Use of finfo_file() is recommended if you can't trust the input.
// filename's extension.
$types = array(
  'image/jpeg' => '.jpg',
  'image/png' => '.png',
  'image/gif' => '.gif'
  // Other types as needed...
);

// Get the file and save it
$img = file_get_contents($download_image);
$stored_name = 'images/' . $image_id . $original_extension;
if ($img) {
  file_put_contents($stored_name, $img);

  // Get the filesize if needed
  $size = filesize($stored_name);

  // If you don't care about validating the mime type, skip all of this...
  // Check the file information
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $mimetype = finfo_file($finfo, $stored_name);

  // Lookup the type in your array to get the extension
  if (isset($types[$mimetype])) {
    // if the reported type doesn't match the original extension, rename the file
    if ($types[$mimetype] != $original_extension) {
      rename($stored_name, 'images/' . $image_id . $types[$mimetype]);
    }
  }
  else {
    // unknown type, handle accordingly...
  }
  finfo_close($finfo);

  // Now save all the extra info you retrieved into your database however you normally would
  // $mimetype, $original_name, $original_extension, $filesize
}
else {
  // Error, couldn't get file
}

?>

