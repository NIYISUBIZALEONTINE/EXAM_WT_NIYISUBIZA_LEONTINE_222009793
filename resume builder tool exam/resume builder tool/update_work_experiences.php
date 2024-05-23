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
$experience_id = $resume_id = $company = $position = $description = $start_date = $end_date = "";

// Check if experience_id is set
if(isset($_POST['experience_id'])) {
    $experience_id = $_POST['experience_id'];
    
    // Prepare and execute SELECT statement to retrieve work_experiences details
    $stmt = $connection->prepare("SELECT * FROM work_experiences WHERE experience_id = ?");
    $stmt->bind_param("i", $experience_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $resume_id = $row['resume_id'];
        $company = $row['company'];
        $position = $row['position'];
        $description = $row['description'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
    } else {
        echo "work_experiences not found.";
    }
}

?>

<html>
<head>
    <title>Update Work_Experiences</title>
    <!-- Your CSS styles -->
</head>
<body>
    <form method="POST" onsubmit="return confirmUpdate();">
        <input type="hidden" name="experience_id" value="<?php echo $experience_id; ?>">
        <label for="resume_id">Resume ID:</label>
        <input type="number" name="resume_id" value="<?php echo $resume_id; ?>">
        <label for="company">Company:</label>
        <input type="text" name="company" value="<?php echo $company; ?>">
        <label for="position">Position:</label>
        <input type="text" name="position" value="<?php echo $position; ?>">
        <label for="description">Description:</label>
        <input type="text" name="description" value="<?php echo $description; ?>">
        <label for="start_date">Start_Date:</label>
        <input type="date" name="start_date" value="<?php echo $start_date; ?>">
        <label for="end_date">End_Date:</label>
        <input type="date" name="end_date" value="<?php echo $end_date; ?>">
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
    $experience_id = $_POST['experience_id'];
    $resume_id = $_POST['resume_id'];
    $company = $_POST['company'];
    $position = $_POST['position'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
     $end_date = $_POST['end_date'];

    // Update the work_experiences in the database
    $stmt = $work_experiences->prepare("UPDATE work_experiences SET resume_id=?, company=?, position=?, description=?, start_date=?, end_date=? WHERE experience_id=?");

    $stmt->bind_param("isssssi", $resume_id, $company, $position, $description, $start_date, $end_date, $experience_id);

    if ($stmt->execute()) {
        // Redirect to work_experiences.php after successful update
        header('Location: work_experiences.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Error handling
        echo "Error updating certifications: " . $stmt->error;
    }
}
?>
