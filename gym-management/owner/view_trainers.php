<?php
session_start();
include('../config/database.php');

// Check if the owner is logged in
if (!isset($_SESSION['owner_id'])) {
    header('Location: ../login/owner_login.php');
    exit();
}

// Fetch all trainers from the database
$stmt = $pdo->prepare("SELECT trainer_id, name, phone_number, date_of_birth, age, grade, is_certified, upi_id FROM trainer ORDER BY trainer_id ASC");
$stmt->execute();
$trainers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Trainers</title>
    <!-- Link to your custom styles or Bootstrap for better styling -->
    <link rel="stylesheet" href="../public/css/style.css">
    <!-- Optional: Bootstrap CSS for enhanced styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2 class="mb-4">All Trainers</h2>

        <?php if (count($trainers) > 0): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Trainer ID</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Date of Birth</th>
                        <th>Age</th>
                        <th>Grade</th>
                        <th>Certified</th>
                        <th>UPI ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trainers as $trainer): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($trainer['trainer_id']); ?></td>
                        <td><?php echo htmlspecialchars($trainer['name']); ?></td>
                        <td><?php echo htmlspecialchars($trainer['phone_number']); ?></td>
                        <td><?php echo htmlspecialchars($trainer['date_of_birth']); ?></td>
                        <td><?php echo htmlspecialchars($trainer['age']); ?></td>
                        <td><?php echo htmlspecialchars($trainer['grade']); ?></td>
                        <td><?php echo $trainer['is_certified'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo htmlspecialchars($trainer['upi_id']); ?></td>
                        <td>
                            <a href="update_trainer.php?trainer_id=<?php echo $trainer['trainer_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="delete_trainer.php?trainer_id=<?php echo $trainer['trainer_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this trainer?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                No trainers found.
            </div>
        <?php endif; ?>

        <br>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <!-- Optional: Bootstrap JS for interactive components -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
