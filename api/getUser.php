<?php
// Set endpoint headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// initialize API
include_once('../core/initialize.php');

// Create instance of User
$user = new User($db);

$user->id = isset($_GET['id']) ? $_GET['id'] : die();
$user->read_single();

$user_info = array(
    'id'        => $user->id,
    'username'  => $user->username,
    'email'     => $user->email,
    'password'  => $user->password
);

print_r(json_encode($user_info));