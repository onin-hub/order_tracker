$(document).ready(function(){

    getExistingData();
    
});

function getExistingData() {
    var key = 'loaddata';

    $.ajax({ 
        url: 'phpAction/fetch_Beer_Details.php',
        method: 'GET',
        data: {
            key: key
        },  success: function (response) {
                $('#beerlist').html(response);
            }
    });
}


$(document).on('click','#addBeers',function(e){
    e.preventDefault() //preventDefault is a inbuild method of jquery to change the bahavior of the button (to no to submit)

    var type = $(this).data('type');
    var bId = $('#bId').val();
    var iName = $('#iName').val();
    var beerActualQuantity = $('#beerActualQuantity').val();

    $.ajax({
        url:'phpAction/phpAction.php',
        data:{
            'type' : type,
            'bId' : bId,
            'iName' : iName,
            'beerActualQuantity' : beerActualQuantity
        },
        'type' : 'POST',
        success: function(response)
        {
            
            response = JSON.parse(response);

            if (response['type'] == 'success') {

          
                alert(response.msg);
                window.location.reload();
                
            } 
            
            else if (response['type'] == 'error') {

                alert(response.msg);
                

            }

            

        }     
    });
});

$(document).on('click','.updateBeer',function(e){
    e.preventDefault() //preventDefault is a inbuild method of jquery to change the bahavior of the button (to no to submit)

    var id = $(this).data('id');
    var iName = $(this).parent().siblings('.iName').text();
    var actualQty = $(this).parent().siblings('.actualQty').text();


    $('#bId').val(id);
    $('#iName').val(iName);
    $('#beerActualQuantity').val(actualQty);

    $('#addBeers').attr('value','update');
    $('#addBeers').attr('data-type','update');
    $('#addBeers').attr('id','editBeers');

    $('#cHeader').text('UPDATE BEERS');

    //clear ADD STOCK fields
    $('#add-Stock-Id').val('');
    $('#item-Name').val('');
    $('#remaining-Stock').val('');
    $('#added-Stock-field').val('');

});

$(document).on('click', '#editBeers', function(e){
    e.preventDefault() //preventDefault is a inbuild method of jquery to change the bahavior of the button (to no to submit)

    var type = $(this).data('type');
    var bId = $('#bId').val();
    var iName = $('#iName').val();
    var beerActualQuantity = $('#beerActualQuantity').val();

    $.ajax({
        url:'phpAction/phpAction.php',
        data:{
            'type' : type,
            'bId' : bId,
            'iName' : iName,
            'beerActualQuantity' : beerActualQuantity
        },
        'type' : 'POST',
        success: function(response)
        {
            
            alert(response);
            getExistingData();

        }
        
    });
});


$(document).on('click', '.deleteBeer', function(e){
    e.preventDefault() //preventDefault is a inbuild method of jquery to change the bahavior of the button (to no to submit)
    $('#myModal').modal('show');

    var id = $(this).data('id');
    var bname = $(this).data('bname');
    var dtype = $(this).data('dtype');

    $('#deleteItem').attr('data-id',id);
    $('#deleteItem').attr('data-bname',bname);
    $('#deleteItem').attr('data-dType',dtype);
 
    $('.modal-body h5').text("Are you sure yo want to delete " + bname + "?");
    //clear ADD BEER fields and UPDATE BEER fields
    $('#bId').val('');
    $('#iName').val('');
    $('#beerActualQuantity').val('');
    //clear ADD STOCK FIELDS
    $('#add-Stock-Id').val('');
    $('#item-Name').val('');
    $('#remaining-Stock').val('');
    $('#added-Stock-field').val('');

    $('#cHeader').text('ADD BEERS');

    $('#editBeers').attr('value','Save');
    $('#editBeers').attr('data-type','add');
    $('#editBeers').attr('id','addBeers');

});



$("#clearFields").on('click',function(){
    ///clear the fields
    $('#bId').val('');
    $('#iName').val('');
    $('#beerActualQuantity').val('');
    // change the attr:
    $('#editBeers').attr('value','Save');
    $('#editBeers').attr('data-type','add');
    $('#editBeers').attr('id','addBeers');

    $('#cHeader').text('ADD BEERS');

});

$(document).on('click', '#deleteItem', function(e){
    e.preventDefault() 

    var dtype = $(this).data('dtype');
    var id = $(this).data('id');
    

    $.ajax({
        url: 'phpAction/phpAction.php',
        data: {
            'type' : dtype,
            'id' : id
        },
        'type' : 'POST',
        success: function(response){
            alert(response);
            getExistingData();
        }

    });
});


$(document).on('click', '.add-To-Stock-Fields', function(e){
    e.preventDefault() 

    var id = $(this).data('id');
    var iName = $(this).parent().siblings('.iName').text();
    var actualQty = $(this).parent().siblings('.actualQty').text();

    $('#add-Stock-Id').val(id);
    $('#item-Name').val(iName);
    $('#remaining-Stock').val(actualQty);

    //ClEAR the add fields and update fields
    $('#bId').val('');
    $('#iName').val('');
    $('#beerActualQuantity').val('');

});

$(document).on('click', '#clear-Add-Stock-Fields', function(){
    $('#add-Stock-Id').val('');
    $('#item-Name').val('');
    $('#remaining-Stock').val('');
    $('#added-Stock-field').val('');
});

$(document).on('click', '#add-Stock', function(){

    var itemName = $('#item-Name').val();
    var addedCount = $('#added-Stock-field').val();

$('#myModal').modal('show');
$('.modal-body h5').text("Are you sure you want to add "+ addedCount +"pcs of "+ itemName + "?");

$('#deleteItem').attr('id','addStockCount');
$('#addStockCount').attr('data-type','addStock');


});

$(document).on('click', '#addStockCount', function(e){
    e.preventDefault()

    var type = $(this).data('type');
    var add_Stock_Id = $('#add-Stock-Id').val();
    var remaining_Stock = $('#remaining-Stock').val();
    var added_Stock_field = $('#added-Stock-field').val();


    $.ajax({
        url: 'phpAction/phpAction.php',
        data: {
            'type' : type,
            'add_Stock_Id' : add_Stock_Id,
            'remaining_Stock' : remaining_Stock,
            'added_Stock_field' : added_Stock_field
        },
        'type' : 'POST',
        success: function(response)
        {            
            response = JSON.parse(response);

            if (response['type'] == 'success') {

                alert(response.msg);
                getExistingData();
   
            }
            
            else if (response['type'] == 'error') {

                  alert(response.msg);
                  getExistingData();
                  
            }
          
        } 

    });
    

});




