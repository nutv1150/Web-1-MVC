<?php

if (!isset($_SESSION['user_id'])) {
    echo "🔴 คุณยังไม่ได้ล็อกอิน!";
    header("Location: /login");
    exit;
}

$user_id = $_SESSION['user_id']; // ดึง user_id จาก session
$events = getUserEvents($user_id);
$images = getEventImages();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> <!-- Bootstrap Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #2f4663;
            color: white;
        }
        .navbar {
            background-color: #1b2a41;
        }
        .event-card {
            width: 100%;
            background-color: #d6c4b2;
            padding: 20px;
            border-radius: 10px;
            margin: 10px;
            color: black;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .event-card img {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .event-card .card-content {
            text-align: left;
            width: 100%;
        }

        .not-found {
            text-align: center;
            margin-top: 20px;
            font-size: 1.5em;
            color: #ff6b6b;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Events You Created</h2>
        <?php if ($events->num_rows > 0) { ?>
            <div class="row d-flex flex-wrap">
                <?php while ($event = $events->fetch_assoc()) { ?>
                    <div class="col-md-6">
                        <a href="/manage?event_id=<?php echo $event['event_id']; ?>">
                            <div class="event-card">
                                <?php 
                                $eventTitle = $event['title'];
                                if (isset($images[$eventTitle])) { ?>
                                    <img src="<?php echo htmlspecialchars($images[$eventTitle]); ?>" alt="Event Image">
                                <?php } ?>
                                <div class="card-content">
                                    <h4><strong>Event:</strong><?php echo htmlspecialchars($event['title']); ?></h4>
                                    <p><strong>Description:</strong><?php echo htmlspecialchars($event['description']); ?></p>
                                    <p><strong>Date:</strong> <?php echo htmlspecialchars($event['date']); ?></p>
                                    <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                                    
                                    <!-- ปุ่ม Delete ใช้ Bootstrap -->
                                    <a href="/delete_event?id=<?= $event['event_id'] ?>" class="btn btn-danger mt-2" onclick="return confirmSubmission()">
                                        <i class="bi bi-trash"></i> Delete Event
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p class="not-found"> You don't have any events yet!</p>
        <?php } ?>
    </div>

    <script>
    function confirmSubmission() {
        return confirm("Are you sure you want to delete this event?");
    }
    </script>
</body>
</html>
