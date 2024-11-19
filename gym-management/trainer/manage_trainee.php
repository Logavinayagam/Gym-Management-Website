<?php
session_start();
include('../config/database.php');

// Check if the trainer is logged in
if (!isset($_SESSION['trainer_id'])) {
    header('Location: ../login/trainer_login.php');
    exit();
}

// Update trainee functionality
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_POST['member_id'];
    $action = $_POST['action'];

    if ($action == 'extend') {
        // Extend membership by 1 month
        $stmt = $pdo->prepare("UPDATE member_trainer 
                               SET membership_expire = DATE_ADD(membership_expire, INTERVAL 1 MONTH) 
                               WHERE member_id = :member_id AND trainer_id = :trainer_id");
        $stmt->execute(['member_id' => $member_id, 'trainer_id' => $_SESSION['trainer_id']]);
        $message = "Membership extended by 1 month!";
    } elseif ($action == 'deactivate') {
        // Deactivate the trainee
        $stmt = $pdo->prepare("UPDATE member_trainer SET is_active = 0 
                               WHERE member_id = :member_id AND trainer_id = :trainer_id");
        $stmt->execute(['member_id' => $member_id, 'trainer_id' => $_SESSION['trainer_id']]);
        $message = "Trainee has been deactivated!";
    } elseif ($action == 'activate') {
        // Activate the trainee, set new start date to today, and expire in 1 month
        $stmt = $pdo->prepare("UPDATE member_trainer 
                               SET is_active = 1, membership_start = CURDATE(), membership_expire = DATE_ADD(CURDATE(), INTERVAL 1 MONTH) 
                               WHERE member_id = :member_id AND trainer_id = :trainer_id");
        $stmt->execute(['member_id' => $member_id, 'trainer_id' => $_SESSION['trainer_id']]);
        $message = "Trainee has been activated!";
    } elseif ($action == 'delete') {
        // Delete the trainee from the member_trainer table
        $stmt = $pdo->prepare("DELETE FROM member_trainer WHERE member_id = :member_id AND trainer_id = :trainer_id");
        $stmt->execute(['member_id' => $member_id, 'trainer_id' => $_SESSION['trainer_id']]);
        $message = "Trainee has been deleted!";
    }
}

// Fetch trainees assigned to this trainer
$trainer_id = $_SESSION['trainer_id'];
$stmt = $pdo->prepare("SELECT mt.member_id, m.name, mt.membership_start, mt.membership_expire, mt.is_active
                       FROM member_trainer mt
                       JOIN member m ON mt.member_id = m.member_id
                       WHERE mt.trainer_id = :trainer_id");
$stmt->execute(['trainer_id' => $trainer_id]);
$trainees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Trainees</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Manage Trainees</h1>

    <?php if (isset($message)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>Member ID</th>
                <th>Name</th>
                <th>Membership Start</th>
                <th>Membership Expire</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trainees as $trainee): ?>
                <tr>
                    <td><?php echo htmlspecialchars($trainee['member_id']); ?></td>
                    <td><?php echo htmlspecialchars($trainee['name']); ?></td>
                    <td><?php echo htmlspecialchars($trainee['membership_start']); ?></td>
                    <td><?php echo htmlspecialchars($trainee['membership_expire']); ?></td>
                    <td><?php echo $trainee['is_active'] ? 'Active' : 'Inactive'; ?></td>
                    <td>
                        <?php if ($trainee['is_active']): ?>
                            <!-- Extend and Deactivate for Active Trainees -->
                            <form action="manage_trainee.php" method="POST" style="display:inline-block;">
                                <input type="hidden" name="member_id" value="<?php echo $trainee['member_id']; ?>">
                                <button type="submit" name="action" value="extend" class="btn btn-success">Extend</button>
                            </form>
                            <form action="manage_trainee.php" method="POST" style="display:inline-block;">
                                <input type="hidden" name="member_id" value="<?php echo $trainee['member_id']; ?>">
                                <button type="submit" name="action" value="deactivate" class="btn btn-danger">Deactivate</button>
                            </form>
                        <?php else: ?>
                            <!-- Activate and Delete for Inactive Trainees -->
                            <form action="manage_trainee.php" method="POST" style="display:inline-block;">
                                <input type="hidden" name="member_id" value="<?php echo $trainee['member_id']; ?>">
                                <button type="submit" name="action" value="activate" class="btn btn-warning">Activate</button>
                            </form>
                            <form action="manage_trainee.php" method="POST" style="display:inline-block;">
                                <input type="hidden" name="member_id" value="<?php echo $trainee['member_id']; ?>">
                                <button type="submit" name="action" value="delete" class="btn btn-danger">Delete</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
