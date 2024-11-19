<?php
session_start();
include('../config/database.php');

// Check if the owner is logged in
if (!isset($_SESSION['owner_id'])) {
    header('Location: ../login/owner_login.php');
    exit();
}

// Check if trainer_id is set
if (!isset($_GET['trainer_id'])) {
    header('Location: view_trainers.php');
    exit();
}

$trainer_id = $_GET['trainer_id'];

// Fetch trainer details
$stmt = $pdo->prepare("SELECT * FROM trainer WHERE trainer_id = ?");
$stmt->execute([$trainer_id]);
$trainer = $stmt->fetch();

if (!$trainer) {
    echo "Trainer not found.";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $date_of_birth = $_POST['date_of_birth'];
    $grade = $_POST['grade'];
    $is_certified = isset($_POST['is_certified']) ? 1 : 0;
    $upi_id = $_POST['upi_id'];

    // Update trainer details
    $stmt = $pdo->prepare("UPDATE trainer SET name = ?, phone_number = ?, date_of_birth = ?, grade = ?, is_certified = ?, upi_id = ? WHERE trainer_id = ?");
    $stmt->execute([$name, $phone_number, $date_of_birth, $grade, $is_certified, $upi_id, $trainer_id]);

    // Redirect with success message
    $_SESSION['success_message'] = "Trainer updated successfully!";
    header('Location: view_trainers.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Trainer</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2>Edit Trainer</h2>

        <form method="POST" action="update_trainer.php?trainer_id=<?php echo $trainer_id; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Trainer Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($trainer['name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number:</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($trainer['phone_number']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Date of Birth:</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($trainer['date_of_birth']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="grade" class="form-label">Select Grade:</label>
                <select class="form-select" id="grade" name="grade" required>
                    <option value="Grade 1" <?php if ($trainer['grade'] == 'Grade 1') echo 'selected'; ?>>Grade 1</option>
                    <option value="Grade 2" <?php if ($trainer['grade'] == 'Grade 2') echo 'selected'; ?>>Grade 2</option>
                    <option value="Assistant" <?php if ($trainer['grade'] == 'Assistant') echo 'selected'; ?>>Assistant</option>
                </select>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_certified" name="is_certified" <?php if ($trainer['is_certified']) echo 'checked'; ?>>
                <label class="form-check-label" for="is_certified">Certified Trainer</label>
            </div>

            <div class="mb-3">
                <label for="upi_id" class="form-label">UPI ID:</label>
                <input type="text" class="form-control" id="upi_id" name="upi_id" value="<?php echo htmlspecialchars($trainer['upi_id']); ?>">
            </div>

            <button type="submit" class="btn btn-success">Update Trainer</button>
            <a href="view_trainers.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <!-- Optional: Bootstrap JS for interactive components -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
