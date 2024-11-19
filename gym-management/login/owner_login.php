<?php
session_start();
include('../config/database.php');

// Check if the owner is already logged in
if (isset($_SESSION['owner_id'])) {
    header('Location: ../owner/dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Query to check the owner credentials based on phone number
    $stmt = $pdo->prepare("SELECT * FROM owner WHERE phone_number = ?");
    $stmt->execute([$phone]);
    $owner = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if owner exists and verify if the phone number matches the password (as per the requirements)
    if ($owner && $password === $owner['phone_number']) {
        // Set session with owner ID
        $_SESSION['owner_id'] = $owner['owner_id'];

        // Redirect to owner dashboard
        header('Location: ../owner/dashboard.php');
        exit();
    } else {
        $error = "Invalid Phone Number or Password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Login</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Owner Login</h1>

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

    <p class="mt-3">Not an owner? <a href="../login/member_login.php">Login as Member</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
