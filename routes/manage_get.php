
<?php
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM events WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    
    if (!$event) {
        die("❌ Event ID $event_id Not Found in Database");
    }
    
    $stmt->close();
    $conn->close();
} else {
    die("❌ Event ID Not Provided");
}


renderView3('manage_get');