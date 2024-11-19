<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Management System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .hero {
            background-color: #343a40;
            color: #ffffff;
            padding: 50px 0;
            text-align: center;
        }
        .hero h1 {
            font-size: 3rem;
        }
        .hero p {
            font-size: 1.25rem;
        }
        .container {
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div class="hero">
        <div class="container">
            <h1>Welcome to the Gym Management System</h1>
            <p>Your fitness journey starts here! Manage your workouts, trainers, and memberships.</p>
        </div>
    </div>

    <div class="container">
        <h2 class="text-center mt-5">Login to Your Account</h2>
        <div class="row mt-4">
            <div class="col-md-4 offset-md-2">
                <a href="login/owner_login.php" class="btn btn-primary btn-block">Owner Login</a>
            </div>
            <div class="col-md-4">
                <a href="login/trainer_login.php" class="btn btn-success btn-block">Trainer Login</a>
            </div>
            <div class="col-md-4 offset-md-2 mt-3">
                <a href="login/member_login.php" class="btn btn-info btn-block">Member Login</a>
            </div>
        </div>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; <?php echo date("Y"); ?> Gym Management System. All Rights Reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
