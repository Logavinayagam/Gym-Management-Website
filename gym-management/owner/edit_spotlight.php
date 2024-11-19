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

// Fetch the spotlight details from the database
$stmt = $pdo->prepare("SELECT * FROM spotlight WHERE spotlight_id = ?");
$stmt->execute([$spotlight_id]);
$spotlight = $stmt->fetch();

if (!$spotlight) {
    header('Location: view_spotlights.php'); // Redirect if spotlight not found
    exit();
}

// Handle form submission to update the spotlight
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $spotlight_title = trim($_POST['spotlight_title']);
    $spotlight_content = trim($_POST['spotlight_content']);

    // Validation: Ensure both fields are filled out
    if (empty($spotlight_title) || empty($spotlight_content)) {
        $error_message = "Both the title and content are required.";
    } else {
        // Update the spotlight in the database
        $stmt = $pdo->prepare("UPDATE spotlight SET title = ?, content = ? WHERE spotlight_id = ?");
        $stmt->execute([$spotlight_title, $spotlight_content, $spotlight_id]);

        // Redirect with success message
        $_SESSION['success_message'] = "Spotlight updated successfully!";
        header('Location: view_spotlights.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Spotlight</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2 class="mb-4">Edit Spotlight</h2>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="edit_spotlight.php?id=<?php echo $spotlight_id; ?>" method="POST">
            <div class="mb-3">
                <label for="spotlight_title" class="form-label">Spotlight Title</label>
                <input type="text" class="form-control" id="spotlight_title" name="spotlight_title" value="<?php echo htmlspecialchars($spotlight['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="spotlight_content" class="form-label">Spotlight Content</label>
                <textarea class="form-control" id="spotlight_content" name="spotlight_content" rows="5" required><?php echo htmlspecialchars($spotlight['content']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Spotlight</button>
            <a href="view_spotlights.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
