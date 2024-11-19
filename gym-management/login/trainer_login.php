<?php
session_start();
include('../config/database.php');

// Check if the trainer is already logged in
if (isset($_SESSION['trainer_id'])) {
    header('Location: ../trainer/dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'];  // Using phone number instead of email
    $password = $_POST['password'];

    // Query to check the trainer credentials based on phone number
    $stmt = $pdo->prepare("SELECT * FROM trainer WHERE phone_number = ?");
    $stmt->execute([$phone]);
    $trainer = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password (plain password as per your requirement)
    if ($trainer && $password === $trainer['password']) {
        $_SESSION['trainer_id'] = $trainer['trainer_id'];
        header('Location: ../trainer/dashboard.php');
        exit();
    } else {
        $error = "Invalid phone number or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Login</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Trainer Login</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <p class="mt-3">Not a trainer? <a href="../login/member_login.php">Login as Member</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
