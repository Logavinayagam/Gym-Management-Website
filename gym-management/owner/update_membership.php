<?php
session_start();
include('../config/database.php');

// Check if the owner is logged in
if (!isset($_SESSION['owner_id'])) {
    header('Location: ../login/owner_login.php');
    exit();
}

// Function to update membership
if (isset($_POST['update_membership'])) {
    $member_id = $_POST['member_id'];
    $membership_duration = $_POST['membership_duration'];

    // Call the stored procedure to update membership expiry
    $stmt = $pdo->prepare("CALL update_membership_expiry(?, ?)");
    $stmt->execute([$member_id, $membership_duration]);

    // Redirect with a success message
    $_SESSION['success_message'] = "Membership updated successfully!";
    header('Location: update_membership.php');
    exit();
}

// Fetch all members sorted by membership expiry
$stmt = $pdo->prepare("CALL sort_members_by_expiry()");
$stmt->execute();
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Membership</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Link to your custom styles -->
</head>
<body>

    <h2>Update Membership</h2>

    <?php
    if (isset($_SESSION['success_message'])) {
        echo "<p style='color: green;'>" . $_SESSION['success_message'] . "</p>";
        unset($_SESSION['success_message']);
    }
    ?>

    <?php if (count($members) > 0): ?>
        <form method="POST" action="update_membership.php">
            <table border="1">
                <thead>
                    <tr>
                        <th>Member ID</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Membership Expiry Date</th>
                        <th>Update Membership</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $member): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($member['member_id']); ?></td>
                        <td><?php echo htmlspecialchars($member['name']); ?></td>
                        <td><?php echo htmlspecialchars($member['phone_number']); ?></td>
                        <td><?php echo htmlspecialchars($member['membership_expire_date']); ?></td>
                        <td>
                            <input type="radio" name="member_id" value="<?php echo $member['member_id']; ?>" required>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <br>
            <label for="membership_duration">Select Membership Duration:</label>
            <select name="membership_duration" id="membership_duration" required>
                <option value="1">1 Month</option>
                <option value="3">3 Months</option>
                <option value="6">6 Months</option>
                <option value="12">1 Year</option>
            </select>

            <br><br>
            <button type="submit" name="update_membership">Update Membership</button>
        </form>
    <?php else: ?>
        <p>No members found.</p>
    <?php endif; ?>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
