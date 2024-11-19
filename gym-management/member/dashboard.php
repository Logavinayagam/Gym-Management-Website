<?php
session_start();
include('../config/database.php');

// Check if the member is logged in
if (!isset($_SESSION['member_id'])) {
    header('Location: ../login/member_login.php');
    exit();
}

// Fetch member information
$member_id = $_SESSION['member_id'];
$stmt = $pdo->prepare("SELECT * FROM member WHERE member_id = ?");
$stmt->execute([$member_id]);
$member = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Welcome, <?php echo htmlspecialchars($member['name']); ?>!</h1>
    <h4>Your Member ID: <?php echo htmlspecialchars($member['member_id']); ?></h4>

    <!-- View Spotlight Card -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">View Spotlight</h5>
            <p class="card-text">Check out the latest spotlight announcements.</p>
            <a href="view_spotlight.php" class="btn btn-secondary">View Spotlight</a>
        </div>
    </div>

    <!-- Edit Profile Card -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Edit Profile</h5>
            <p class="card-text">Update your personal details and preferences.</p>
            <a href="profile.php" class="btn btn-info">Edit Profile</a>
        </div>
    </div>

    <!-- Membership Expiry Card -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Membership Expiry Date</h5>
            <p class="card-text">View your membership expiry date and renew if necessary.</p>
            <a href="membership_expire.php" class="btn btn-primary">View Expiry Date</a>
        </div>
    </div>

    <!-- Apply for Personal Trainer Card -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Apply for Personal Trainer</h5>
            <p class="card-text">Apply for a personal trainer to enhance your fitness journey.</p>
            <a href="apply_trainer.php" class="btn btn-success">Apply for Trainer</a>
        </div>
    </div>

    <!-- View Trainer Card -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">View Trainer</h5>
            <p class="card-text">Browse and select from our available trainers.</p>
            <a href="view_trainer.php" class="btn btn-warning">View Trainers</a>
        </div>
    </div>

    <!-- View Plan Card -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">View Plan</h5>
            <p class="card-text">Review your current training plan.</p>
            <a href="view_plan.php" class="btn btn-info">View My Plan</a>
        </div>
    </div>

    <!-- View Schedule Card -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">View Schedule</h5>
            <p class="card-text">Check your upcoming training schedule.</p>
            <a href="view_schedule.php" class="btn btn-secondary">View Schedule</a>
        </div>
    </div>

    <!-- Membership and Payment Details Card -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Membership and Payment Details</h5>
            <p class="card-text">View your membership status and payment history.</p>
            <a href="pay_fees.php" class="btn btn-danger">View Payment Details</a>
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
