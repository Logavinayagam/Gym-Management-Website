<?php
session_start();
include('../config/database.php');

// Check if the owner is logged in
if (!isset($_SESSION['owner_id'])) {
    header('Location: ../login/owner_login.php');
    exit();
}

// Check if the spotlight ID is provided
if (!isset($_GET['id'])) {
    header('Location: view_spotlights.php'); // Redirect to view all spotlights
    exit();
}

$spotlight_id = $_GET['id'];

// Handle the deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete the spotlight from the database
    $stmt = $pdo->prepare("DELETE FROM spotlight WHERE spotlight_id = ?");
    $stmt->execute([$spotlight_id]);

    // Redirect with success message
    $_SESSION['success_message'] = "Spotlight deleted successfully!";
    header('Location: view_spotlights.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Spotlight</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2 class="mb-4">Delete Spotlight</h2>
        <div class="alert alert-warning">
            Are you sure you want to delete this spotlight? This action cannot be undone.
        </div>

        <form action="delete_spotlight.php?id=<?php echo $spotlight_id; ?>" method="POST">
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="view_spotlights.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
