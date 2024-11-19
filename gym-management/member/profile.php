<?php
session_start();
include('../config/database.php');

// Check if the member is logged in
if (!isset($_SESSION['member_id'])) {
    header('Location: ../login/member_login.php');
    exit();
}

// Fetch member's information
$member_id = $_SESSION['member_id'];
$stmt = $pdo->prepare("SELECT * FROM member WHERE member_id = :member_id");
$stmt->execute(['member_id' => $member_id]);
$member = $stmt->fetch(PDO::FETCH_ASSOC);

// Update profile logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $password = $_POST['password'] ? $_POST['password'] : $member['password']; // No hashing

    $updateStmt = $pdo->prepare("UPDATE member SET name = :name, email = :email, phone_number = :phone_number, height = :height, weight = :weight, password = :password WHERE member_id = :member_id");
    
    if ($updateStmt->execute([
        'name' => $name,
        'email' => $email,
        'phone_number' => $phone_number,
        'height' => $height,
        'weight' => $weight,
        'password' => $password,
        'member_id' => $member_id
    ])) {
        $success_message = "Profile updated successfully!";
    } else {
        $error_message = "Error updating profile.";
    }

    // Refresh the member data
    $stmt->execute(['member_id' => $member_id]);
    $member = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Profile</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Member Profile</h1>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <form action="profile.php" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($member['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($member['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($member['phone_number']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="height" class="form-label">Height (cm)</label>
            <input type="number" class="form-control" id="height" name="height" value="<?php echo htmlspecialchars($member['height']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="weight" class="form-label">Weight (kg)</label>
            <input type="number" class="form-control" id="weight" name="weight" value="<?php echo htmlspecialchars($member['weight']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Change Password (leave blank to keep current)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
