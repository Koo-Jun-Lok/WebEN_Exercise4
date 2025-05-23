<?php
$user = 'root';
$pass = '';
$dbname = 'student';
$port = 3307;

$conn = new mysqli('localhost', $user, $pass, $dbname, $port);
$filter = '';
if (isset($_GET['race'])) {
    $race = $_GET['race'];
    $filter = "WHERE Race='$race'";
} elseif (isset($_GET['gender'])) {
    $gender = $_GET['gender'];
    $filter = "WHERE Gender='$gender'";
}

$result = $conn->query("SELECT * FROM STUDENT $filter");
?>

<form method="get">
    Search by Race: 
    <select name="race">
        <option value="">--Select--</option>
        <option value="Malay">Malay</option>
        <option value="Chinese">Chinese</option>
        <option value="Indian">Indian</option>
    </select>
    <input type="submit" value="Search">
</form>

<form method="get">
    Search by Gender:
    <select name="gender">
        <option value="">--Select--</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select>
    <input type="submit" value="Search">
</form>

<table border="1">
<tr><th>Matric</th><th>Name</th><th>Email</th><th>Race</th><th>Gender</th><th>Image</th><th>Action</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['Matric'] ?></td>
    <td><?= $row['Name'] ?></td>
    <td><?= $row['Email'] ?></td>
    <td><?= $row['Race'] ?></td>
    <td><?= $row['Gender'] ?></td>
    <td>
        <?php if (!empty($row['Image'])): ?>
            <img src="uploads/<?= $row['Image'] ?>" width="50">
        <?php endif; ?>
    </td>
    <td><a href="edit.php?matric=<?= $row['Matric'] ?>">Edit</a></td>
</tr>
<?php endwhile; ?>
</table>
