<?php
session_start();
include('../config/database.php');

// Check if the owner is logged in
if (!isset($_SESSION['owner_id'])) {
    header('Location: ../login/owner_login.php');
    exit();
}

// Fetch the total number of members, trainers, and spotlights
$stmt_members = $pdo->query("SELECT COUNT(*) FROM member");
$total_members = $stmt_members->fetchColumn();

$stmt_trainers = $pdo->query("SELECT COUNT(*) FROM trainer");
$total_trainers = $stmt_trainers->fetchColumn();

$stmt_spotlights = $pdo->query("SELECT COUNT(*) FROM spotlight");
$total_spotlights = $stmt_spotlights->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Gym Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4">Welcome, Owner</h1>

        <div class="row">
            <!-- Members Count -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Members</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total_members; ?></h5>
                        <p class="card-text">Manage all gym members here.</p>
                        <a href="view_members.php" class="btn btn-light">View Members</a>
                    </div>
                </div>
            </div>

            <!-- Trainers Count -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Trainers</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total_trainers; ?></h5>
                        <p class="card-text">Manage trainers and their plans here.</p>
                        <a href="view_trainers.php" class="btn btn-light">View Trainers</a>
                    </div>
                </div>
            </div>

            <!-- Spotlight Posts -->
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Today's Spotlights</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total_spotlights; ?></h5>
                        <p class="card-text">Post and manage spotlight announcements.</p>
                        <a href="view_spotlights.php" class="btn btn-light">Manage Spotlights</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Add New Member -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">Member Management</div>
                    <div class="card-body">
                        <a href="add_member.php" class="btn btn-primary">Add New Member</a>
                        <a href="view_members.php" class="btn btn-secondary">View All Members</a>
                    </div>
                </div>
            </div>

            <!-- Add New Trainer -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">Trainer Management</div>
                    <div class="card-body">
                        <a href="add_trainer.php" class="btn btn-primary">Add New Trainer</a>
                        <a href="view_trainers.php" class="btn btn-secondary">View All Trainers</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Post Spotlight -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">Announcements</div>
                    <div class="card-body">
                        <a href="add_spotlight.php" class="btn btn-primary">Post Today's Spotlight</a>
                        <a href="view_spotlights.php" class="btn btn-secondary">Manage Spotlights</a>
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">Payment Management</div>
                    <div class="card-body">
                        <a href="view_payments.php" class="btn btn-primary">View Payment Details</a>
                        <a href="manage_payments.php" class="btn btn-secondary">Manage Payments</a>
                    </div>
                </div>
            </div>

            <!-- Resource Management -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">Resource Management</div>
                    <div class="card-body">
                        <a href="resource.php" class="btn btn-primary">Manage Equipment & Supplements</a>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
