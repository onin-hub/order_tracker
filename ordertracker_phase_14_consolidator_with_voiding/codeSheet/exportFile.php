

//=============================================================================
// jquery to export file
//=============================================================================

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <a href="assets/excelFileUploaded/'.$row['file_name'].'" title="Download '.$row['file_name'].'" class="text-success getExcelFile" filename = "'.$row['file_name'].'"> <i class = "fas fa-file-download fa-md" ></i> </a> 

        <script>
            $(document).on('click','.getNAProdById',function(e) {
                e.preventDefault();  //stop the browser from following
                var filename = $(this).attr('filename');
                window.location.href = (filename);
            });
        </script>
</body>
</html>

//=============================================================================
// php action export file into specific directory
//=============================================================================
<?php 
define('UPLOAD_DIR', '../../assets/excelFileUploaded/');

//look other code in "import_csv_testing" folder

$excelFinalName = uniqid(). "-" . $fileName;

$data = $excelDataToSave; 
$file = UPLOAD_DIR . $excelFinalName; // UPLOAD_DIR on the top , to know where to directory to save

file_put_contents($file, $data);

?>
