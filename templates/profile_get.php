<?php

$conn = getConnection();

$user_id = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? "Guest";
$email = $_SESSION['email'] ?? "Not provided";
$birthday = $_SESSION['birthday'] ?? null;

if (!$user_id) {
    die("User not logged in.");
}

// ฟังก์ชันคำนวณอายุจากวันเกิด
function calculateAge($birthday) {
    if (!$birthday) return "Unknown";
    $birthdayDate = new DateTime($birthday);
    $currentDate = new DateTime();
    return $birthdayDate->diff($currentDate)->y;
}
$age = calculateAge($birthday);

// ดึง Event ที่ผู้ใช้เข้าร่วมพร้อมสถานะ
$events = getUserEventsToShowProfile($conn, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body {
        font-family: sans-serif;
    }

    .event-item {
        padding: 15px;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .event-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .event-placeholder {
        width: 100%;
        height: 150px;
        background-color: #f0f0f0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
<body class="bg-light">

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Profile</h2>
                        <p class="card-text"><strong>ID:</strong> <?= htmlspecialchars($user_id); ?></p>
                        <p class="card-text"><strong>Username:</strong> <?= htmlspecialchars($username); ?></p>
                        <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($email); ?></p>
                        <p class="card-text"><strong>Age:</strong> <?= htmlspecialchars($age); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mt-4 mt-md-0">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title mb-4">My Events</h2>
                        <div class="row">
                            <?php if (!empty($events)): ?>
                                <?php foreach ($events as $event): ?>
                                    <div class="col-md-6 mb-4">
                                        <div class="event-item rounded border shadow"> <h5 class="mb-3"><?= htmlspecialchars($event['title']); ?></h5>
                                            <p class="mb-2">Date: <?= htmlspecialchars($event['date']); ?></p>
                                            <div class="d-flex justify-content-center">
                                                <span class="badge
                                                    <?php
                                                        if ($event['checked_in'] == 0) echo ' bg-warning text-dark'; // Pending
                                                        elseif ($event['checked_in'] == 1) echo ' bg-danger'; // Rejected
                                                        elseif ($event['checked_in'] == 3) echo ' bg-success'; // Accepted
                                                        elseif ($event['checked_in'] == 4) echo ' bg-primary'; // Checked-in (ใหม่)
                                                    ?>">
                                                    <?= 
                                                        ($event['checked_in'] == 0) ? 'Pending' : 
                                                        (($event['checked_in'] == 1) ? 'Rejected' : 
                                                        (($event['checked_in'] == 3) ? 'Accepted' : 
                                                        (($event['checked_in'] == 4) ? 'Checked-in' : 'Unknown'))); 
                                                    ?>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12">
                                    <p class="text-muted">No events joined yet.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>