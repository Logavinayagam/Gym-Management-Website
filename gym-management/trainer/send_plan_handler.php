<?php
include 'db_connect.php'; // Ensure db connection is included

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Retrieve selected trainee(s), date, workout type, and exercises/diet from the form
    $trainees = $_POST['trainees'];
    $date = $_POST['date'];
    $workout_type = $_POST['workout_type'];
    $exercise_ids = $_POST['exercise_ids'];
    $sets = $_POST['sets'];
    $reps = $_POST['reps'];
    $weights = $_POST['weight'];
    $meal_ids = $_POST['meal_ids'];

    // Prepare SQL insert queries for each trainee's workout and diet plan
    $workout_insert_query = "INSERT INTO workout_plan (trainee_id, date, workout_type, exercise_id, sets, reps, weight) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $diet_insert_query = "INSERT INTO diet_plan (trainee_id, date, meal_type, meal_id) VALUES (?, ?, ?, ?)";

    // Start a transaction for atomicity
    mysqli_begin_transaction($conn);

    try {
        // Prepare workout plan statement
        $workout_stmt = mysqli_prepare($conn, $workout_insert_query);
        foreach ($trainees as $trainee_id) {
            foreach ($exercise_ids as $index => $exercise_id) {
                mysqli_stmt_bind_param($workout_stmt, 'issiiii', $trainee_id, $date, $workout_type, $exercise_id, $sets[$index], $reps[$index], $weights[$index]);
                mysqli_stmt_execute($workout_stmt);
            }
        }

        // Prepare diet plan statement
        $diet_stmt = mysqli_prepare($conn, $diet_insert_query);
        foreach ($trainees as $trainee_id) {
            foreach ($meal_ids as $meal_id) {
                $meal_type_query = "SELECT meal_type FROM meals WHERE id = $meal_id";
                $meal_type_result = mysqli_query($conn, $meal_type_query);
                $meal_type = mysqli_fetch_assoc($meal_type_result)['meal_type'];

                mysqli_stmt_bind_param($diet_stmt, 'isss', $trainee_id, $date, $meal_type, $meal_id);
                mysqli_stmt_execute($diet_stmt);
            }
        }

        // Commit transaction if no errors
        mysqli_commit($conn);
        echo "Plan successfully sent!";
        
    } catch (Exception $e) {
        // Roll back if any error occurs
        mysqli_rollback($conn);
        echo "Error occurred: " . $e->getMessage();
    }

    // Close statements and connection
    mysqli_stmt_close($workout_stmt);
    mysqli_stmt_close($diet_stmt);
    mysqli_close($conn);

} else {
    echo "Invalid request method!";
}
?>
