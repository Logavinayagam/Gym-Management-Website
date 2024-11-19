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
$stmt_member = $pdo->prepare("SELECT * FROM member WHERE member_id = :member_id");
$stmt_member->execute(['member_id' => $member_id]);
$member = $stmt_member->fetch(PDO::FETCH_ASSOC);

// Fetch personal training membership details
$stmt_training_membership = $pdo->prepare("
    SELECT 
        mt.trainer_id,
        mt.membership_start,
        mt.membership_expire,
        mt.is_active,
        t.name AS trainer_name
    FROM member_trainer mt
    JOIN trainer t ON mt.trainer_id = t.trainer_id
    WHERE mt.member_id = :member_id
");
$stmt_training_membership->execute(['member_id' => $member_id]);
$training_memberships = $stmt_training_membership->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Expiry</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Membership Expiry Details</h1>
    <h4>Member: <?php echo htmlspecialchars($member['name']); ?></h4>

    <h3>Gym Membership</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Membership Expiry Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo htmlspecialchars($member['membership_expire_date']); ?></td>
                <td>
                    <?php echo (new DateTime($member['membership_expire_date']) > new DateTime('now')) ? 'Active' : 'Expired'; ?>
                </td>
            </tr>
        </tbody>
    </table>

    <h3>Personal Training Memberships</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Trainer</th>
                <th>Membership Start</th>
                <th>Membership Expiry</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($training_memberships): ?>
                <?php foreach ($training_memberships as $membership): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($membership['trainer_name']); ?></td>
                        <td><?php echo htmlspecialchars($membership['membership_start']); ?></td>
                        <td><?php echo htmlspecialchars($membership['membership_expire']); ?></td>
                        <td>
                            <?php echo $membership['is_active'] ? 'Active' : 'Inactive'; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No personal training memberships found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
