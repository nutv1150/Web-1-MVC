<?php
function getUserEvents($user_id) {
    $conn = getConnection();
    $sql = "SELECT * FROM events WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();
    return $result;
}

function getEventImages() {
    $conn = getConnection();
    $sql = "SELECT * FROM image";
    $result = $conn->query($sql);
    $images = [];
    while ($row = $result->fetch_assoc()) {
        $images[$row['event_title']] = $row['url'];
    }
    $conn->close();
    return $images;
}

function getEventById($event_id) {
    $conn = getConnection(); // ตรวจสอบว่า getConnection() มีอยู่แล้ว
    $stmt = $conn->prepare("SELECT * FROM events WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $event;
}
