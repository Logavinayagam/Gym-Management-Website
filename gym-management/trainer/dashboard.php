<?php
session_start();
include('../config/database.php');

// Check if the trainer is logged in
if (!isset($_SESSION['trainer_id'])) {
    header('Location: ../login/trainer_login.php');
    exit();
}

// Get trainer's details (optional for displaying in the dashboard)
$trainer_id = $_SESSION['trainer_id'];
$stmt = $pdo->prepare("SELECT name FROM trainer WHERE trainer_id = :trainer_id");
$stmt->execute(['trainer_id' => $trainer_id]);
$trainer = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Dashboard</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Welcome, <?php echo htmlspecialchars($trainer['name']); ?>!</h1>

    <!-- Manage Trainees Card -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Manage Trainees</h5>
            <p class="card-text">View and manage your assigned trainees, update their personal details, or remove them from your list.</p>
            <a href="manage_trainee.php" class="btn btn-primary">Go to Trainees</a>
        </div>
    </div>

    <!-- Add Trainee Card -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Add Trainee</h5>
            <p class="card-text">Add an existing member as your trainee under your supervision.</p>
            <a href="add_trainee.php" class="btn btn-success">Add Trainee</a>
        </div>
    </div>

    <!-- Send Plan Card -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Send Training Plan</h5>
            <p class="card-text">Send personalized training plans to your trainees.</p>
            <a href="send_plan.php" class="btn btn-warning">Send Plan</a>
        </div>
    </div>

    <!-- Schedule Sessions Card -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Schedule Sessions</h5>
            <p class="card-text">Schedule training sessions with your trainees.</p>
            <a href="schedule.php" class="btn btn-info">Schedule Sessions</a>
        </div>
    </div>

    <!-- View Spotlight Card -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">View Spotlight</h5>
            <p class="card-text">Check out the latest spotlight announcements.</p>
            <a href="view_spotlight.php" class="btn btn-secondary">View Spotlight</a>
        </div>
    </div>

    <!-- Profile Management Card -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Profile Management</h5>
            <p class="card-text">View or update your personal profile details.</p>
            <a href="profile.php" class="btn btn-info">Manage Profile</a>
        </div>
    </div>

    <!-- Resource Details Card -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Equipment and Supplement Details</h5>
            <p class="card-text">View your Resource available .</p>
            <a href="view_resource.php" class="btn btn-danger">View Equipment & Supplement</a>
        </div>
    </div>

    <!-- Logout Card -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Logout</h5>
            <p class="card-text">Log out of your account to end your session securely.</p>
            <a href="../logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
