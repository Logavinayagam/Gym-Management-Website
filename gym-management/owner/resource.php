<?php
session_start();
include('../config/database.php');

// Check if the owner is logged in
if (!isset($_SESSION['owner_id'])) {
    header('Location: ../login/owner_login.php');
    exit();
}

// Add Equipment
if (isset($_POST['add_equipment'])) {
    $name = $_POST['equipment_name'];
    $quantity = $_POST['equipment_quantity'];
    $condition = $_POST['equipment_condition'];
    $maintenance_date = $_POST['equipment_maintenance_date'];
    $location = $_POST['equipment_location'];

    $stmt = $pdo->prepare("INSERT INTO equipment (name, quantity, `condition`, maintenance_date, location) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $quantity, $condition, $maintenance_date, $location]);

    echo "<script>alert('Equipment added successfully!'); window.location.href='resource.php';</script>";
}

// Edit Equipment
if (isset($_POST['edit_equipment'])) {
    $equipment_id = $_POST['equipment_id'];
    $name = $_POST['equipment_name'];
    $quantity = $_POST['equipment_quantity'];
    $condition = $_POST['equipment_condition'];
    $maintenance_date = $_POST['equipment_maintenance_date'];
    $location = $_POST['equipment_location'];

    $stmt = $pdo->prepare("UPDATE equipment SET name=?, quantity=?, `condition`=?, maintenance_date=?, location=? WHERE equipment_id=?");
    $stmt->execute([$name, $quantity, $condition, $maintenance_date, $location, $equipment_id]);

    echo "<script>alert('Equipment updated successfully!'); window.location.href='resource.php';</script>";
}

// Delete Equipment
if (isset($_GET['delete_equipment'])) {
    $equipment_id = $_GET['delete_equipment'];
    $stmt = $pdo->prepare("DELETE FROM equipment WHERE equipment_id = ?");
    $stmt->execute([$equipment_id]);

    echo "<script>alert('Equipment deleted successfully!'); window.location.href='resource.php';</script>";
}

// Add Supplement
if (isset($_POST['add_supplement'])) {
    $name = $_POST['supplement_name'];
    $type = $_POST['supplement_type'];
    $quantity = $_POST['supplement_quantity'];
    $expiration_date = $_POST['supplement_expiration_date'];
    $supplier = $_POST['supplement_supplier'];

    $stmt = $pdo->prepare("INSERT INTO supplement (name, type, quantity, expiration_date, supplier) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $type, $quantity, $expiration_date, $supplier]);

    echo "<script>alert('Supplement added successfully!'); window.location.href='resource.php';</script>";
}

// Edit Supplement
if (isset($_POST['edit_supplement'])) {
    $supplement_id = $_POST['supplement_id'];
    $name = $_POST['supplement_name'];
    $type = $_POST['supplement_type'];
    $quantity = $_POST['supplement_quantity'];
    $expiration_date = $_POST['supplement_expiration_date'];
    $supplier = $_POST['supplement_supplier'];

    $stmt = $pdo->prepare("UPDATE supplement SET name=?, type=?, quantity=?, expiration_date=?, supplier=? WHERE supplement_id=?");
    $stmt->execute([$name, $type, $quantity, $expiration_date, $supplier, $supplement_id]);

    echo "<script>alert('Supplement updated successfully!'); window.location.href='resource.php';</script>";
}

// Delete Supplement
if (isset($_GET['delete_supplement'])) {
    $supplement_id = $_GET['delete_supplement'];
    $stmt = $pdo->prepare("DELETE FROM supplement WHERE supplement_id = ?");
    $stmt->execute([$supplement_id]);

    echo "<script>alert('Supplement deleted successfully!'); window.location.href='resource.php';</script>";
}

// Fetch all equipment and supplements
$equipment_list = $pdo->query("SELECT * FROM equipment")->fetchAll(PDO::FETCH_ASSOC);
$supplement_list = $pdo->query("SELECT * FROM supplement")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Management</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Resource Management</h1>

    <!-- Equipment Section -->
    <h3>Manage Equipment</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Condition</th>
                <th>Maintenance Date</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($equipment_list as $equipment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($equipment['name']); ?></td>
                    <td><?php echo htmlspecialchars($equipment['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($equipment['condition']); ?></td>
                    <td><?php echo htmlspecialchars($equipment['maintenance_date']); ?></td>
                    <td><?php echo htmlspecialchars($equipment['location']); ?></td>
                    <td>
                        <a href="edit_equipment.php?id=<?php echo $equipment['equipment_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="resource.php?delete_equipment=<?php echo $equipment['equipment_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Supplement Section -->
    <h3>Manage Supplements</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Expiration Date</th>
                <th>Supplier</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($supplement_list as $supplement): ?>
                <tr>
                    <td><?php echo htmlspecialchars($supplement['name']); ?></td>
                    <td><?php echo htmlspecialchars($supplement['type']); ?></td>
                    <td><?php echo htmlspecialchars($supplement['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($supplement['expiration_date']); ?></td>
                    <td><?php echo htmlspecialchars($supplement['supplier']); ?></td>
                    <td>
                        <a href="edit_supplement.php?id=<?php echo $supplement['supplement_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="resource.php?delete_supplement=<?php echo $supplement['supplement_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Add Equipment and Supplement Forms -->
    <div class="mt-5">
        <h3>Add New Equipment</h3>
        <form method="post" action="resource.php">
            <input type="text" name="equipment_name" placeholder="Equipment Name" required>
            <input type="number" name="equipment_quantity" placeholder="Quantity" required>
            <input type="text" name="equipment_condition" placeholder="Condition" required>
            <input type="date" name="equipment_maintenance_date" placeholder="Maintenance Date">
            <input type="text" name="equipment_location" placeholder="Location">
            <button type="submit" name="add_equipment" class="btn btn-primary">Add Equipment</button>
        </form>

        <h3 class="mt-5">Add New Supplement</h3>
        <form method="post" action="resource.php">
            <input type="text" name="supplement_name" placeholder="Supplement Name" required>
            <input type="text" name="supplement_type" placeholder="Type" required>
            <input type="number" name="supplement_quantity" placeholder="Quantity" required>
            <input type="date" name="supplement_expiration_date" placeholder="Expiration Date">
            <input type="text" name="supplement_supplier" placeholder="Supplier">
            <button type="submit" name="add_supplement" class="btn btn-primary">Add Supplement</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
