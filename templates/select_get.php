<?php
$conn = getConnection();
$userId = $_SESSION['user_id'];
$eventId = $_GET['id']; // รับ event_id จาก query string

$events = getEventsByEventId($conn, $userId, $eventId); // ดึงข้อมูลอีเว้นต์
$images = getImagesFromDatabase2($conn); // ดึงข้อมูลรูปภาพ
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            color: #000;
        }
        .event-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .event-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .event-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .event-info {
            font-size: 1.1rem;
            margin: 10px 0;
        }
        .btn-join {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 1.2rem;
            border-radius: 50px;
            transition: background 0.3s;
        }
        .btn-join:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="event-container">
            <?php
                if ($events->num_rows > 0) {
                    $event = $events->fetch_assoc();
                    $eventTitle = htmlspecialchars($event['title']);
                    
                    echo "<h1 class='event-title'>" . $eventTitle . "</h1>";

                    // ✅ แสดงรูปภาพทั้งหมดของ Event นี้
                    echo '<div class="row">';

                    if (!empty($images[$eventId])) { 
                        foreach ($images[$eventId] as $imageUrl) {
                            echo '<div class="col-md-6">
                                    <img src="' . htmlspecialchars($imageUrl) . '" class="event-image" alt="Event Image">
                                  </div>';
                        }
                    } else {
                        echo '<div class="col-12">
                                <img src="default-placeholder.jpg" class="event-image" alt="No Image Available">
                              </div>';
                    }

                    echo '</div>'; // ปิด row

                    echo "<p class='event-info'><strong>Date:</strong> " . htmlspecialchars($event['date']) . "</p>";
                    echo "<p class='event-info'><strong>Location:</strong> " . htmlspecialchars($event['location']) . "</p>";
                } else {
                    echo "<p>Event not found.</p>";
                }
            ?>

            <!-- Join Event Button -->
            <form action="select" method="POST">
                <input type="hidden" name="userId" value="<?php echo htmlspecialchars($userId); ?>">
                <input type="hidden" name="eventId" value="<?php echo htmlspecialchars($eventId); ?>">
                <input type="hidden" name="checked_id" value="0">
                <button type="submit" class="btn btn-join mt-3">Join Event</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>