<?php
session_start();
include('../config/database.php');

// Check if the trainer is logged in
if (!isset($_SESSION['trainer_id'])) {
    header('Location: ../login/trainer_login.php');
    exit();
}

// Get the trainer's details from the database
$trainer_id = $_SESSION['trainer_id'];
$stmt = $pdo->prepare("SELECT * FROM trainer WHERE trainer_id = :trainer_id");
$stmt->execute(['trainer_id' => $trainer_id]);
$trainer = $stmt->fetch(PDO::FETCH_ASSOC);

// Update trainer's profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // If the password field is not empty, update the password
    if (!empty($password)) {
        $stmt_update = $pdo->prepare("UPDATE trainer SET name = :name, email = :email, phone_number = :phone, password = :password WHERE trainer_id = :trainer_id");
        $stmt_update->execute([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password, // Not hashed as per your request
            'trainer_id' => $trainer_id
        ]);
    } else {
        // If the password is not updated, skip it in the query
        $stmt_update = $pdo->prepare("UPDATE trainer SET name = :name, email = :email, phone_number = :phone WHERE trainer_id = :trainer_id");
        $stmt_update->execute([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'trainer_id' => $trainer_id
        ]);
    }

    // Redirect to profile page with a success message
    header("Location: profile.php?status=success");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Profile Management</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Trainer Profile</h1>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success" role="alert">
            Profile updated successfully!
        </div>
    <?php endif; ?>

    <form action="profile.php" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($trainer['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($trainer['email']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($trainer['phone_number']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Change Password (Leave blank if not changing)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Go to Dashboard</a>
    <a href="../logout.php" class="btn btn-danger mt-3">Logout</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
