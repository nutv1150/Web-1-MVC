<?php
function insertEventParticipant($conn, $event_id, $user_id) {
    // ✅ เช็คว่าผู้ใช้เคยสมัคร Event นี้แล้วหรือยัง
    $sql = "SELECT COUNT(*) as count FROM event_participant WHERE event_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($result['count'] > 0) {
        return "You have already requested to join this event.";
    }

    // ✅ ดึงจำนวนที่รองรับจากตาราง events
    $sql = "SELECT participant_limit FROM events WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $event = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$event) {
        return "Event not found.";
    }

    $participant_limit = $event['participant_limit'];

    // ✅ นับจำนวนคนที่ `checked_in = 3` (Confirmed) ในอีเวนต์นี้
    $sql = "SELECT COUNT(*) as count FROM event_participant WHERE event_id = ? AND checked_in = 3";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $confirmed_count = $result['count'];

    // ✅ ถ้าคนเข้าร่วมถึงจำนวนสูงสุดแล้ว ให้ปฏิเสธ
    if ($confirmed_count >= $participant_limit) {
        return "Event is full. Your request has been rejected.";
    }

    // ✅ ถ้ายังไม่เต็ม ให้เพิ่มข้อมูล
    $sql = "INSERT INTO event_participant (event_id, user_id, checked_in, status) VALUES (?, ?, 0, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $event_id, $user_id);

    if ($stmt->execute()) {
        $stmt->close();
        return "Request sent successfully!";
    } else {
        $stmt->close();
        return "Error adding participant.";
    }
}




function getPendingParticipants($conn, $event_id) {
    if (!$event_id) {
        return []; // คืนค่าเป็น array ว่างถ้าไม่มี event_id
    }

    // SQL Query เพื่อดึงข้อมูลเฉพาะ Pending
    $sql = "SELECT user_id, checked_in, status FROM event_participant WHERE event_id = ? AND status = 'Pending'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // ดึงข้อมูลแล้วเก็บใน array
    $participants = [];
    while ($row = $result->fetch_assoc()) {
        $participants[] = $row;
    }

    $stmt->close();
    return $participants;
}

function updateParticipantStatus($conn, $event_id, $user_id, $checked_in, $status) {
    $sql = "UPDATE event_participant SET checked_in = ?, status = ? WHERE event_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error); // แสดง error ถ้าคำสั่ง SQL ไม่ถูกต้อง
    }

    $stmt->bind_param("issi", $checked_in, $status, $event_id, $user_id);
    
    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Error updating DB: " . $stmt->error);
        return false;
    }
}

function getUserEventsToShowProfile($conn, $user_id) {
    $sql = "SELECT e.event_id, e.title, e.date, ep.checked_in, ep.status
            FROM event_participant ep
            JOIN events e ON ep.event_id = e.event_id
            WHERE ep.user_id = ?";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error in SQL statement: " . $conn->error);
    }
    
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $events = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $events;
}
function getApprovedParticipants($conn, $event_id) {
    $sql = "SELECT * FROM event_participant WHERE event_id = ? AND status = 'Confirmed'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function isEventFull($conn, $event_id) {
    $sql = "SELECT COUNT(*) as count FROM event_participant WHERE event_id = ? AND status = 'Confirmed'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // ดึงจำนวนที่รองรับจากตาราง event
    $sql = "SELECT participant_limit FROM events WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $event = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return ($result['count'] >= $event['participant_limit']); // ถ้าถึงจำนวนสูงสุด return true
}


?>

