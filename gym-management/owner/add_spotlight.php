<?php
session_start();
include('../config/database.php'); // Adjust the path if needed

// Check if the user is logged in, add your session checks here
if (!isset($_SESSION['owner_id'])) {
    header('Location: owner_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO spotlight (title, content, start_date, end_date) VALUES (?, ?, ?, ?)");

    // Execute the query
    if ($stmt->execute([$title, $content, $start_date, $end_date])) {
        // Redirect or give a success message
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Failed to add spotlight.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Spotlight</title>
    <link rel="stylesheet" href="../public/css/style.css"> <!-- Adjust path if necessary -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Add Spotlight</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" required></textarea>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Spotlight</button>
    </form>

    <p class="mt-3"><a href="dashboard.php">Back to Dashboard</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
