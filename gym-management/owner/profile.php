<?php
session_start();
include('../config/database.php');

// Check if the owner is logged in
if (!isset($_SESSION['owner_id'])) {
    header('Location: ../login/owner_login.php');
    exit();
}

$owner_id = $_SESSION['owner_id'];

// Fetch owner details from the database
$stmt = $pdo->prepare("SELECT * FROM owner WHERE owner_id = ?");
$stmt->execute([$owner_id]);
$owner = $stmt->fetch();

// If the form is submitted, update the owner’s details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $owner_upi = $_POST['owner_upi']; // New UPI field
    $password = $_POST['password'];

    // If password is not empty, update it
    if (!empty($password)) {
       
        $stmt = $pdo->prepare("UPDATE owner SET name = ?, email = ?, phone_number = ?, upi_id = ?, password = ? WHERE owner_id = ?");
        $stmt->execute([$name, $email, $phone, $owner_upi, $password, $owner_id]);
    } else {
        // If password is not changed, exclude it from the update
        $stmt = $pdo->prepare("UPDATE owner SET name = ?, email = ?, phone_number = ?, upi_id = ?, password = ? WHERE owner_id = ?");
        $stmt->execute([$name, $email, $phone, $owner_upi, $owner_id]);
    }

    echo "<script>alert('Profile updated successfully!'); window.location.href = 'dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Profile</title>
</head>
<body>

    <h2>Profile Management</h2>

    <form method="POST" action="profile.php">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($owner['name']); ?>" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($owner['email']); ?>" required><br><br>

        <label for="phone">Phone Number:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($owner['phone_number']); ?>" required><br><br>

        <label for="owner_upi">Owner UPI ID:</label><br>
        <input type="text" id="owner_upi" name="owner_upi" value="<?php echo htmlspecialchars($owner['upi_id']); ?>" required><br><br>

        <label for="password">Password (Leave blank if you don't want to change):</label><br>
        <input type="password" id="password" name="password"><br><br>

        <button type="submit">Update Profile</button>
    </form>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
