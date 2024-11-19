<?php
session_start();
include('../config/database.php');

// Check if the trainer is logged in
if (!isset($_SESSION['trainer_id'])) {
    header('Location: ../login/trainer_login.php');
    exit();
}

// Fetch the trainer's members
$trainer_id = $_SESSION['trainer_id'];
$stmt = $pdo->prepare("SELECT m.member_id, m.name, m.email, m.phone_number FROM member m
                        JOIN member_trainer mt ON m.member_id = mt.member_id
                        WHERE mt.trainer_id = :trainer_id");
$stmt->execute(['trainer_id' => $trainer_id]);
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Members</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Members Assigned to You</h1>

    

    <?php if (count($members) > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Member ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($members as $member): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($member['member_id']); ?></td>
                        <td><?php echo htmlspecialchars($member['name']); ?></td>
                        <td><?php echo htmlspecialchars($member['email']); ?></td>
                        <td><?php echo htmlspecialchars($member['phone_number']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No members assigned to you.</p>
    <?php endif; ?>

    <a href="dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
