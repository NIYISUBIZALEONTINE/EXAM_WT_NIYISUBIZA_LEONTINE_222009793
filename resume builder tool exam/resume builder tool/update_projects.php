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
$project_id= $resume_id = $project_name = $description = $start_date = $end_date = "";

 //Check if project_id is set
if(isset($_POST['project_id'])) {
    $project_id = $_POST['project_id'];
    
    // Prepare and execute SELECT statement to retrieve resume details
    $stmt = $connection->prepare("SELECT * FROM projects WHERE project_id = ?");
    $stmt->bind_param("i", $project_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $resume_id = $row['resume_id'];
        $project_name = $row['project_name'];
        $description = $row['description'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
    } else {
        echo "project not found.";
    }
}

?>

<html>
<head>
    <title>Update projects</title>
    <!-- Your CSS styles -->
</head>
<body>
    <form method="POST" onsubmit="return confirmUpdate();">
      <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
        <label for="resume_id">Resume_ID:</label>
        <input type="number" name="resume_id" value="<?php echo $resume_id; ?>">
        <label for="project_name">Project_Name:</label>
        <input type="text" name="project_name" value="<?php echo $project_name; ?>">
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
    $project_id = $_POST['project_id'];
    $resume_id = $_POST['resume_id'];
    $project_name = $_POST['project_name'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Update the project in the database
    $stmt = $connection->prepare("UPDATE projects SET resume_id=?, project_name=?, description=?, start_date=?, end_date=? WHERE project_id=?");
    $stmt->bind_param("issssi", $resume_id, $project_name, $description, $start_date, $end_date, $project_id);
    
    if ($stmt->execute()) {
        // Redirect to projects.php after successful update
        header('Location: projects.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Error handling
        echo "Error updating project: " . $stmt->error;
    }
}
?>
