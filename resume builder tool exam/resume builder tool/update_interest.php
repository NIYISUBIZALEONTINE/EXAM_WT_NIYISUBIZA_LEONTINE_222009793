<?php
// Your connection details
$host = "localhost";
$user = "root";
$pass = "";
$database = "resume_builder_tool";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Initialize variables to avoid PHP notices
$interest_id = $resume_id = $interest_name = "";

// Check if interest_id is set
if(isset($_POST['interest_id'])) {
    $interest_id = $_POST['interest_id'];
    
    // Prepare and execute SELECT statement to retrieve interest details
    $stmt = $connection->prepare("SELECT * FROM interest WHERE interest_id = ?");
    $stmt->bind_param("i", $interest_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $resume_id = $row['resume_id'];
        $interest_name = $row['interest_name'];
    } else {
        echo "Interest not found.";
    }
}

?>

<html>
<head>
    <title>Update Interest</title>
    <!-- Your CSS styles -->
</head>
<body>
    <form method="POST" onsubmit="return confirmUpdate();">
        <input type="hidden" name="interest_id" value="<?php echo $interest_id; ?>">
        <label for="resume_id">Resume ID:</label>
        <input type="number" name="resume_id" value="<?php echo $resume_id; ?>">
        <label for="interest_name">Interest_Name:</label>
        <input type="text" name="interest_name" value="<?php echo $interest_name; ?>">
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<script>
    function confirmUpdate() {
        return confirm('Are you sure you want to update this record?');
    }
</script>

<?php
if(isset($_POST['update'])) {
    // Retrieve updated values from form
    $interest_id = $_POST['interest_id'];
    $resume_id = $_POST['resume_id'];
    $interest_name = $_POST['interest_name'];

    // Update the interest in the database
    $stmt = $connection->prepare("UPDATE interest SET resume_id=?, interest_name=? WHERE interest_id=?");
    $stmt->bind_param("isi", $resume_id, $interest_name,  $interest_id);

    if ($stmt->execute()) {
        // Redirect to interest.php after successful update
        header('Location: interest.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Error handling
        echo "Error updating interest: " . $stmt->error;
    }
}
?>