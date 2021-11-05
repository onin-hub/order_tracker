<?php

require_once 'database/DBCotroller.php';
require_once 'vendor/password/password.php';
require_once 'helpers/functions.php';
require_once 'class/Terminal.php';
require_once 'class/Subunit.php';
require_once 'class/User.php';
require_once 'class/Position.php';
require_once 'class/Document.php';
require_once 'class/Revision.php';

session_start();

if (isset($_SESSION['user_id'])) {

    $user = new User();
    $position = new Position();
    $subunit = new Subunit();
    $terminal = new Terminal();

    $user_id = $_SESSION['user_id'];

    $logged_userdata = $user->getUserByID($user_id);

    $logged_userfullname = $logged_userdata[0]['fullname'];
    $logged_userposid = $logged_userdata[0]['position'];
    $logged_useremail = $logged_userdata[0]['email'];
    $logged_userusername = $logged_userdata[0]['username'];
    $logged_userusertype = $logged_userdata[0]['usertype'];
    $logged_usersubid = $logged_userdata[0]['sub_id'];
    $logged_usertermid = $logged_userdata[0]['term_id'];
    $logged_userpermissions = $logged_userdata[0]['permission'];
    $logged_userpermissions = explode(',', $logged_userpermissions);

    $logged_positiondata = $position->getPosByID($logged_userposid);
    $logged_subunitdata = $subunit->getSubunitByID($logged_usersubid);
    $logged_terminaldata = $terminal->getTerminalByID($logged_usertermid);

    $logged_userposname = $logged_positiondata[0]['name'];
    $logged_userposlevel = $logged_positiondata[0]['level'];
    $logged_usersubunit = ($logged_subunitdata) ? $logged_subunitdata[0]['subname'] : '';
    $logged_usertermcode = $logged_terminaldata[0]['termcode'];
    $logged_usertermname = $logged_terminaldata[0]['termname'];
}

?>