<?php
session_start();
include('../config/database.php');

// Check if the user is a trainer or member
if (!isset($_SESSION['trainer_id']) && !isset($_SESSION['member_id'])) {
    header('Location: ../login/trainer_login.php');
    exit();
}

// Fetch equipment data
$stmt_equipment = $pdo->query("SELECT name, quantity, `condition`, maintenance_date, location FROM equipment");
$equipment = $stmt_equipment->fetchAll(PDO::FETCH_ASSOC);

// Fetch supplement data
$stmt_supplement = $pdo->query("SELECT name, type, quantity, expiration_date, supplier FROM supplement");
$supplements = $stmt_supplement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Resources</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Available Resources</h1>

    <!-- Equipment Table -->
    <h3>Equipment</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Condition</th>
                <th>Maintenance Date</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($equipment as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                <td><?php echo htmlspecialchars($item['condition']); ?></td>
                <td><?php echo htmlspecialchars($item['maintenance_date']); ?></td>
                <td><?php echo htmlspecialchars($item['location']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Supplements Table -->
    <h3>Supplements</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Expiration Date</th>
                <th>Supplier</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($supplements as $supplement): ?>
            <tr>
                <td><?php echo htmlspecialchars($supplement['name']); ?></td>
                <td><?php echo htmlspecialchars($supplement['type']); ?></td>
                <td><?php echo htmlspecialchars($supplement['quantity']); ?></td>
                <td><?php echo htmlspecialchars($supplement['expiration_date']); ?></td>
                <td><?php echo htmlspecialchars($supplement['supplier']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
