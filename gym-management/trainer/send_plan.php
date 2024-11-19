<?php
session_start();
include('../config/database.php');

// Ensure the trainer is logged in
if (!isset($_SESSION['trainer_id'])) {
    header('Location: ../login/trainer_login.php');
    exit();
}

$trainer_id = $_SESSION['trainer_id'];
$successMessage = '';
$errorMessage = '';

// Fetch members, exercises, and meals for the dropdown options
$members = $pdo->query("SELECT member_id, name FROM member")->fetchAll(PDO::FETCH_ASSOC);
$exercises = $pdo->query("SELECT exercise_id, name FROM exercise_list")->fetchAll(PDO::FETCH_ASSOC);
$meals = $pdo->query("SELECT meal_id, name FROM meal_list")->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plan_type = $_POST['plan_type'];
    $member_id = $_POST['member_id'];
    $date = $_POST['date'];

    // Check if required fields are filled
    if (empty($member_id) || empty($date)) {
        $errorMessage = 'Please provide all required fields.';
    } else {
        if ($plan_type === 'workout') {
            $workout_type = $_POST['workout_type'];
            $exercisesSelected = $_POST['exercises']; // This should be an array

            if (empty($exercisesSelected)) {
                $errorMessage = 'Please select at least one exercise.';
            } else {
                // Insert workout plan
                $stmt = $pdo->prepare("INSERT INTO workout_plan (trainer_id, date, workout_type) VALUES (?, ?, ?)");
                $stmt->execute([$trainer_id, $date, $workout_type]);
                $workout_plan_id = $pdo->lastInsertId();

                // Insert exercises
                foreach ($exercisesSelected as $exercise) {
                    // Ensure the exercise data is in the expected structure
                    $exercise_id = $exercise['exercise_id'] ?? null;
                    $sets = $exercise['sets'] ?? null;
                    $reps = $exercise['reps'] ?? null;
                    $weight = $exercise['weight'] ?? null;

                    if ($exercise_id && $sets && $reps && $weight) {
                        $stmt = $pdo->prepare("INSERT INTO workout_plan_exercises (plan_id, member_id, exercise_id, sets, reps, weight) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$workout_plan_id, $member_id, $exercise_id, $sets, $reps, $weight]);
                    }
                }

                // Link workout plan to trainee
                $stmt = $pdo->prepare("INSERT INTO workout_plan_trainees (plan_id, member_id) VALUES (?, ?)");
                $stmt->execute([$workout_plan_id, $member_id]);

                $successMessage = 'Workout plan sent successfully!';
            }
        } elseif ($plan_type === 'diet') {
            $meal_type = $_POST['meal_type'];
            $mealsSelected = $_POST['meals'];

            if (empty($mealsSelected)) {
                $errorMessage = 'Please select at least one meal.';
            } else {
                // Insert diet plan
                $stmt = $pdo->prepare("INSERT INTO diet_plan (trainer_id, date, meal_type) VALUES (?, ?, ?)");
                $stmt->execute([$trainer_id, $date, $meal_type]);
                $diet_plan_id = $pdo->lastInsertId();

                // Insert meals
                foreach ($mealsSelected as $meal_id) {
                    $stmt = $pdo->prepare("INSERT INTO diet_plan_meals (diet_id, member_id, meal_id) VALUES (?, ?, ?)");
                    $stmt->execute([$diet_plan_id, $member_id, $meal_id]);
                }

                // Link diet plan to trainee
                $stmt = $pdo->prepare("INSERT INTO diet_plan_trainees (diet_id, member_id) VALUES (?, ?)");
                $stmt->execute([$diet_plan_id, $member_id]);

                $successMessage = 'Diet plan sent successfully!';
            }
        }
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Training Plan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Send Training Plan</h1>
    <?php if ($successMessage): ?>
        <div class="alert alert-success"><?php echo $successMessage; ?></div>
    <?php elseif ($errorMessage): ?>
        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="member" class="form-label">Select Member</label>
            <select id="member" name="member_id" class="form-select" required>
                <option value="">Choose Member</option>
                <?php foreach ($members as $member): ?>
                    <option value="<?php echo htmlspecialchars($member['member_id']); ?>"><?php echo htmlspecialchars($member['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="plan_type" class="form-label">Plan Type</label>
            <select id="plan_type" name="plan_type" class="form-select" required>
                <option value="">Select Plan Type</option>
                <option value="workout">Workout</option>
                <option value="diet">Diet</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" id="date" name="date" class="form-control" required>
        </div>

        <!-- Workout Plan Section -->
        <div id="workout_section" style="display: none;">
            <div class="mb-3">
                <label for="workout_type" class="form-label">Workout Type</label>
                <select id="workout_type" name="workout_type" class="form-select" required>
                    <option value="">Select Workout Type</option>
                    <option value="push">Push</option>
                    <option value="pull">Pull</option>
                    <option value="leg">Leg</option>
                    <option value="circuit">Circuit</option>
                </select>
            </div>

            <div id="exercise_list">
                <label>Exercises</label>
                <div class="exercise-entry mb-2">
                    <select name="exercises[0][exercise_id]" class="form-select mb-2">
                        <option value="">Choose Exercise</option>
                        <?php foreach ($exercises as $exercise): ?>
                            <option value="<?php echo $exercise['exercise_id']; ?>"><?php echo $exercise['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" name="exercises[0][sets]" class="form-control" placeholder="Sets" required>
                    <input type="number" name="exercises[0][reps]" class="form-control" placeholder="Reps" required>
                    <input type="number" name="exercises[0][weight]" class="form-control" placeholder="Weight" required>
                </div>
                <button type="button" onclick="addExercise()">Add More Exercise</button>
            </div>
        </div>

        <!-- Diet Plan Section -->
        <div id="diet_section" style="display: none;">
            <div class="mb-3">
                <label for="meal_type" class="form-label">Meal Type</label>
                <select id="meal_type" name="meal_type" class="form-select" required>
                    <option value="">Select Meal Type</option>
                    <option value="breakfast">Breakfast</option>
                    <option value="lunch">Lunch</option>
                    <option value="dinner">Dinner</option>
                </select>
            </div>

            <div id="meal_list">
                <label>Meals</label>
                <div class="meal-entry mb-2">
                    <select name="meals[]" class="form-select mb-2">
                        <option value="">Choose Meal</option>
                        <?php foreach ($meals as $meal): ?>
                            <option value="<?php echo $meal['meal_id']; ?>"><?php echo $meal['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="button" onclick="addMeal()">Add More Meal</button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Send Plan</button>
    </form>
</div>

<script>
    document.getElementById('plan_type').addEventListener('change', function () {
        const workoutSection = document.getElementById('workout_section');
        const dietSection = document.getElementById('diet_section');

        if (this.value === 'workout') {
            workoutSection.style.display = 'block';
            dietSection.style.display = 'none';
        } else if (this.value === 'diet') {
            dietSection.style.display = 'block';
            workoutSection.style.display = 'none';
        } else {
            workoutSection.style.display = 'none';
            dietSection.style.display = 'none';
        }
    });

    function addExercise() {
        const exerciseEntry = document.querySelector('.exercise-entry').cloneNode(true);
        document.getElementById('exercise_list').appendChild(exerciseEntry);
    }

    function addMeal() {
        const mealEntry = document.querySelector('.meal-entry').cloneNode(true);
        document.getElementById('meal_list').appendChild(mealEntry);
    }
</script>
</body>
</html>
