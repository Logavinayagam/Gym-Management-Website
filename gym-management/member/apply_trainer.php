<?php
session_start();
include('../config/database.php');

// Check if the member is logged in
if (!isset($_SESSION['member_id'])) {
    header('Location: ../login/member_login.php');
    exit();
}

// Fetch available trainers from the database
$stmt = $pdo->prepare("SELECT trainer_id, name, phone_number, grade, upi_id FROM trainer WHERE trainer_id NOT IN (SELECT trainer_id FROM member_trainer WHERE member_id = :member_id)");
$stmt->execute(['member_id' => $_SESSION['member_id']]);
$trainers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle trainer application request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apply_trainer'])) {
    $selected_trainer_id = $_POST['trainer_id'];
    $member_id = $_SESSION['member_id'];

    // Insert the application into the member_trainer table
    $insert_stmt = $pdo->prepare("INSERT INTO member_trainer (member_id, trainer_id) VALUES (:member_id, :trainer_id)");
    if ($insert_stmt->execute(['member_id' => $member_id, 'trainer_id' => $selected_trainer_id])) {
        echo "<script>alert('Trainer application submitted successfully!');</script>";
    } else {
        echo "<script>alert('Failed to apply for the trainer. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Personal Trainer</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Request Personal Trainer</h1>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="trainer_id" class="form-label">Select Trainer</label>
            <select name="trainer_id" id="trainer_id" class="form-select" required>
                <option value="" disabled selected>Select a trainer</option>
                <?php foreach ($trainers as $trainer): ?>
                    <option value="<?php echo htmlspecialchars($trainer['trainer_id']); ?>">
                        <?php echo htmlspecialchars($trainer['name'] . ' - ' . $trainer['grade']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="apply_trainer" class="btn btn-primary">Apply for Trainer</button>
    </form>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
