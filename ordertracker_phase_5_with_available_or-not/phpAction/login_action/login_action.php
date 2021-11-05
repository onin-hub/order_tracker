<?php
session_start();
require '../../classes/login_classes/loginclasses.php';
$db = NEW loginclasses;


if (isset($_POST['action']) && $_POST['action'] == "userTryToLogin") {

    $user_name = trim($_POST['user_name']);
    $user_password = trim($_POST['password']);

    $results = $db->checkUnameAndPassword($user_name, $user_password);

    
    // $response = json_encode($results);
    // echo $response;

    if(count($results) > 0){
        foreach($results as $result){
            if($result['user_role'] == 'Admin' ) {
                $_SESSION['logInAdminInfo'] = array($result['id'],
                                                    $result['first_name'],
                                                    $result['last_name'],
                                                    $result['user_username'],
                                                    $result['user_password'],
                                                    $result['user_contact_number'],
                                                    $result['user_role'],
                                                    $result['hub_area'],
                                                    $result['date_joined']
                                                    );
            $response['condition'] = 'gotoAdmin';
            $response = json_encode($response);
            echo $response;
            
            }
            elseif ($result['user_role'] == 'Hub Supervisor' ) {
                $_SESSION['logInHubSuperVisorInfo'] = array($result['id'],
                                                    $result['first_name'],
                                                    $result['last_name'],
                                                    $result['user_username'],
                                                    $result['user_password'],
                                                    $result['user_contact_number'],
                                                    $result['user_role'],
                                                    $result['hub_area'],
                                                    $result['date_joined']
                                                    );
            $response['condition'] = 'gotoHubSupervisor';
            $response = json_encode($response);
            echo $response;

            }
            elseif ($result['user_role'] == 'Shipper' ) {
                $_SESSION['logInShipperInfo'] = array($result['id'],
                                                    $result['first_name'],
                                                    $result['last_name'],
                                                    $result['user_username'],
                                                    $result['user_password'],
                                                    $result['user_contact_number'],
                                                    $result['user_role'],
                                                    $result['hub_area'],
                                                    $result['date_joined']
                                                    );
            $response['condition'] = 'gotoShipper';
            $response = json_encode($response);
            echo $response;

            }
    }

    } else {

        $response['condition'] = 'gotoIndex';
        $response = json_encode($response);
        echo $response;
    }


}

?>
