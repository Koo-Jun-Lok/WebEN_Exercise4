<?php
$user = 'root';
$pass = '';
$dbname = 'student';
$port = 3307;

$conn = new mysqli('localhost', $user, $pass, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Ensure required POST values exist
    if (!isset($_POST['matric'], $_POST['race'], $_POST['gender'])) {
        die("Missing form fields! <a href='edit.php'>Back to form</a>");
    }

    $matric = $_POST['matric'];
    $race = $_POST['race'];
    $gender = $_POST['gender'];
    $imageName = '';

    // Handle image upload if present
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir); // create uploads folder if it doesn't exist
        }

        $imageName = basename($_FILES["image"]["name"]);
        $targetPath = $uploadDir . $imageName;

        // Move uploaded file
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {
            echo "Image upload failed.<br>";
            $imageName = ''; // fallback to no image
        }
    }

    // Construct SQL with optional image field
    $sql = "UPDATE STUDENT SET Race='$race', Gender='$gender'";
    if ($imageName !== '') {
        $sql .= ", Image='$imageName'";
    }
    $sql .= " WHERE Matric='$matric'";

    // Run the query
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully! <a href='list.php'>Back to List</a>";
    } else {
        echo "Error updating record: " . $conn->error;
    }

} else {
    echo "Invalid request.";
}
?>
