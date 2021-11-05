<?php

// require "../classes/admin_classes/AdminClasses.php";



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>

    <table class="table table-bordered" id="crud_table">
        <tr>
            <th width="60%">Name</th>
            <th width="30%">Date</th>
            <th width="10%"><button type="button" name="add" id="add" class="btn btn-success btn-sm">+</button></th>
        </tr>
        <tr>
            <td class="item_name"><input type="text" name="tracingName[]" <?php echo 1; ?> class="form-control" required /></td>
            <td class="item_date"><input type="text"  name="tracingDate[]" <?php echo 1; ?> class="form-control showDate datepicker1" required /></td>
            <td></td>
        </tr>
    </table>

     <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(document).ready(function() {
            var count = 1;
            $('#add').click(function() {

                count = count + 1;
                var html_code = "<tr id='row" + count + "'>";
                html_code += "<td class='item_name'><input type='text' name='tracingName[]" + count + "' class='form-control' required /></td>";
                html_code += "<td class='item_date'><input type='text'  name='tracingDate[]" + count + "' class='form-control showDate datepicker1' required /></td>";
                html_code += "<td><button type='button' name='remove' data-row='row" + count + "'class='btn btn-danger btn-xs remove'>-</button></td>";
                html_code += "</tr>";
                $('#crud_table').append(html_code);



            });

            $('.datepicker1').datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                maxDate: '-1',
                minDate: '-2'
            });

});

// $(document).on('click','.showDate',function(e) {
//     e.preventDefault();

//    $('.datepicker1').datepicker({
//                 dateFormat: "dd-mm-yy",
//                 changeMonth: true,
//                 changeYear: true,
//                 maxDate: '-1',
//                 minDate: '-2'
//             });
    
// });
$(document).on('click','#add',function(e) {
    e.preventDefault();
    
   $('.datepicker1').datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                maxDate: '-1',
                minDate: '-2'
            });
    
});

           



        
    </script>



</body>

</html>