<?php 
// ***********************************
// custom form button
// ***********************************

function custom_btn( $button, $form ) {
    // signup button
    if ($form['id'] == 5) $button = "<input type='submit' value='CREATE ACCOUNT' class='button-link sign-up-btn button' id='gform_submit_button_{$form['id']}'>";

    // contact us button
    else if ($form['id'] == 6) $button = "<input type='submit' value='SEND' class='button-link form-btn button' id='gform_submit_button_{$form['id']}'>";

    // contact us button
    else if ($form['id'] == 7) $button = "<input type='submit' value='SAVE' class='button-link form-btn' id='gform_submit_button_{$form['id']}'><a href='javascript:hide_modal();' class='link-button button btn-cancel control-no-border'>CANCEL</a>";

    return $button;
}
add_filter( 'gform_submit_button', 'custom_btn', 10, 2 );


// ***********************************
// custom validation message
// ***********************************

function change_message( $message, $form ) {
    return "<div class='alert alert-danger control-no-border'>There was a problem with your submission, please see below.</div>";
}
add_filter( 'gform_validation_message', 'change_message', 10, 2 );


// ***********************************
// custom confirmation message
// ***********************************

function signup_confirmation_message( $confirmation, $form, $entry, $ajax ) {

    // signup form
    if ($form['id'] == 5) $confirmation = "<div class='alert alert-success control-no-border form-confirmation-message' data-link='".home_url('/index.php')."'>".$confirmation."</div>";

    return $confirmation;

}
add_filter( 'gform_confirmation', 'signup_confirmation_message', 10, 4 );


// =============================================================================================
// form process version 1.0
// =============================================================================================

// ***********************************
// form confirmation
// ***********************************

add_filter( 'gform_confirmation', 'custom_confirmation', 10, 4 );

function custom_confirmation( $confirmation, $form, $entry, $ajax ) {

	// form confirmation code here

	return $confirmation;
}


add_filter( 'gform_confirmation', 'custom_confirmation', 10, 4 );

function custom_confirmation( $confirmation, $form, $entry, $ajax ) {

    // LOGIN
    if ($form['id'] == 3) {

        $creds = array();
        if ( rgar( $entry, '4.1' ) == 'true' ) {
            $creds['remember'] = true;
        }else{
            $creds['remember'] = false; 
        }

        $creds['user_login'] = $entry[1];
        $creds['user_password'] = $entry[2];
        wp_signon( $creds, false );

    }

    // SIGN UP
    else if ($form['id'] == 4) {

        // get data from form fields
        $userdata = array(
            'user_login'  =>  $entry[2],
            'first_name'  =>  $entry[1],
            'last_name'  =>  $entry[3],
            'user_email'  =>  $entry[4],
            'user_pass'   => $entry[5],

        );

        // insert new user to database
        $user_id = wp_insert_user( $userdata );

        // put the rest of the code below to execute when signup form was submitted by user
    }

    // FORGOT PASSWORD
    else if ($form['id'] == 5) {

        $email = $entry[1]; //get email
        $user = get_user_by( 'email', $email ); 
        $id = $user->ID; //get id
        $udata = get_userdata($id);
        $fname = $udata->first_name;
        $lname = $udata->last_name;

        $forgot = array(
            'email' => $email,
            'id' => $id
        );

        $encode = json_encode($forgot);
        $e1 = base64_encode($encode);
        $e2 = base64_encode($e1); //double encryption

        // $nonce = wp_create_nonce( 'reset_password' );
        // $data = '?id='.$id.'&nonce='.$nonce;
        $data = '?reset='.$e2;

        $reset_url_label = home_url().'/reset-password/';
        $reset_url_link = $reset_url_label.$data;
        
        $to = $email;
        $subject = 'Reset Password';
        $body = '';
        $body .= '<p>Hello '.$fname.' '.$lname.',</p>';
        $body .='<p>We received a request to reset the password to your account in <a href="'.home_url().'">'.get_bloginfo( 'title' ).'</a>. If you did not request a password reset, please ignore this e-mail.</p>'; 
        
        $body .='<p>If you wish to finalize your password reset, please <a href="'.$reset_url_link.'">click here</a></p>';
        
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $mail_res = wp_mail( $to, $subject, $body, $headers );
        // $redirect_url = home_url();
        if($mail_res){
            $confirmation = $confirmation;
        }else{
            $confirmation = "<div class='alert alert-danger'><strong>Failed:</strong> An error occured while, please try again later.</div>";           
        }

    }

    // RESET PASSWORD
    else if ($form['id'] == 6) {

        $email = $entry[1];
        $user = get_user_by( 'email', $email ); 
        $id = $user->ID; //get id

        $user_id = $id;
        $password = $entry[2];
        // save new password
        wp_set_password( $password,$user_id );
        $u_data = get_userdata( $user_id );
        $username = $u_data->user_login;
        $creds = array();
        // create the credentials array
        $creds['user_login'] = $username;
        $creds['user_password'] = $password;
        // $creds['remember'] = true;
        // $sign = wp_signon( $creds,false );

        $login = home_url('/login-and-sign-up');

        // if($sign){
            $confirmation = '<script>alert("Password successfully changed"); window.location.href = "'.$login.'";</script>';
        // }else{
            // $confirmation = "<div class='alert alert-danger'><strong>Failed:</strong> An error occured while, please try again later.</div>";
        // }
    }


    return $confirmation;
}

// ***********************************
// form validation
// ***********************************

add_filter( 'gform_validation', 'custom_validation' );

function custom_validation( $validation_result ) {

	$form = $validation_result['form'];

	// form validation codes here

	$validation_result['form'] = $form;

    return $validation_result;
}

add_filter( 'gform_validation', 'custom_validation' );

function custom_validation( $validation_result ) {

    $form = $validation_result['form'];

    // LOGIN
    if ($form['id'] == 3) {
        $id_arr = array();
        $msg_arr = array();

        $user = wp_authenticate( rgpost( 'input_1' ), rgpost( 'input_2' ) );
        if (is_wp_error($user)) {
            $id_arr[] = 1;
            $id_arr[] = 2;
            $msg_arr[1] = "Invalid Username";
            $msg_arr[2] = "Invalid Password";
        }
        if ($id_arr) {
            $validation_result['is_valid'] = false;
             foreach( $form['fields'] as &$field ) {
                if ( in_array($field->id, $id_arr) ) {
                    $field->failed_validation = true;
                    $field->validation_message = $msg_arr[$field->id];
                }
            }
        }

    }


    // SIGN UP
    else if ($form['id'] == 4) {

        $id_arr = array();
        $msg_arr = array();


        // Validate Firstname
        if ( rgpost( 'input_1' ) && !preg_match("#^[A-Za-z0-9.]+$#", rgpost( 'input_1' )) ) {
            $id_arr[] = 1;
            $msg_arr[1] = "First Name must not contain special characters";
        }

         // Validate Lastname
        if ( rgpost( 'input_3' ) && !preg_match("#^[A-Za-z0-9.]+$#", rgpost( 'input_3' )) ) {
            $id_arr[] = 3;
            $msg_arr[3] = "Last Name must not contain special characters";
        }

        // Validate Username
        if ( username_exists( rgpost( 'input_2' ) ) ) {
            $id_arr[] = 2;
            $msg_arr[2] = "Username already exists";
        }

        if ( rgpost( 'input_2' ) && !preg_match("#^[A-Za-z0-9_.]+$#", rgpost( 'input_2' )) ) {
            $id_arr[] = 2;
            $msg_arr[2] = "Username must not contain special characters";
        }

        if( rgpost( 'input_2' ) && strlen(rgpost( 'input_2')) <=6 ){
            $id_arr[] = 2;
            $msg_arr[2] = "Username must not be shorter than 6 characters";
        }

        // Validate Email
        if ( email_exists( rgpost( 'input_4' ) ) ) {
            $id_arr[] = 4;
            $msg_arr[4] = "Email already exists";
        }

        if ( rgpost( 'input_4' ) && !preg_match("#^[A-Za-z0-9_@.]+$#", rgpost( 'input_4' )) ) {
            $id_arr[] = 4;
            $msg_arr[4] = "Email address must not contain special characters";
        }

        // Validate Password
        if ( rgpost( 'input_5' ) != rgpost( 'input_6' ) ) {
            // $id_arr[] = 5;
            $id_arr[] = 6;
            // $msg_arr[5] = "Password mismatched";
            $msg_arr[6] = "Password mismatch";
        }

        if( rgpost( 'input_5') && strlen(rgpost( 'input_5')) <=6 ){
            $id_arr[] = 5;
            $msg_arr[5] = "Password must not be shorter than 6 characters";
        }

        // PROCESS VALIDATIONS
        if( $id_arr ){
            $validation_result['is_valid'] = false;
            foreach( $form['fields'] as &$field ) {
                if ( in_array($field->id, $id_arr) ) {
                    $field->failed_validation = true;
                    $field->validation_message = $msg_arr[$field->id];
                }
            }
        }
    }

    // FORGOT PASSWORD
    else if ($form['id'] == 5) {

        if ( !email_exists(rgpost("input_1")) ){

            $validation_result['is_valid'] = false;

            foreach( $form['fields'] as &$field ) {
                if($field->id == '1'){
                    $field->failed_validation = true;
                    $field->validation_message = 'Email does not exist!';
                }
            }
        }
    }

    // RESET PASSWORD
    else if ($form['id'] == 6) {

        $reset = $_GET['reset'];

        $d1 = base64_decode($reset);
        $d2 = base64_decode($d1);
        $decode = json_decode($d2);

        $d_email = $decode->email;
        $d_id = $decode->id;

        $id_arr = array();
        $msg_arr = array();

        // Validate Email
        if ( rgpost("input_1") !== $d_email ){
            $id_arr[] = 1;
            $msg_arr[1] = "Email address mismatched";
        }

        // Validate Password
        if ( rgpost( 'input_2' ) != rgpost( 'input_3' ) ) {
            // $id_arr[] = 2;
            $id_arr[] = 3;
            // $msg_arr[2] = "Password mismatched";
            $msg_arr[3] = "Password mismatched";
        }

        //Validate password length
        if( strlen(rgpost( 'input_2')) <=6 ){
            $id_arr[] = 2;
            $msg_arr[2] = "Your password must not be shorter than 6 characters";
        }

        if( $id_arr ){
            $validation_result['is_valid'] = false;

            foreach( $form['fields'] as &$field ) {
                if ( in_array($field->id, $id_arr) ) {
                    $field->failed_validation = true;
                    $field->validation_message = $msg_arr[$field->id];
                }
            }
        }
    }

    $validation_result['form'] = $form;

    return $validation_result;
}



// =============================================================================================
// form process version 2.0 (code excerpt from collins website)
// =============================================================================================

// ***********************************
// form confirmation
// ***********************************

add_filter( 'gform_confirmation', 'custom_confirmation', 10, 4 );

function custom_confirmation ( $confirmation, $form, $entry, $ajax ) {


    //retrieve form fields
    $arr_data = array();

    // loop through form fields and get each admin labels
    foreach ( $form['fields'] as $field ) {
    	$arr_data[$field->adminLabel] = $field->get_value_export( $entry, $field->id, true );
    }


    if ($form['id'] == 5) { //----- sign up form -----

        //create user
        $userdata = array(
    		'user_login'  =>  $arr_data['gf_email'],
    	    'first_name'  =>  $arr_data['gf_fname'],
    	    'last_name'  =>  $arr_data['gf_lname'],
    	    'user_email'  =>  $arr_data['gf_email'],
    	    'user_pass'   => $arr_data['gf_pword'],
    	);


    	$uc_id = wp_insert_user( $userdata );


        update_field( 'field_597aeb0de513c',$arr_data['gf_bdate'],'user_'.$uc_id );
        update_field( 'field_597aeb45e513d',$arr_data['gf_gender'],'user_'.$uc_id );
        update_field( 'field_597aeb56e513e',$arr_data['gf_phone'],'user_'.$uc_id );


        // saving billing address and shipping address
        $addr_arr = explode('[[DLM]]', $arr_data["gf_province"]);
        $addr_arr_ship = explode('[[DLM]]', $arr_data["gf_province_ship"]);
        $user_id = "user_".$uc_id; 
        $address1 = ($arr_data["gf_office"]) ? "(Office) ".$arr_data["gf_address"] : $arr_data["gf_address"];
        $address1_ship = ($arr_data["gf_office_ship"]) ? "(Office) ".$arr_data["gf_address_ship"] : $arr_data["gf_address_ship"];
        $fulladdr = $address1.' '.$arr_data["gf_brgy"].', '.$arr_data["gf_city"].', '.$addr_arr[0];
        $fulladdr_ship = $address1_ship.' '.$arr_data["gf_brgy_ship"].', '.$arr_data["gf_city_ship"].', '.$addr_arr_ship[0];

        // acf repeater field
        $field_key = "field_597fd425125fd";
        $value = get_field($field_key, $user_id);

        // billing
        $value[] = array(
            "field_597fd4e9125fe" => $address1,
            "field_597fd4f4125ff" => $arr_data["gf_brgy"],
            "field_597fd50512600" => $arr_data["gf_city"],
            "field_597fd56412603" => $addr_arr[0],
            "field_59811eacf3802" => $fulladdr,
            "field_59a6484d3f9a7" => true
        );

        // shipping
        $value[] = array(
            "field_597fd4e9125fe" => $address1_ship,
            "field_597fd4f4125ff" => $arr_data["gf_brgy_ship"],
            "field_597fd50512600" => $arr_data["gf_city_ship"],
            "field_597fd56412603" => $addr_arr_ship[0],
            "field_59811eacf3802" => $fulladdr_ship,
            "field_598143def4e37" => true
        );

        // update the repeater field and insert the value array
        update_field( $field_key, $value, $user_id );


        // update user billing details
        update_user_meta( $uc_id, 'billing_address_1', $address1 );
        update_user_meta( $uc_id, 'billing_address_2', $arr_data["gf_brgy"] );
        update_user_meta( $uc_id, 'billing_city', $arr_data["gf_city"] );
        update_user_meta( $uc_id, 'billing_state', $addr_arr[0] );
        update_user_meta( $uc_id, 'billing_country', $arr_data["gf_country"] );


        // update user shipping details
        update_user_meta( $uc_id, 'shipping_first_name', $arr_data["gf_fname"] );
        update_user_meta( $uc_id, 'shipping_last_name', $arr_data["gf_lname"] );
        update_user_meta( $uc_id, 'shipping_address_1', $address1_ship );
        update_user_meta( $uc_id, 'shipping_address_2', $arr_data["gf_brgy_ship"] );
        update_user_meta( $uc_id, 'shipping_city', $arr_data["gf_city_ship"] );
        update_user_meta( $uc_id, 'shipping_state', $addr_arr_ship[0] );
        update_user_meta( $uc_id, 'shipping_country', $arr_data["gf_country"] );


        // login user after sign up
    	$creds = array();
    	$creds['user_login'] = $arr_data['gf_email'];
    	$creds['user_password'] = $arr_data['gf_pword'];
    	// login user
    	$user = wp_signon( $creds, false );


        // send verification
        $v_email = get_userdata($uc_id)->user_email;
        $v_fname = get_userdata($uc_id)->first_name;
        $v_email_code = md5($v_email + microtime());
        $v_data = '?email='.$v_email.'&email_code='.$v_email_code;
        $v_email_to = $v_email;
        $v_subject = 'Email Verification';
        $v_body = '<br>Hello '.$v_fname.', <br>Welcome! to Famous Brand, To fully access our site you need to activate your account, so use the link below:<br>';
        $v_body .=  '<a href="'.home_url('/activate').$v_data.'">Click this link.</a>';
        $v_headers = array('Content-Type: text/html; charset=UTF-8','From: '.get_field( 'field_59c0a7311ba2e','option' ));
        $v_mail_res = wp_mail( $v_email_to, $v_subject, $v_body, $v_headers );


        // save email code to user
        update_field('field_5c12f5830de6a', $v_email_code, 'user_'.$uc_id);


        // send voucher code to new user   
        $code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
        $coupon_code = 'SB-'.$code; // Code
        $amount = '200'; // Amount
        $discount_type = 'fixed_cart'; // Type: fixed_cart, percent, fixed_product, percent_product


        // expiration date +30 days
        $exp_date = date('Y-m-d', strtotime("+30 days"));


        $coupon = array(
            'post_title' => $coupon_code,
            'post_content' => '',
            'post_status' => 'publish',
            'post_author' => $uc_id,
            'post_type'     => 'shop_coupon'
            );

        $new_coupon_id = wp_insert_post( $coupon );


        // Add meta
        update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
        update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
        update_post_meta( $new_coupon_id, 'individual_use', 'yes' );
        update_post_meta( $new_coupon_id, 'product_ids', '' );
        update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
        update_post_meta( $new_coupon_id, 'usage_limit', '1' );
        update_post_meta( $new_coupon_id, 'expiry_date', $exp_date );
        update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
        update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
        update_field( 'field_5c10c72335945', $uc_id, $new_coupon_id );
        

        //email coupon to user
        $email_to = get_userdata($uc_id)->user_email;
        $subject = get_field( 'field_59c0a7651ba2f','option' );
        $body = get_field( 'field_59c0a7741ba30','option' ).'</br></br></br>Coupon Code: '.$coupon_code;
        $headers = array('Content-Type: text/html; charset=UTF-8','From: '.get_field( 'field_59c0a7311ba2e','option' ));
        $mail_res = wp_mail( $email_to, $subject, $body, $headers );
                

    	//subscribe to newsletter
    	if ($arr_data['gf_nletter']) {

    	    $list_ids = array( 1 );

    		$data_subscriber = array(
    			'user' => array(
    				'email' => $arr_data['gf_email'],
    				'firstname' => $arr_data['gf_fname'],
    				'lastname' => $arr_data['gf_lname'],
    			),

    			'user_list' => array(
    				'list_ids' => $list_ids
    			),
    		);

    		$user_id = WYSIJA::get( 'user', 'helper' )->addSubscriber( $data_subscriber );
    	}


        $redir = (isset($_GET['re']))? home_url('/'.$_GET['re']) : home_url('/login');
    	$confirmation = array( 'redirect' => $redir );


    } else if ($form['id'] == 6) { //-----  contact us form -----

        $confirmation = array( 'redirect' => home_url('/contact-us/') );

    } else if ($form['id'] == 7) { //----- my account save address -----

        $id =  get_current_user_id();
        $addr_arr = explode('[[DLM]]', $arr_data["gf_province"]);
        $field_key = "field_597fd425125fd";
        $user_id = "user_".$id; 
        $address1 = ($arr_data["gf_office"])? "(Office) ".$arr_data["gf_address"] : $arr_data["gf_address"];
        $fulladdr = $address1.' '.$arr_data["gf_brgy"].', '.$arr_data["gf_city"].', '.$addr_arr[0];

        $value = get_field($field_key, $user_id);

        $value[] = array(
            "field_597fd4e9125fe" => $address1,
            "field_597fd4f4125ff" => $arr_data["gf_brgy"],
            "field_597fd50512600" => $arr_data["gf_city"],
            "field_597fd56412603" => $addr_arr[0],
            "field_59811eacf3802" => $fulladdr
        );

        update_field( $field_key, $value, $user_id );

        $confirmation = array( 'redirect' => home_url('/update-my-account/') );


    } else if ($form['id'] == 8) { //----- update account address address -----

        $id =  get_current_user_id();

        //user info
        update_user_meta( $id, 'first_name', $arr_data['gf_fname'] );
        update_user_meta( $id, 'last_name', $arr_data['gf_lname'] );
        update_user_meta( $id, 'user_birthday', $arr_data['gf_bdate'] );
        update_user_meta( $id, 'user_gender', $arr_data['gf_gender'] );

        // wp_update_user( $id, 'user_email', $arr_data['gf_email'] );
        update_user_meta( $id, 'user_phone', $arr_data['gf_phone'] );

        //shipping country
        update_user_meta( $id, 'shipping_country', $entry[10] );

        //billing country
        update_user_meta( $id, 'billing_country', $entry[10] );
        
        //update password
        if( $arr_data["gf_npword"] != '' ) wp_set_password( $arr_data["gf_npword"], $id );
    }

    return $confirmation;
}



// ***********************************
// form validation
// ***********************************

add_filter( 'gform_validation', 'custom_validation' );

function custom_validation( $validation_result ) {

    $form = $validation_result['form'];

    $ctr = 0;

    if($form['id'] == 5){ //----- sign up validation -----

        //password checker
        if ( rgpost( 'input_14' ) != rgpost( 'input_13' ) ) {
            foreach( $form['fields'] as &$field ) {
                if ( $field->adminLabel == 'gf_pword' ) {

                    $field->failed_validation = true;
                    $field->validation_message = 'Password mismatch!';
                    $ctr++;

                } else if ( $field->adminLabel == 'gf_rpword' ){

                    $field->failed_validation = true;
                    $field->validation_message = 'Password mismatch!';
                    $ctr++;
                }

                if($ctr == 2){
                    break;
                }
            }
        }


        if ( username_exists( rgpost( 'input_5' ) ) ) {

            $validation_result['is_valid'] = false;

            foreach( $form['fields'] as &$field ) {
                if ( $field->adminLabel == 'gf_email' ) {

                    $field->failed_validation = true;
                    $field->validation_message = 'Email already in use!';

                    break;

                    $ctr++;
                }
            }
        }

    } else if ($form['id'] == 6) { //----- contact us validation -----

        foreach( $form['fields'] as &$field ) {
            if ( rgpost( "input_{$field['id']}" ) == '' ) {

                $field->failed_validation = true;
                $field->validation_message = 'This field is required.';
                $ctr++;

            }
         }

    } else if ($form['id'] == 7) { //----- update address validation -----

        foreach( $form['fields'] as &$field ) {
            if ( rgpost( "input_{$field['id']}" ) == '' && $field->adminLabel != 'gf_office') {

                $field->failed_validation = true;
                $field->validation_message = 'This field is required.';
                $ctr++;

            }
        }

    } else if ($form['id'] == 8) { //----- update account validation -----

        if ( rgpost( "input_16" ) != rgpost( "input_17" ) ){

           	$ctr++;

            foreach( $form['fields'] as &$field ) {
                if($field->adminLabel == 'gf_npword' || $field->adminLabel == 'gf_rnpword'){

                    $field->failed_validation = true;
                    $field->validation_message = 'Password Mismatch.';

                }
            }
        }
    }

    //Assign modified $form object back to the validation result

    if($ctr) $validation_result['is_valid'] = false;

    $validation_result['form'] = $form;

    return $validation_result;
}



// pre populate gravity form fields
// data from excel sheet

add_filter( 'gform_pre_render_7', 'populate_select_fields' );
add_filter( 'gform_pre_render_7', 'populate_select_fields' );
add_filter( 'gform_pre_render_7', 'populate_select_fields' );
add_filter( 'gform_pre_render_7', 'populate_select_fields' );

add_filter( 'gform_pre_render_8', 'populate_select_fields' );
add_filter( 'gform_pre_render_8', 'populate_select_fields' );
add_filter( 'gform_pre_render_8', 'populate_select_fields' );
add_filter( 'gform_pre_render_8', 'populate_select_fields' );

add_filter( 'gform_pre_render_5', 'populate_select_fields' );
add_filter( 'gform_pre_render_5', 'populate_select_fields' );
add_filter( 'gform_pre_render_5', 'populate_select_fields' );
add_filter( 'gform_pre_render_5', 'populate_select_fields' );

function populate_select_fields( $form ) {

    if ( $form['id'] == 7 || $form['id'] == 8 || $form['id'] == 5 ) {

        $province_list = array();

        //get province
        $province_list_ta = get_field('field_5a6a7d747716a','option');
        $prov_arr = explode('<br />', $province_list_ta);
        $cur_prov;
        $r1 = 0;
        $r2 = 0;

        foreach ( $prov_arr as $prov_item ) {
            if( trim($prov_item) != $cur_prov || $r2 == (count($prov_arr)-1) ) {                                  
				if( $r2 > 0 ){

				if($r2 < (count($prov_arr)-1)){
					$r2--;
				}
					// $result['province_options'] .= '<option data-r1="'.$r1.'" data-r2="'.$r2.'" value="'.$cur_prov.'" '.( trim($prov) == $cur_prov ? 'selected':'' ).'>'.$cur_prov.'</option>';
					array_push($province_list,array( 'value' => $cur_prov.'[[DLM]]'.$r1.'[[DLM]]'.$r2, 'text' => $cur_prov ));

					$r2++;
					$r1 = $r2;
				}

              $cur_prov = trim($prov_item);
            }

            $r2++;
        }


        foreach ( $form['fields'] as $field ) { 

            if ( trim($field->adminLabel) == 'gf_brgy' ||  $field->adminLabel == 'gf_city' ||  $field->adminLabel == 'gf_city_ship') {

                $field->choices = array();

            } else if ( trim($field->adminLabel) == 'gf_province' ) {

                $field->choices = $province_list;

            } else if ( trim($field->adminLabel) == 'gf_province_ship' ) {

                $field->choices = $province_list;

            } else if ( trim($field->adminLabel) == 'gf_country' ) {

                global $woocommerce;

                $countries_obj = new WC_Countries();
                $countries = $countries_obj->__get('countries');
                $country_list = array();

                foreach( $countries as $key => $val ){
                    array_push($country_list,array( 'value' => $key , 'text' => $val ));
                }

                $field->choices = $country_list;

            } else {

                continue;

            }
        }

        return $form;
    }
}


// pupolate gravity form field
add_filter( 'gform_field_value_gf_user_bdate', 'populate_date' );

function populate_date( $value ) {

    $user_id = "user_".get_current_user_id();
    $val = get_field( 'field_597aeb0de513c',$user_id );
    $date = date("m/d/Y", strtotime($val));

    return $date;
}


// =============================================================================================
// login process accepts username and email 
// =============================================================================================

// ***********************************
// form confirmation
// ***********************************

add_action( "gform_after_submission_2", "login_form_after_submission", 10, 2 );

function login_form_after_submission($entry, $form) {

	// get the username and pass
	$username = $entry[1];
	$pass = $entry[2];
	$creds = array();

	// create the credentials array
	$creds['user_login'] = $username;
	$creds['user_password'] = $pass;

	// sign in the user and set him as the logged in user
	$sign = wp_signon( $creds );
	wp_set_current_user( $sign->ID );

	$url = home_url();

	if ( wp_redirect( $url ) ) {
		exit;
	}
}


// ***********************************
// form validation
// ***********************************

add_filter( 'gform_validation', 'gform_custom_validation' );

function gform_custom_validation( $validation_result ) {

	$form = $validation_result['form'];

    /* LOGIN FORM */
    if ($form['id'] == 2) {

        $id_arr = array();
        $msg_arr = array();

        if (rgpost( 'input_1' ) && rgpost( 'input_2' )) {
          
			$user_id = 0;
			$user_name = rgpost( 'input_1' );
			$password = rgpost( 'input_2' );

			// getting email and username if exist in database
			if($user = get_user_by('email',$user_name)) :

				$user_id = $user->data->ID; // store user id when email is used

			else if ($user = get_user_by('login',$user_name)) :

				$user_id = $user->data->ID; // store user id when username is used

			else:
				// when both username or email is wrong
				$id_arr[] = 1;
				$msg_arr[1] = "Invalid credentials";
				$id_arr[] = 2;
				$msg_arr[2] = "Invalid credentials";

			endif;

          	$user_pass = (string)$user->data->user_pass;

			// check for password if valid
			if(wp_check_password( $password, $user_pass, $user_id )) :

				// get user meta data value from database
				if(get_user_meta( $user_id, 'pw_user_status', true ) != 'approved') :

					// indicate both errors in input field
					$id_arr[] = 1;
					$msg_arr[1] = "Please wait for Admin approval.";
					$id_arr[] = 2;
					$msg_arr[2] = "";

				endif;

          	else:
              
				$id_arr[] = 1;
				$msg_arr[1] = "Invalid credentials";
				$id_arr[] = 2;
				$msg_arr[2] = "Invalid credentials";

          	endif;

			// PROCESS VALIDATIONS
			if ($id_arr) {

				$validation_result['is_valid'] = false;

				foreach( $form['fields'] as &$field ) {

					if ( in_array($field->id, $id_arr) ) {

						$field->failed_validation = true;
						$field->validation_message = $msg_arr[$field->id];
					}
				}

          	}

        }

    }

    $validation_result['form'] = $form;
    return $validation_result;
}


// =============================================================================================
// custom form with ajax 
// =============================================================================================

// ***********************************
// login form
// ***********************************

// ajax action
function form_login_checker(){
    
    $defaultClass = 'alert control-no-border';
    $result = array( 'class'=>'','msg'=>'','action'=> 2 );

    $creds = array();
    $creds['user_login'] = $_POST['uname'];
    $creds['user_password'] = $_POST['pword'];
    $captcha = $_POST['captcha'];

    if ( !email_exists( $creds['user_login'] ) ) {

        $result['class'] = 'alert-danger '.$defaultClass;
        $result['msg'] = '<strong>Error:</strong> Email does not exist!';
        $result['action'] = 0;
    }
    
    if ($captcha == 'false') {

        $result['class'] = 'alert-warning '.$defaultClass;
        $result['msg'] = '<strong>Warning:</strong> Please verify you are not a robot.';
        $result['action'] = 0;
    }

    if ($_POST['uname'] == '' || $_POST['pword'] == '') {

        $result['class'] = 'alert-warning '.$defaultClass;
        $result['msg'] = '<strong>Warning:</strong> Email and/or password required.';
        $result['action'] = 0;
    }

    if ($result['action'] == 2) {

        $email = $_POST['uname'];
        $user = get_user_by( 'email', $email );
        $uid = $user->ID;
        $active = get_field('field_5c12f6fd0de6b', 'user_'.$uid);

        if ($active) {

            $user = wp_signon( $creds, false );

            if ( !is_wp_error($user) ) {
                //login successful
                $result['action'] = 1;

            } else {

                $result['class'] = 'alert-danger '.$defaultClass;
                $result['msg'] = '<strong>Error:</strong> Invalid password!';
                $result['action'] = 0;
            }

        } else {

            $result['class'] = 'alert-danger '.$defaultClass;
            $result['msg'] = '<strong>Error:</strong> Please check your email to activate your account.';
            $result['action'] = 0;
        }
    }
    
    return wp_send_json($result);
}

add_action( 'wp_ajax_form_login', 'form_login_checker' );
add_action( 'wp_ajax_nopriv_form_login', 'form_login_checker' );

?>

<script type="text/javascript">
// ajax script
$('#form-login').on('submit',function(){

    var un = $('#usernameInput').val();
    var pw = $('#passwordInput').val();
    var cpt = 0;

    try {
       cpt = (grecaptcha && grecaptcha.getResponse().length !== 0);
    }
    catch (e) {
       // statements to handle any exceptions
       console.log('no captcha found');
    }

    if ($('#orc').val() > 0) {
        cpt = true; 
    }

    $.ajax({

        url: ajax_dir_list.admin_dir,
        type:'POST',
        dataType: 'JSON',
        
        data:{
            action: 'form_login',
            uname: un,
            pword: pw,
            captcha: cpt
        },

        beforeSend: function() {
            //loader
            $('.alert').hide();
            $('.loader').show();
        },

        success: function(data, response) {

            if ( data.action > 0 ) {

                var uri = (re_uri != '')? '/' + re_uri : '';

                window.location = ajax_dir_list.home_dir + '/' + re_uri;

            } else {

                $('.loader').hide();
                $('.alert').removeClass().addClass(data.class);
                $('.alert').html(data.msg);
                $('.alert').fadeIn();
            }
        }
    });

    return false;

});
</script>


<!-- login template -->
<div class="form-padding form-bg-color login-margin-top">
    <div class="loader-bg loader"></div>

    <div class="loader-gif loader">
        <div class="container-table">
            <div class="container-cell">
                <img src="<?php echo get_bloginfo( 'template_url' ).'/assets/images/loader2.gif'; ?>" alt="">
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h3 class="default-margin-top text-uppercase"><strong>LOGIN</strong></h3>
        <p class="default-margin-top">Already have an account</p>
        <div class="form-divider login-margin-top login-margin-bottom"></div>
        <form id="form-login" action="form_login" method="POST">
            <div class="login-margin-top">
                <label for="usernameInput">Email Address</label>
            </div>
            <div class="default-margin-top">
                <input type="text" id="usernameInput" class="form-control control-no-border">
            </div>
            <div class="default-margin-top">
                <label for="passwordInput">Password</label>
            </div>
            <div class="default-margin-top">
                <input type="password" id="passwordInput" class="form-control control-no-border">
            </div>
            <div class="login-margin-top login-margin-bottom">
                <div class="g-recaptcha" data-sitekey="6LcO_SYUAAAAAPg7wTZSX6tmj7yrFZZubRuQQjqR"></div>
            </div>
            <div class="login-margin-bottom">
                <a href="<?php echo home_url('/forgot'); ?>"><span class="span">Forgot Password?</span></a>
            </div>
            <div class="default-margin-bottom">
                <input type="submit" value="LOGIN" class="button-link form-btn">
            </div>
            <input type="hidden" name="orc" id="orc" value="<?php echo (isset($_GET['orc'])) ? 1 : 0; ?>">
        </form>
        <div class="control-no-display alert alert-success control-no-border">
        </div>
    </div>

    <div class="clearfix"></div>
</div>

<!-- css -->
<style type="text/css">
.control-no-border{
    -webkit-border-radius: 0;
    -moz-border-radius: 0;
    border-radius: 0;
}

.control-no-display{
    display: none;
}

/* loader css */
.loader-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 99;
    /*display: none;*/
    background: whitesmoke;
    opacity: 0.5;
}

.loader-gif {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    z-index: 99;
}

.loader-gif img{
    width: 80px;
}
</style>
<?php

// ***********************************
// send link forgot password
// ***********************************

// ajax action
function form_email_forgot() {

    $res = array( 'status'=>'failed' );

    if (isset($_POST['email'])) {
        if ( email_exists( $_POST['email'] ) ) {

            $user = get_user_by( 'email',$_POST['email'] );

            if ( !in_array( 'administrator', (array) $user->roles ) ) {
                //initialize
                $id = $user->ID;
                $nonce = wp_create_nonce( 'nonce' );
                
                //email user
                $data = '?id='.$id.'&nonce='.$nonce;
                $to = $_POST['email'];
                $subject = get_field( 'field_598d119a6b86a','option' );
                $body = get_field( 'field_598d117e6b869','option' ).'</br></br></br><a href="'.home_url('/reset').$data.'">Click this link.</a>';
                $headers = array('Content-Type: text/html; charset=UTF-8','From: '.get_field( 'field_598d115f6b868','option' ));
                $mail_res = wp_mail( $to, $subject, $body, $headers );

                //update reset custom fields
                update_field( 'field_598bf44840957',$nonce,'user_'.$id ); 
                update_field( 'field_598bf46e40959',false,'user_'.$id ); //set link to unused
                update_field( 'field_598bf45740958',date('m/d/Y', time()+86400),'user_'.$id );

                $res['link'] = $data;
                $res['status']='success';
            }
        }
    }
    return wp_send_json($res);
}

add_action( 'wp_ajax_email_forgot', 'form_email_forgot' );
add_action( 'wp_ajax_nopriv_email_forgot', 'form_email_forgot' );


?>

<script type="text/javascript">
// ajax script
$('#form-forgot').on('submit',function(){

    $('.new-loader').show();

    var uname = $('#forgot-uname').val();

    if ( uname == '' ) {

        $('.forgot-alert').removeClass('alert-success').addClass('alert-danger');
        $('.forgot-alert').html('Unable to verify your email, please make sure your email is correct.');
        $('.forgot-alert').removeClass('hidden');
        $('.new-loader').hide();

        return false;
    }

    $.ajax({

        url: ajax_dir_list.admin_dir,
        type:'POST',
        dataType: 'JSON',

        data: {
            action:'email_forgot',
            email:uname
        },

        beforeSend: function(){
            $('.pre-loader').show();
        },

        success: function(response){

            if (response.status == 'success') {

                $('.forgot-alert').removeClass('alert-danger').addClass('alert-success');
                $('.forgot-alert').html('Please check your email, we sent you a link to reset your password.');
                $('.forgot-alert').removeClass('hidden');

            } else {

                $('.forgot-alert').removeClass('alert-success').addClass('alert-danger');
                $('.forgot-alert').html('Unable to verify email, please make sure your email is correct.');
                $('.forgot-alert').removeClass('hidden');
            }

            $('.new-loader').hide();
            //console.log(response.link);
        },

        error: function(xhr){
            console.log(xhr);
        },
    });

    return false;

});
</script>

<!-- forgot password template -->
<div class="forgot-container">
    <div class="forgot-gif new-loader">
        <div class="container-table">
            <div class="container-cell">
                <img src="http://localhost/famousbr/wp-content/themes/collins/assets/images/loader2.gif" alt="">
            </div>
        </div>
    </div>
    <div class="alert alert-success forgot-alert text-left hidden control-no-border" data-link=""></div>
    <!-- loader -->
    <form id="form-forgot" action="email_forgot" method="POST" class="text-center">
        <input type="text" class="form-control control-no-border" id="forgot-uname" placeholder="Enter your email">
        <input type='submit' value='SUBMIT' class='margin-30 button-link form-btn'>
    </form>
</div>

<!-- css -->
<style type="text/css">
.forgot-container{
    padding: 40px 0;
}

.new-loader{
    position: absolute;
    background-color: rgba(255,255,255,0.5);
    width: 100%;
    height: 100%;
    z-index: 5001;
    top: 0;
    left: 0;
    display: none;
}

.new-loader img{
    width: 80px;
}
</style>
<?php

// ***********************************
// reset password
// ***********************************

// ajax script
function form_verify_forgot(){

    $res = array( 'status'=>'success' );
    $npword = $_POST['npword'];
    $uid = $_POST['id'];

    wp_set_password( $npword,$uid );

    return wp_send_json($res);
}
add_action( 'wp_ajax_verify_forgot', 'form_verify_forgot' );
add_action( 'wp_ajax_nopriv_verify_forgot', 'form_verify_forgot' );


?>
<script type="text/javascript">
// ajax script
$('#form-reset').on('submit',function() {

    $('.new-loader').show();

    var uid = $('#reset-id').val();
    var pword = $('#reset-pword').val();
    var npword = $('#reset-rpword').val();

    if( (pword != npword) || pword == '' || npword =='' ){

        $('.reset-alert').removeClass('alert-success').addClass('alert-danger');
        $('.reset-alert').html('Password reset failed, please make sure password matches or not empty.');
        $('.reset-alert').removeClass('hidden');
        $('.new-loader').hide();

        return false;
    }



    $.ajax({

        url: ajax_dir_list.admin_dir,
        type:'POST',
        dataType: 'JSON',

        data:{
            action:'verify_forgot',
            npword:pword,
            id:uid
        },

        beforeSend: function() {
            $('.new-loader').show();
        },

        success:function(response){

            if (response.status == 'success') {

                $('.reset-alert').removeClass('alert-danger').addClass('alert-success form-confirmation-message');
                $('.reset-alert').html('Password reset successful, you will be redirected to login shortly.');
                $('.reset-alert').removeClass('hidden');
                $('#form-reset').hide();

                setTimeout(function() { 
                    window.location = $(".form-confirmation-message").attr('data-link');
                }, 3000);
            }

            $('.new-loader').hide();
        },

        error:function(xhr) {
            console.log(xhr);
        },
    });

    return false;

});
</script>
<?php
// reset password template

$uid = '';

if( isset($_GET['id']) && isset($_GET['nonce']) ){

    $id = $_GET['id'];
    $nonce = $_GET['nonce'];
    $user = get_user_by( 'ID', $id );
    
    if( !$user ){
        die( '<h1 style="text-align: center;">ERROR 406</h1>' );
    }

    $current_link = get_field( 'field_598bf44840957','user_'.$id );
    $link_used = get_field( 'field_598bf46e40959','user_'.$id );
    $expiry_date = get_field( 'field_598bf45740958','user_'.$id );
    $today_start = date( 'm/d/Y',time() );

    //400 - nonce does not exist
    //401 - link already used
    //402 - nonce invalid
    //403 - user does not exist
    //404 - link expired
    //405 - link not valid
    //406 - user does not exist

    if ($current_link != $nonce) {
        die( '<h1 style="text-align: center;">ERROR 400</h1>' );
    }

    if ($link_used) {
        die( '<h1 style="text-align: center;">ERROR 401</h1>' );
        
    } else {
        update_field( 'field_598bf46e40959',true,'user_'.$id );
    }

    if (!wp_verify_nonce($nonce, 'nonce')) {
        die( '<h1 style="text-align: center;">ERROR 402</h1>' ); 
    }

    if (!email_exists($user->user_email )) {
        die( '<h1 style="text-align: center;">ERROR 403</h1>' ); 
    }

    if ($expiry_date < $today_start) {
        die( '<h1 style="text-align: center;">ERROR 404</h1>'  ); 
    }

} else {

    die( '<h1 style="text-align: center;">ERROR 405</h1>'  ); 
}

get_header(); 
?>
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="forgot-container text-center">
                <div class="forgot-gif new-loader">
                    <div class="container-table">
                        <div class="container-cell">
                            <img src="http://localhost/famousbr/wp-content/themes/collins/assets/images/loader2.gif" alt="">
                        </div>
                    </div>
                </div>
                <div class="alert alert-success hidden reset-alert" data-link="<?php echo home_url('/login/'); ?>"></div>
                <form id="form-reset" action="email_forgot" method="POST">
                    <input type="password" class="form-control control-no-border" id="reset-pword" placeholder="Enter new password">
                    <input type="password" class="form-control control-no-border margin-30" id="reset-rpword" placeholder="Re-enter new password">
                    <input type="hidden" value="<?php echo $id; ?>" id="reset-id">
                    <input type='submit' value='RESET' class='margin-30 button-link form-btn'>
                </form>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<?php get_footer(); ?>






















?>





