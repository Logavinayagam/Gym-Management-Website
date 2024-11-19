<?php
session_start();
include('../config/database.php');

// Check if the member is logged in
if (!isset($_SESSION['member_id'])) {
    header('Location: ../login/member_login.php');
    exit();
}

$member_id = $_SESSION['member_id'];

// Fetch workout plans assigned to the member
$stmt = $pdo->prepare("SELECT wp.plan_id, wp.date, wp.workout_type, t.name AS trainer_name
                        FROM workout_plan wp
                        JOIN workout_plan_trainees wpt ON wp.plan_id = wpt.plan_id
                        JOIN trainer t ON wp.trainer_id = t.trainer_id
                        WHERE wpt.member_id = :member_id");
$stmt->execute(['member_id' => $member_id]);
$workout_plans = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch diet plans assigned to the member
$stmt = $pdo->prepare("SELECT dp.diet_id, dp.date, t.name AS trainer_name
                        FROM diet_plan dp
                        JOIN diet_plan_trainees dpt ON dp.diet_id = dpt.diet_id
                        JOIN trainer t ON dp.trainer_id = t.trainer_id
                        WHERE dpt.member_id = :member_id");
$stmt->execute(['member_id' => $member_id]);
$diet_plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Training and Diet Plans</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Your Assigned Plans</h1>

    <!-- Workout Plans Section -->
    <h2 class="mt-4">Workout Plans</h2>
    <?php if ($workout_plans): ?>
        <div class="list-group">
            <?php foreach ($workout_plans as $plan): ?>
                <div class="list-group-item">
                    <h5 class="mb-1">Trainer: <?php echo htmlspecialchars($plan['trainer_name']); ?></h5>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($plan['date']); ?></p>
                    <p><strong>Workout Type:</strong> <?php echo htmlspecialchars($plan['workout_type']); ?></p>

                    <!-- Fetch and Display Exercises for Each Workout Plan -->
                    <h6>Exercises:</h6>
                    <?php
                    $stmt = $pdo->prepare("SELECT el.name, wpe.sets, wpe.reps, wpe.weight
                                           FROM workout_plan_exercises wpe
                                           JOIN exercise_list el ON wpe.exercise_id = el.exercise_id
                                           WHERE wpe.plan_id = :plan_id AND wpe.member_id = :member_id");
                    $stmt->execute(['plan_id' => $plan['plan_id'], 'member_id' => $member_id]);
                    $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <?php if ($exercises): ?>
                        <ul>
                            <?php foreach ($exercises as $exercise): ?>
                                <li><?php echo htmlspecialchars($exercise['name']); ?>:
                                    <?php echo htmlspecialchars($exercise['sets']); ?> sets,
                                    <?php echo htmlspecialchars($exercise['reps']); ?> reps,
                                    <?php echo htmlspecialchars($exercise['weight']); ?> kg
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No exercises found for this workout plan.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">No workout plans have been assigned yet.</div>
    <?php endif; ?>

    <!-- Diet Plans Section -->
    <h2 class="mt-4">Diet Plans</h2>
    <?php if ($diet_plans): ?>
        <div class="list-group">
            <?php foreach ($diet_plans as $plan): ?>
                <div class="list-group-item">
                    <h5 class="mb-1">Trainer: <?php echo htmlspecialchars($plan['trainer_name']); ?></h5>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($plan['date']); ?></p>

                    <!-- Fetch and Display Meals for Each Diet Plan -->
                    <h6>Meals:</h6>
                    <?php
                    $stmt = $pdo->prepare("SELECT ml.name
                                           FROM diet_plan_meals dpm
                                           JOIN meal_list ml ON dpm.meal_id = ml.meal_id
                                           WHERE dpm.diet_id = :diet_id AND dpm.member_id = :member_id");
                    $stmt->execute(['diet_id' => $plan['diet_id'], 'member_id' => $member_id]);
                    $meals = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <?php if ($meals): ?>
                        <ul>
                            <?php foreach ($meals as $meal): ?>
                                <li><?php echo htmlspecialchars($meal['name']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No meals found for this diet plan.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">No diet plans have been assigned yet.</div>
    <?php endif; ?>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
