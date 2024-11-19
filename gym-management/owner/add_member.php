<?php
session_start();
include('../config/database.php');

// Check if the owner is logged in
if (!isset($_SESSION['owner_id'])) {
    header('Location: ../login/owner_login.php');
    exit();
}

// Handle form submission for adding a new member
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $location = $_POST['location'];

    try {
        // Check if the phone number is already used by another member
        $stmt = $pdo->prepare("SELECT * FROM member WHERE phone_number = ?");
        $stmt->execute([$phone]);
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Phone number already exists!'); window.location.href = 'add_member.php';</script>";
            exit();
        }

        // Generate a new member_id
        $result = $pdo->query("SELECT COUNT(*) AS total FROM member");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $new_id = "JRM" . str_pad($row['total'] + 1, 3, '0', STR_PAD_LEFT);

        // Insert the new member into the database
        $stmt = $pdo->prepare("INSERT INTO member (member_id, name, height, weight, phone_number, date_of_birth, location) 
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$new_id, $name, $height, $weight, $phone, $dob, $location]);

        echo "<script>alert('Member added successfully! Member ID: $new_id'); window.location.href = 'dashboard.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error adding member: " . $e->getMessage() . "'); window.location.href = 'add_member.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Member</title>
</head>
<body>

    <h2>Add New Member</h2>

    <form method="POST" action="add_member.php">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="height">Height (in cm):</label><br>
        <input type="number" id="height" name="height" step="0.01" required><br><br>

        <label for="weight">Weight (in kg):</label><br>
        <input type="number" id="weight" name="weight" step="0.01" required><br><br>

        <label for="phone">Phone Number:</label><br>
        <input type="text" id="phone" name="phone" required><br><br>

        <label for="dob">Date of Birth:</label><br>
        <input type="date" id="dob" name="dob" required><br><br>

        <label for="location">Location:</label><br>
        <input type="text" id="location" name="location" required><br><br>

        <button type="submit">Add Member</button>
    </form>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
