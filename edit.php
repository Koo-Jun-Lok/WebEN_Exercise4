<?php
$user = 'root';
$pass = '';
$dbname = 'student';
$port = 3307;

$conn = new mysqli('localhost', $user, $pass, $dbname, $port);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'matric' parameter is provided
if (!isset($_GET['matric'])) {
    die("Matric number not provided in URL.");
}

$matric = $_GET['matric'];

// Fetch the student record
$result = $conn->query("SELECT * FROM STUDENT WHERE Matric='$matric'");

// Check if record exists
if (!$result || $result->num_rows === 0) {
    die("No student found with matric number: $matric");
}

$row = $result->fetch_assoc();
?>

<h2>Edit Student</h2>

<form action="update.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="matric" value="<?= htmlspecialchars($row['Matric']) ?>">
    
    Name: <?= htmlspecialchars($row['Name']) ?><br>
    Email: <?= htmlspecialchars($row['Email']) ?><br>

    Race: <input type="text" name="race" value="<?= htmlspecialchars($row['Race'] ?? '') ?>"><br>

    Gender:
    <select name="gender">
        <option value="Male" <?= (isset($row['Gender']) && $row['Gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
        <option value="Female" <?= (isset($row['Gender']) && $row['Gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
    </select><br>

    Image: <input type="file" name="image"><br>

    <input type="submit" value="Update">
</form>
