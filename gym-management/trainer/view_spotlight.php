<?php
session_start();
include('../config/database.php');

// Check if the trainer is logged in
if (!isset($_SESSION['trainer_id'])) {
    header('Location: ../login/trainer_login.php');
    exit();
}

// Fetch spotlight posts
$stmt = $pdo->prepare("SELECT * FROM spotlight ORDER BY start_date DESC");
$stmt->execute();
$spotlights = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Spotlight</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Today's Spotlight</h1>

    <a href="dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>
    

    <?php if (empty($spotlights)): ?>
        <div class="alert alert-info" role="alert">
            No spotlight posts available at the moment.
        </div>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($spotlights as $spotlight): ?>
                <div class="list-group-item">
                    <h5 class="mb-1"><?php echo htmlspecialchars($spotlight['title']); ?></h5>
                    <p class="mb-1"><?php echo htmlspecialchars($spotlight['content']); ?></p>
                    <small class="text-muted">Posted on: <?php echo htmlspecialchars($spotlight['start_date']); ?></small>
                    <small class="text-muted">Available till: <?php echo htmlspecialchars($spotlight['end_date']); ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
