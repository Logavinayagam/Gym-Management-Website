<?php
session_start();
include('../config/database.php');

// Check if the owner is logged in
if (!isset($_SESSION['owner_id'])) {
    header('Location: ../login/owner_login.php');
    exit();
}

// Handle form submission
if (isset($_POST['add_trainer'])) {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $date_of_birth = $_POST['date_of_birth'];
    $grade = $_POST['grade'];
    $is_certified = isset($_POST['is_certified']) ? 1 : 0;
    $upi_id = $_POST['upi_id'];
    
    // Insert trainer data into the database
    $stmt = $pdo->prepare("INSERT INTO trainer (name, phone_number, date_of_birth, grade, is_certified, upi_id) VALUES (?, ?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$name, $phone_number, $date_of_birth, $grade, $is_certified, $upi_id])) {
        // Success message
        $_SESSION['success_message'] = "Trainer added successfully!";
        header('Location: add_trainer.php');
        exit();
    } else {
        // Error message
        $_SESSION['error_message'] = "Error occurred while adding the trainer. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Trainer</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Link to your custom styles -->
</head>
<body>

    <h2>Add New Trainer</h2>

    <?php
    if (isset($_SESSION['success_message'])) {
        echo "<p style='color: green;'>" . $_SESSION['success_message'] . "</p>";
        unset($_SESSION['success_message']);
    }
    if (isset($_SESSION['error_message'])) {
        echo "<p style='color: red;'>" . $_SESSION['error_message'] . "</p>";
        unset($_SESSION['error_message']);
    }
    ?>

    <form method="POST" action="add_trainer.php">
        <label for="name">Trainer Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required>
        <br><br>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" required>
        <br><br>

        <label for="grade">Select Grade:</label>
        <select id="grade" name="grade" required>
            <option value="Grade 1">Grade 1</option>
            <option value="Grade 2">Grade 2</option>
            <option value="Assistant">Assistant</option>
        </select>
        <br><br>

        <label for="is_certified">Certified Trainer:</label>
        <input type="checkbox" id="is_certified" name="is_certified">
        <br><br>

        <label for="upi_id">UPI ID:</label>
        <input type="text" id="upi_id" name="upi_id">
        <br><br>

        <button type="submit" name="add_trainer">Add Trainer</button>
    </form>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
