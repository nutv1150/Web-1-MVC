<?php

function getConnection():mysqli
{
    $hostname = 'localhost';
    $dbName = 'eventmanagement';
    $username = 'Event';
    $password = 'abc123';
    $conn = new mysqli($hostname, $username, $password, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}


require_once DATABASE_DIR . '/organizer.php';
require_once DATABASE_DIR . '/authen.php';
require_once DATABASE_DIR . '/user.php';
require_once DATABASE_DIR . '/event.php';
require_once DATABASE_DIR . '/event_ptcp.php';
// includes/db.php 