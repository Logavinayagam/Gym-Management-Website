<?php
session_start();
include('../config/database.php');

// Check if the trainer is logged in
if (!isset($_SESSION['trainer_id'])) {
    header('Location: ../login/trainer_login.php');
    exit();
}

// Add trainee functionality
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_number = $_POST['phone'];

    // Check if the member exists in the database using phone number
    $stmt = $pdo->prepare("SELECT member_id FROM member WHERE phone_number = :phone_number");
    $stmt->execute(['phone_number' => $phone_number]);
    $member = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($member) {
        $member_id = $member['member_id'];
        $trainer_id = $_SESSION['trainer_id'];

        // Check if this member is already assigned to the trainer
        $check_stmt = $pdo->prepare("SELECT * FROM member_trainer WHERE member_id = :member_id AND trainer_id = :trainer_id");
        $check_stmt->execute(['member_id' => $member_id, 'trainer_id' => $trainer_id]);
        $exists = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if (!$exists) {
            // Set membership start to current date and expiry to 1 month later
            $current_date = date('Y-m-d');
            $membership_expire = date('Y-m-d', strtotime('+1 month'));

            // Insert the relationship into the member_trainer table with a 1-month membership
            $stmt_insert = $pdo->prepare("INSERT INTO member_trainer (member_id, trainer_id, membership_start, membership_expire) 
                                          VALUES (:member_id, :trainer_id, :membership_start, :membership_expire)");
            $stmt_insert->execute([
                'member_id' => $member_id,
                'trainer_id' => $trainer_id,
                'membership_start' => $current_date,
                'membership_expire' => $membership_expire
            ]);

            // Redirect with a success message
            header("Location: add_trainee.php?status=success");
            exit();
        } else {
            $error = "This member is already assigned to you.";
        }
    } else {
        $error = "Member not found with this phone number.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Trainee</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Add Existing Member as Trainee</h1>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success" role="alert">
            Member added successfully as a trainee!
        </div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="add_trainee.php" method="POST">
        <div class="mb-3">
            <label for="phone" class="form-label">Member's Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Trainee</button>
    </form>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
