<?php
session_start();
include('../config/database.php');

// Check if the member is already logged in
if (isset($_SESSION['member_id'])) {
    header('Location: ../member/dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone']; // Changed from email to phone
    $password = $_POST['password'];

    // Query to check the member credentials using phone number
    $stmt = $pdo->prepare("SELECT * FROM member WHERE phone_number = ?"); // Changed to phone_number
    $stmt->execute([$phone]);
    $member = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password
    if ($member && $member['password'] === $password) { // Changed verification method to match your requirements
        $_SESSION['member_id'] = $member['member_id'];
        header('Location: ../member/dashboard.php');
        exit();
    } else {
        $error = "Invalid phone number or password."; // Updated error message
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Login</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Member Login</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label> <!-- Changed from Email Address to Phone Number -->
            <input type="text" class="form-control" id="phone" name="phone" required> <!-- Changed from email to phone -->
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <p class="mt-3">Not a member? <a href="signup.php">Sign Up Here</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
