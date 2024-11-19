<?php
session_start();
include('../config/database.php');

// Check if the owner is logged in
if (!isset($_SESSION['owner_id'])) {
    header('Location: ../login/owner_login.php');
    exit();
}

// Fetch all members from the database
$stmt = $pdo->prepare("SELECT member_id, name, phone_number, height, weight, age, location, membership_expire_date FROM member ORDER BY membership_expire_date");
$stmt->execute();
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Members</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Link to your custom styles -->
</head>
<body>

    <h2>All Members</h2>

    <?php if (count($members) > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Member ID</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Height (cm)</th>
                    <th>Weight (kg)</th>
                    <th>Age</th>
                    <th>Location</th>
                    <th>Membership Expiry Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($members as $member): ?>
                <tr>
                    <td><?php echo htmlspecialchars($member['member_id']); ?></td>
                    <td><?php echo htmlspecialchars($member['name']); ?></td>
                    <td><?php echo htmlspecialchars($member['phone_number']); ?></td>
                    <td><?php echo htmlspecialchars($member['height']); ?></td>
                    <td><?php echo htmlspecialchars($member['weight']); ?></td>
                    <td><?php echo htmlspecialchars($member['age']); ?></td>
                    <td><?php echo htmlspecialchars($member['location']); ?></td>
                    <td><?php echo htmlspecialchars($member['membership_expire_date']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No members found.</p>
    <?php endif; ?>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
