<?php

declare(strict_types=1);//กำหนดชนิดข้อมูล

// Constant values for this project
const INCLUDES_DIR = __DIR__ . '/../includes';//ประกาศตัวแปรเป็นค่าคงที่
const ROUTE_DIR = __DIR__. '/../routes';
const TEMPLATES_DIR = __DIR__ . '/../templates';
const DATABASE_DIR = __DIR__ . '/../databases';


session_start();

// Include router to index.php 
require_once INCLUDES_DIR . '/router.php';//โหลดไฟล์routerมาใส่index,เรียกครั้งเดียวเมื่อเข้าผ่านindex
require_once INCLUDES_DIR . '/view.php';
require_once INCLUDES_DIR . '/db.php';


// Call dispatch to handle requests
//echo '$_SERVER["REQUEST_URI"]='.$_SERVER['REQUEST_URI'];
// dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
// Call dispatch to handle requests
// echo '$_SERVER["REQUEST_URI"]='.$_SERVER['REQUEST_URI'];

const PUBLIC_ROUTES = ['/', '/login', '/register']; // '/' = index.php

if (in_array(strtolower($_SERVER['REQUEST_URI']), PUBLIC_ROUTES)) {//ถ้ามีการเรียกเข้ามาอยู่ในArrayไหม
    dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    exit;
} elseif (isset($_SESSION['timestamp']) && time() - $_SESSION['timestamp'] < 600) {  //ถ้าเอาเวลาปัจุบันลบเวลาที่เราต้องการให้อยู่คือ10วิ
    // 10 Sec.
    $unix_timestamp = time();//ถ้ามีการกดเลื่อยๆจะอัพเดรทเวลาเริ่มนับจาก10ใหม่
    $_SESSION['timestamp'] = $unix_timestamp;
    dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} else {    //หลังจากหมดเวลาจะดันไปindex และทำให้เหมือนยังไม่ล็อคอิน
    unset($_SESSION['timestamp']);
    header('Location: /');
    exit;
}

// dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

// public/index.php 