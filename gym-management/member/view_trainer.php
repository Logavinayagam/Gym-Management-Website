<?php
session_start();
include('../config/database.php');

// Check if the member is logged in
if (!isset($_SESSION['member_id'])) {
    header('Location: ../login/member_login.php');
    exit();
}

// Fetch member's trainer information
$member_id = $_SESSION['member_id'];
$stmt = $pdo->prepare("SELECT t.trainer_id, t.name, t.age, t.email, t.grade, t.is_certified, t.phone_number, t.upi_id 
                        FROM trainer t 
                        JOIN member_trainer m ON t.trainer_id = m.trainer_id 
                        WHERE m.member_id = :member_id");
$stmt->execute(['member_id' => $member_id]);
$trainer = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Trainer</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Your Assigned Trainer</h1>

    <?php if ($trainer): ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Trainer Name: <?php echo htmlspecialchars($trainer['name']); ?></h5>
                <p class="card-text"><strong>Age:</strong> <?php echo htmlspecialchars($trainer['age']); ?></p>
                <p class="card-text"><strong>Grade:</strong> <?php echo htmlspecialchars($trainer['grade']); ?></p>
                <p class="card-text"><strong>Certified:</strong> <?php echo htmlspecialchars($trainer['is_certified'] ? 'Yes' : 'No'); ?></p>
                <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($trainer['email']); ?></p>
                <p class="card-text"><strong>Contact Number:</strong> <?php echo htmlspecialchars($trainer['phone_number']); ?></p>
                <p class="card-text"><strong>UPI ID:</strong> <?php echo htmlspecialchars($trainer['upi_id']); ?></p>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">You do not have an assigned trainer yet.</div>
    <?php endif; ?>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
