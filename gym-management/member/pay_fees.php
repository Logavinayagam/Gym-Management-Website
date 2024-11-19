<?php
session_start();
include('../config/database.php');

// Check if the member is logged in
if (!isset($_SESSION['member_id'])) {
    header('Location: ../login/member_login.php');
    exit();
}

// Fetch member details and UPI IDs from the database
$member_id = $_SESSION['member_id'];

// Fetch membership details
$stmt = $pdo->prepare("SELECT membership_expire_date, mt.trainer_id 
                        FROM member m 
                        LEFT JOIN member_trainer mt ON m.member_id = mt.member_id 
                        WHERE m.member_id = :member_id");
$stmt->execute(['member_id' => $member_id]);
$member_details = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$member_details) {
    echo "<script>alert('Member not found.'); window.location.href = 'dashboard.php';</script>";
    exit();
}

// Get membership details
$membership_expire_date = $member_details['membership_expire_date'];

// Determine membership type and fees
$today = new DateTime();
$expiry_date = new DateTime($membership_expire_date);
$membership_fee = 0;
$membership_type = "";

if ($expiry_date > $today) {
    $days_remaining = $expiry_date->diff($today)->days;
    if ($days_remaining >= 365) {
        $membership_fee = 6500;
        $membership_type = "1 Year Membership";
    } elseif ($days_remaining >= 180) {
        $membership_fee = 3300;
        $membership_type = "6 Month Membership";
    } elseif ($days_remaining >= 90) {
        $membership_fee = 1700;
        $membership_type = "3 Month Membership";
    } else {
        $membership_fee = 600;
        $membership_type = "1 Month Membership";
    }
}

// Fetch owner UPI ID
$owner_stmt = $pdo->query("SELECT upi_id FROM owner LIMIT 1");
$owner_details = $owner_stmt->fetch(PDO::FETCH_ASSOC);
$owner_upi_id = $owner_details['upi_id'] ?? null;

// Fetch trainer details and fee if applicable
$trainer_fee = 0;
$trainer_upi_id = "";
if (!empty($member_details['trainer_id'])) {
    $trainer_stmt = $pdo->prepare("SELECT t.upi_id, 
                                    CASE 
                                        WHEN t.grade = 'Grade 1' THEN 700
                                        WHEN t.grade = 'Grade 2' THEN 500
                                        ELSE 300
                                    END AS trainer_fee 
                                    FROM trainer t 
                                    WHERE t.trainer_id = :trainer_id");
    $trainer_stmt->execute(['trainer_id' => $member_details['trainer_id']]);
    $trainer_details = $trainer_stmt->fetch(PDO::FETCH_ASSOC);

    if ($trainer_details) {
        $trainer_upi_id = $trainer_details['upi_id'];
        $trainer_fee = $trainer_details['trainer_fee'];
    }
}

// Calculate total bill
$total_bill = $membership_fee + $trainer_fee;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership and Payment Details</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Membership and Payment Details</h1>

    <div class="mb-4">
        <h4>Your Membership Information:</h4>
        <p><strong>Membership Type:</strong> <?php echo htmlspecialchars($membership_type); ?></p>
        <p><strong>Membership Fee:</strong> $<?php echo htmlspecialchars($membership_fee); ?></p>
        <p><strong>Membership Expiry Date:</strong> <?php echo htmlspecialchars($membership_expire_date); ?></p>
    </div>

    <div class="mb-4">
        <h4>Trainer Information (if applicable):</h4>
        <p><strong>Trainer Fee:</strong> $<?php echo htmlspecialchars($trainer_fee); ?></p>
        <?php if ($trainer_upi_id): ?>
            <p><strong>Trainer UPI ID:</strong> <?php echo htmlspecialchars($trainer_upi_id); ?></p>
        <?php else: ?>
            <p>No assigned trainer.</p>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <h4>Owner Information:</h4>
        <?php if ($owner_upi_id): ?>
            <p><strong>Owner UPI ID:</strong> <?php echo htmlspecialchars($owner_upi_id); ?></p>
        <?php else: ?>
            <p>No owner information available.</p>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <h4>Total Bill:</h4>
        <p><strong>Total Amount:</strong> $<?php echo htmlspecialchars($total_bill); ?></p>
    </div>

    <h4>All Membership Plans:</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Membership Type</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1 Month Membership</td>
                <td>$600</td>
            </tr>
            <tr>
                <td>3 Month Membership</td>
                <td>$1700</td>
            </tr>
            <tr>
                <td>6 Month Membership</td>
                <td>$3300</td>
            </tr>
            <tr>
                <td>1 Year Membership</td>
                <td>$6500</td>
            </tr>
        </tbody>
    </table>

    <h4>Personal Training Membership Fees:</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Trainer Grade</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Grade 1</td>
                <td>$700</td>
            </tr>
            <tr>
                <td>Grade 2</td>
                <td>$500</td>
            </tr>
            <tr>
                <td>Assistant</td>
                <td>$300</td>
            </tr>
        </tbody>
    </table>

    <!-- Scan and Pay QR Code Section -->
    <div class="mt-5 text-center">
        <h4>Scan and Pay</h4>
        <div class="border p-3 d-inline-block">
            <img src="../image/qr.jpg" alt="QR Code" style="width: 200px; height: 200px;">
        </div>
    </div>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
