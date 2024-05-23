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
$education_id = $resume_id = $institution = $degree = $field_of_study = $start_date = $end_date = "";

// Check if education_id is set
if(isset($_POST['education_id'])) {
    $education_id = $_POST['education_id'];
    
    // Prepare and execute SELECT statement to retrieve education details
    $stmt = $connection->prepare("SELECT * FROM educations WHERE education_id = ?");
    $stmt->bind_param("i", $education_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $resume_id = $row['resume_id'];
        $institution = $row['institution'];
        $degree = $row['degree'];
        $field_of_study = $row['field_of_study'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
    } else {
        echo "Education not found.";
    }
}

?>

<html>
<head>
    <title>Update Education</title>
    <!-- Your CSS styles -->
</head>
<body>
    <form method="POST" onsubmit="return confirmUpdate();">
        <input type="hidden" name="education_id" value="<?php echo $education_id; ?>">
        <label for="resume_id">Resume ID:</label>
        <input type="number" name="resume_id" value="<?php echo $resume_id; ?>">
        <label for="institution">Institution:</label>
        <input type="text" name="institution" value="<?php echo $institution; ?>">
        <label for="degree">Degree:</label>
        <input type="text" name="degree" value="<?php echo $degree; ?>">
        <label for="field_of_study">Field of Study:</label>
        <input type="text" name="field_of_study" value="<?php echo $field_of_study; ?>">
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" value="<?php echo $start_date; ?>">
        <label for="end_date">End Date:</label>
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
    $education_id = $_POST['education_id'];
    $resume_id = $_POST['resume_id'];
    $institution = $_POST['institution'];
    $degree = $_POST['degree'];
    $field_of_study = $_POST['field_of_study'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Update the education in the database
    $stmt = $connection->prepare("UPDATE educations SET resume_id=?, institution=?, degree=?, field_of_study=?, start_date=?, end_date=? WHERE education_id=?");
    $stmt->bind_param("isssssi", $resume_id, $institution, $degree, $field_of_study, $start_date, $end_date, $education_id);
    
    if ($stmt->execute()) {
        // Redirect to educations.php after successful update
        header('Location: educations.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Error handling
        echo "Error updating education: " . $stmt->error;
    }
}
?>
