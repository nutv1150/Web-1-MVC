<?php
if (!isset($_SESSION['email'])) {
    echo "🔴 คุณยังไม่ได้ล็อกอิน!";
    header("Location: /login");
    exit;
}

$username = $_SESSION['username'] ?? 'Guest';

// เชื่อมต่อฐานข้อมูล
$conn = getConnection();

// ดึงข้อมูลอีเว้นท์ทั้งหมดโดยใช้ฟังก์ชัน getEvents()
$events = getEvents($conn);

// ดึงข้อมูลรูปภาพโดยใช้ฟังก์ชัน getImagesFromDatabase()
$images = getImagesFromDatabase($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Event Registration System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            color: #000;
            min-height: 110vh;
            display: flex;
            flex-direction: column;
            padding-bottom: 50px;
        }
        .event-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .event-card img {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 10px;
        }
        .event-card h4 {
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 15px;
        }
        .event-card p {
            font-size: 1em;
            margin: 10px 0;
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #1b2a41;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center mb-4">Available Events</h2>

    <!-- 🔍 Search Bar & Date Filter -->
    <div class="row mb-4">
        <div class="col-md-4">
            <input type="text" id="searchBar" class="form-control" placeholder="Search for events..." onkeyup="filterEvents()">
        </div>
        <div class="col-md-3">
            <input type="date" id="startDate" class="form-control" onchange="filterEvents()">
        </div>
        <div class="col-md-3">
            <input type="date" id="endDate" class="form-control" onchange="filterEvents()">
        </div>
    </div>

    <!-- Event Cards -->
    <div class="row row-cols-1 row-cols-md-3 g-4" id="eventList">
    <?php while ($event = $events->fetch_assoc()) { ?>
        <div class="col">
            <div class="event-card h-100">
                <?php
                    $eventTitle = htmlspecialchars($event['title']);
                    $eventId = $event['event_id']; 
                    $eventDate = htmlspecialchars($event['date']);

                    // ดึงรูปภาพตาม event_id แทน event_title
                    if (isset($images[$eventId]) && is_array($images[$eventId])) {
                        // ดึงแค่รูปแรกจากอาเรย์ของรูปภาพ
                        $firstImage = $images[$eventId][0];
                        echo "<img src='" . htmlspecialchars($firstImage) . "' alt='Event Image'>";
                    } else {
                        // หากไม่มีรูปภาพให้ใช้รูปภาพเริ่มต้นหรือแสดงข้อความ
                        echo "<img src='/path/to/default/image.jpg' alt='Default Event Image'>";
                    }

                    echo "<h4><a href='/select?id=" . $eventId . "' class='event-title'>" . $eventTitle . "</a></h4>";
                    echo "<p><strong>Date:</strong> " . $eventDate . "</p>";
                ?>
            </div>
        </div>
    <?php } ?>
</div>

</div>

<script>
function filterEvents() {
    let input = document.getElementById('searchBar').value.toLowerCase();
    let startDate = document.getElementById('startDate').value;
    let endDate = document.getElementById('endDate').value;
    let eventCards = document.getElementsByClassName('col');

    for (let i = 0; i < eventCards.length; i++) {
        let title = eventCards[i].querySelector('.event-title').innerText.toLowerCase();
        let eventDate = eventCards[i].querySelector('p strong').nextSibling.nodeValue.trim();

        let showTitleMatch = title.includes(input);
        let showDateMatch = true;

        if (startDate && endDate) {
            showDateMatch = (eventDate >= startDate) && (eventDate <= endDate);
        } else if (startDate) {
            showDateMatch = eventDate >= startDate;
        } else if (endDate) {
            showDateMatch = eventDate <= endDate;
        }

        if (showTitleMatch && showDateMatch) {
            eventCards[i].style.display = "block";
        } else {
            eventCards[i].style.display = "none";
        }
    }
}
</script>

</body>
</html>
