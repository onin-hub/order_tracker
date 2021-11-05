/********************************************************
  .ready , this will fire the code once the browser open
*********************************************************/
$(document).ready(function(){

    getExistingData();
    
});

/*******************************************
Sample ajax with successfull swal fre
********************************************/
$("#addHubNumber").click(function(e){
    e.preventDefault();

    var hubId = $('#idHub').val();//get input value
    var hubNum = $('#hubNum').val();////get input value
    var action = $('#updatesHub').attr('name') //get the attribute value

    $.ajax({
        url:'phpAction/action.php',
        data:{
            'hubId' : hubId,
            'hubNum' : hubNum,
            'action' : action
        },
        'type' : 'POST',
        success: function(response){
            Swal.fire({
                title: 'Hub update Successfully',
                type: 'success'
            })
            $("#editHubModal").modal('hide');
            showAllHubData();
            window.location.reload();
        }     
    });
});

$(document).on('click','#addHubNumber',function(e) {
    e.preventDefault();

    var hubNumber = $('#hubNumber').val();//get input value

    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
        data: {
            'action' : "addHubNumber", //set an action to trigger , what if condition to be use.
            'hubNumber' : hubNumber
        },                         
        type: 'POST',
        success: function(response){
                Swal.fire({
                    title: 'Hub Add Successfully',
                    type: 'success'
                })
                $("#addHubModal").modal('hide');
        }
     });

});


/*******************************************
 AJAX with DELETE ICON SWAL FIRE
********************************************/
$("body").on("click", ".delHubBtn", function(e){
    e.preventDefault();
   
    var id = $(this).attr('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: "phpAction/admin_action/admin_action.php",
            type: "POST",
            data: {'action' : "deleteHub",
                    'id' : id
            },
            success:function(response){
                // console.log(response);
                Swal.fire(
                    'Deleted!',
                    'Hub Deleted Successfully!',
                    'success'
                )
                allShowData();
                clearAllInput();
            }
          });
        }
    });
});

/*******************************************
Jquery with else if with swal fire
********************************************/
$(document).on('click','#add_HubNumber',function(e) {
    e.preventDefault();

    var hubNumber = $('#hubNumber').val();//get input value

    $.ajax({
        url:'phpAction/admin_action/admin_action.php',// point to server-side PHP script 
        data: {
            'action' : "addHubNumber", //set an action to trigger , what if condition to be use.
            'hubNumber' : hubNumber
        },            
        type: 'POST',
        success: function(response){
            response = JSON.parse(response);

            if (response['condition'] == 'error') {

                Swal.fire({
                icon: 'error',
                title: 'Hub already Exist!',
                type: 'error'
            })
            $("#addHubModal").modal('hide');
            allShowData();
            clearAllInput();
   
            }

            else if (response['condition'] == 'empty') {
                Swal.fire({
                icon: 'error',
                title: 'You Insert Nothing',
                type: 'error'
            })
            $("#addHubModal").modal('hide');
            allShowData();
            clearAllInput();
                  
            }
            
            else if (response['condition'] == 'success') {
                Swal.fire({
                icon: 'success',
                title: 'Hub add Successfully',
                type: 'success'
            })
            $("#addHubModal").modal('hide');
            allShowData();
            clearAllInput();
                  
            }

        }
     });
});



/*******************************************
sample if statement format inside the jquery
********************************************/
if ($('#update_Beer').attr('value') == 'Update'){

    $('#id').val('');
    $('#beer_Name').val('');
    $('#beer_Quantity').val('');

    $('#update_Beer').attr('value','Save');
    $('#update_Beer').attr('data-type','add_Beer');
    $('form h2').text('ADD BEERS');
    $('#update_Beer').attr('id','add_Beer');

}else if ($('#add_Beer').attr('value') == 'Save'){

    $('#id').val('');
    $('#beer_Name').val('');
    $('#beer_Quantity').val('');








/***********************************************************************************************
 *                   HOW TO USE THE METHOD OR FUNCTION INSIDE THE CLASS
 ***********************************************************************************************/
// $ob = new DB();              create a new object to use the function inside the class
// echo $ob->totalRowCount();   sample of code t use the function or method inside the class