<?php
session_start();
include('../config/database.php');

// Check if the trainer is logged in
if (!isset($_SESSION['trainer_id'])) {
    header('Location: ../login/trainer_login.php');
    exit();
}

// Fetch the trainer's trainees
$trainer_id = $_SESSION['trainer_id'];
$stmt = $pdo->prepare("SELECT m.member_id, m.name FROM member m
                        JOIN member_trainer mt ON m.member_id = mt.member_id
                        WHERE mt.trainer_id = :trainer_id");
$stmt->execute(['trainer_id' => $trainer_id]);
$trainees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = $_POST['member_id'];
    $day_of_week = $_POST['day_of_week'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Insert the schedule into the database
    $stmt = $pdo->prepare("INSERT INTO schedule (member_id, trainer_id, day_of_week, start_time, end_time) 
                            VALUES (:member_id, :trainer_id, :day_of_week, :start_time, :end_time)");
    $stmt->execute([
        'member_id' => $member_id,
        'trainer_id' => $trainer_id,
        'day_of_week' => $day_of_week,
        'start_time' => $start_time,
        'end_time' => $end_time,
    ]);

    echo "<script>alert('Schedule created successfully!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Personal Training</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Schedule Personal Training Session</h1>

    <a href="dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>
    <a href="../logout.php" class="btn btn-danger mb-3">Logout</a>

    <form method="post">
        <div class="mb-3">
            <label for="member_id" class="form-label">Select Trainee:</label>
            <select name="member_id" id="member_id" class="form-select" required>
                <option value="">Select a trainee</option>
                <?php foreach ($trainees as $trainee): ?>
                    <option value="<?php echo htmlspecialchars($trainee['member_id']); ?>">
                        <?php echo htmlspecialchars($trainee['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="day_of_week" class="form-label">Select Day:</label>
            <select name="day_of_week" id="day_of_week" class="form-select" required>
                <option value="">Select a day</option>
                <option value="Sunday">Sunday</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">From (Start Time):</label>
            <input type="time" name="start_time" id="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">To (End Time):</label>
            <input type="time" name="end_time" id="end_time" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Schedule Session</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
