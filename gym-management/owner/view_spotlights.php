<?php
session_start();
include('../config/database.php');

// Check if the owner is logged in
if (!isset($_SESSION['owner_id'])) {
    header('Location: owner_login.php');
    exit();
}

// Fetch spotlight data from the database
$stmt = $pdo->query("SELECT * FROM spotlight");
$spotlights = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Spotlights</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Manage Spotlights</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Spotlight ID</th>
                <th>Content</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($spotlights as $spotlight): ?>
                <tr>
                    <td><?php echo htmlspecialchars($spotlight['spotlight_id']); ?></td>
                    <td><?php echo htmlspecialchars($spotlight['content']); ?></td>
                    <td><?php echo htmlspecialchars($spotlight['start_date']); ?></td>
                    <td><?php echo htmlspecialchars($spotlight['end_date']); ?></td>
                    <td>
                        <a href="edit_spotlight.php?id=<?php echo $spotlight['spotlight_id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="delete_spotlight.php?id=<?php echo $spotlight['spotlight_id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="add_spotlight.php" class="btn btn-primary">Add Spotlight</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
