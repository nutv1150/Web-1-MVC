<?php
$email = $_POST['email'];
$password = $_POST['password'];
$result = login( $email, $password);
if($result){
    $unix_timestamp = time();
    $_SESSION['timestamp'] = $unix_timestamp;
    $_SESSION['username'] = $result['username'];
    $_SESSION['email'] = $result['email'];
    $_SESSION['user_id'] = $result['user_id'];
    $_SESSION['gender'] = $result['gender'];
    $_SESSION['birthday'] = $result['birthday'];
    // $data = getuserbyid($result['userid']);
    renderView3('loghome_get');
}else{
    $_SESSION['message'] = 'รหัสไม่ถูกต้อง';
    renderView('login_get');
    unset($_SESSION['message']);
    unset($_SESSION['timestamp']);
}

// routes/login_post.php

