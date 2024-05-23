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
$resume_id = $user_id = $title = $summary = $created_date = $modified_date = "";

// Check if resume_id is set
if(isset($_POST['resume_id'])) {
    $resume_id = $_POST['resume_id'];
    
    // Prepare and execute SELECT statement to retrieve resume details
    $stmt = $connection->prepare("SELECT * FROM resumes WHERE resume_id = ?");
    $stmt->bind_param("i", $resume_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
        $title = $row['title'];
        $summary = $row['summary'];
        $created_date = $row['created_date'];
        $modified_date = $row['modified_date'];
    } else {
        echo "Resume not found.";
    }
}

?>

<html>
<head>
    <title>Update Resumes</title>
    <!-- Your CSS styles -->
</head>
<body>
    <form method="POST" onsubmit="return confirmUpdate();">
      <input type="hidden" name="resume_id" value="<?php echo $reusume_id; ?>">
        <label for="user_id">User_ID:</label>
        <input type="number" name="user_id" value="<?php echo $user_id; ?>">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo $title; ?>">
        <label for="summary">Summary:</label>
        <input type="text" name="summary" value="<?php echo $summary; ?>">
        <label for="created_date">Created_Date:</label>
        <input type="date" name="created_date" value="<?php echo $created_date; ?>">
        <label for="modified_date">Modified_Date:</label>
        <input type="date" name="modified_date" value="<?php echo $modified_date; ?>">
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
    $resume_id = $_POST['resume_id'];
    $user_id = $_POST['user_id'];
    $title = $_POST['title'];
    $summary = $_POST['summary'];
    $created_date = $_POST['created_date'];
    $modified_date = $_POST['modified_date'];

    // Update the resume in the database
    $stmt = $connection->prepare("UPDATE resumes SET user_id=?, title=?, summary=?, created_date=?, modified_date=? WHERE resume_id=?");
    $stmt->bind_param("issssi", $user_id, $title, $summary, $created_date, $modified_date, $resume_id);
    
    if ($stmt->execute()) {
        // Redirect to resumes.php after successful update
        header('Location: resumes.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Error handling
        echo "Error updating resume: " . $stmt->error;
    }
}
?>
