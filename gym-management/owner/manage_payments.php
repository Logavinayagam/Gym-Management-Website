<?php
session_start();
include('../config/database.php');

// Check if the owner is logged in
if (!isset($_SESSION['owner_id'])) {
    header('Location: ../login/owner_login.php');
    exit();
}

// Function to calculate membership fee based on duration
function calculateFee($duration) {
    switch ($duration) {
        case 1:
            return 600; // 1 Month
        case 3:
            return 1700; // 3 Months
        case 6:
            return 3300; // 6 Months
        case 12:
            return 6500; // 1 Year
        default:
            return 0; // Default case
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = $_POST['member_id'];
    $membership_duration = $_POST['membership_duration'];
    $amount = calculateFee($membership_duration);
    $owner_upi_id = $_SESSION['owner_upi_id']; // Assuming you store owner's UPI in the session

    // Insert the payment into the payments table
    $stmt = $pdo->prepare("INSERT INTO payment (member_id, owner_upi_id, amount, payment_date) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$member_id, $owner_upi_id, $amount]);

    // Get the last inserted payment ID
    $payment_id = $pdo->lastInsertId();

    // Update the member with the new payment ID and expiration date
    $expiry_date = date('Y-m-d', strtotime("+$membership_duration months")); // Calculate new expiry date
    $updateStmt = $pdo->prepare("UPDATE member SET payment_id = ?, membership_expire_date = ? WHERE member_id = ?");
    $updateStmt->execute([$payment_id, $expiry_date, $member_id]);

    // Redirect with a success message
    $_SESSION['success_message'] = "Payment processed successfully!";
    header('Location: manage_payments.php');
    exit();
}

// Fetch all members for selection
$stmt = $pdo->prepare("SELECT * FROM member");
$stmt->execute();
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payment</title>
    <link rel="stylesheet" href="../public/css/style.css"> <!-- Link to your custom styles -->
</head>
<body>

<h2>Manage Payment</h2>

<?php if (isset($_SESSION['success_message'])): ?>
    <p style='color: green;'><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></p>
<?php endif; ?>

<form method="POST" action="manage_payments.php">
    <label for="member_id">Select Member:</label>
    <select name="member_id" id="member_id" required>
        <?php foreach ($members as $member): ?>
            <option value="<?php echo $member['member_id']; ?>">
                <?php echo htmlspecialchars($member['name']) . ' - ' . htmlspecialchars($member['phone_number']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br><br>
    <label for="membership_duration">Select Membership Duration:</label>
    <select name="membership_duration" id="membership_duration" required>
        <option value="1">1 Month</option>
        <option value="3">3 Months</option>
        <option value="6">6 Months</option>
        <option value="12">1 Year</option>
    </select>

    <br><br>
    <button type="submit">Process Payment</button>
</form>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
