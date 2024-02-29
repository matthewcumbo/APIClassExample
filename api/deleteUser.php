<?php
// Set endpoint headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// initialize API
include_once('../core/initialize.php');

// Create instance of User
$user = new User($db);
$user->id = isset($_GET['id']) ? $_GET['id'] : die();

if($user->delete()){
    echo json_encode(array('message'=>'User Deleted.'));
}
else{
    echo json_encode(array('message'=>'User NOT Deleted.'));
}