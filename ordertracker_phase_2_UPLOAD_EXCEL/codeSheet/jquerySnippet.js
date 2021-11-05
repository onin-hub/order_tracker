/********************************************************
  .ready , this will fire the code once the browser open
*********************************************************/
$(document).ready(function(){

    getExistingData();
    
});

/*******************************************
Sample ajax with successfull swal fre
********************************************/
$("#updatesHub").click(function(e){
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











/***********************************************************************************************
 *                   HOW TO USE THE METHOD OR FUNCTION INSIDE THE CLASS
 ***********************************************************************************************/
// $ob = new DB();              create a new object to use the function inside the class
// echo $ob->totalRowCount();   sample of code t use the function or method inside the class