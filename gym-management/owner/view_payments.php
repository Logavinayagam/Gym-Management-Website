<?php
session_start();
include('../config/database.php');

// Check if the owner is logged in
if (!isset($_SESSION['owner_id'])) {
    header('Location: ../login/owner_login.php');
    exit();
}

// Define the number of days to check for membership expiration
$days_limit = 365; // Change this value as needed

// Fetch all members and their payment details
$stmt = $pdo->prepare("
    SELECT p.*, m.name, m.membership_expire_date 
    FROM payment p 
    JOIN member m ON p.member_id = m.member_id
    ORDER BY 
        CASE 
            WHEN m.membership_expire_date <= DATE_ADD(CURDATE(), INTERVAL ? DAY) THEN 0 
            ELSE 1 
        END, 
        m.membership_expire_date ASC
");
$stmt->execute([$days_limit]);
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payments</title>
    <link rel="stylesheet" href="../public/css/style.css"> <!-- Link to your custom styles -->
</head>
<body>

<h2>View Payments - Membership Expiry Details</h2>

<table border="1">
    <thead>
        <tr>
            <th>Payment ID</th>
            <th>Member Name</th>
            <th>Amount</th>
            <th>Payment Date</th>
            <th>Membership Expiry Date</th>
            <th>Expires In (Days)</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($payments) > 0): ?>
            <?php foreach ($payments as $payment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($payment['payment_id']); ?></td>
                    <td><?php echo htmlspecialchars($payment['name']); ?></td>
                    <td><?php echo htmlspecialchars($payment['amount']); ?></td>
                    <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                    <td><?php echo htmlspecialchars($payment['membership_expire_date']); ?></td>
                    <td>
                        <?php 
                        // Calculate days until expiration
                        $expire_date = new DateTime($payment['membership_expire_date']);
                        $today = new DateTime();
                        $interval = $today->diff($expire_date);
                        echo $interval->days; // Display days until expiration
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No payment records found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
