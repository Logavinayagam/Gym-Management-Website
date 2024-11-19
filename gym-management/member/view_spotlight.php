<?php
session_start();
include('../config/database.php');

// Check if the member is logged in
if (!isset($_SESSION['member_id'])) {
    header('Location: ../login/member_login.php');
    exit();
}

// Fetch spotlight posts from the database
$stmt = $pdo->prepare("SELECT * FROM spotlight ORDER BY start_date DESC");
$stmt->execute();
$spotlights = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotlight</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Today's Spotlight</h1>

    <?php if (count($spotlights) > 0): ?>
        <div class="list-group">
            <?php foreach ($spotlights as $spotlight): ?>
                <div class="list-group-item">
                    <h5 class="mb-1"><?php echo htmlspecialchars($spotlight['title']); ?></h5>
                    <p class="mb-1"><?php echo htmlspecialchars($spotlight['content']); ?></p>
                    <small>Posted on: <?php echo htmlspecialchars(date('F j, Y', strtotime($spotlight['start_date']))); ?></small>
                    <small>Available till : <?php echo htmlspecialchars(date('F j, Y', strtotime($spotlight['end_date']))); ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            No spotlight posts available at the moment.
        </div>
    <?php endif; ?>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
