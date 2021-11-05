


$(document).on('click','#logMein',function(e) {
    e.preventDefault();

    var user_name = $('#user_name').val();//get input value
    var password = $('#user_password').val();//get input value


    $.ajax({
        url:'phpAction/login_action/login_action.php',// point to server-side PHP script 
        data: {
            'action' : "userTryToLogin", //set an action to trigger , what if condition to be use.
            'user_name' : user_name,
            'password' : password
        },            
        type: 'POST',
        success: function(response){
            response = JSON.parse(response);

            if (response['condition'] == 'gotoAdmin') {

                Swal.fire({
                icon: 'success',
                title: 'Login successfully!',
                type: 'success'
            })
            
            window.location.assign("admin_dashboard.php");

            }

            else if (response['condition'] == 'gotoHubSupervisor') {
                Swal.fire({
                icon: 'success',
                title: 'Login successfully!',
                type: 'success'
            })
            window.location.assign("hubSup_dashboard.php");
                  
            }
            
            else if (response['condition'] == 'gotoShipper') {
                Swal.fire({
                icon: 'success',
                title: 'Login successfully!',
                type: 'success'
            })
            window.location.assign("shipper_dispatched_order.php");
                  
            }

            else if (response['condition'] == 'gotoIndex') {
                Swal.fire({
                icon: 'error',
                title: 'Wrong Username Or Password',
                type: 'error'
            })
            window.location.assign("index.php");
                  
            }
        }
     });
    
});


$(document).on('click','#logMeOut',function(e) {

    sessionStorage.removeItem('logInUserInfo');
    window.location.assign("index.php");

    

});
