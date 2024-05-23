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
$skill_id = $resume_id = $skill_name = $proficiency_level = "";

// Check if skill_id is set
if(isset($_POST['skill_id'])) {
    $skill_id = $_POST['skill_id'];
    
    // Prepare and execute SELECT statement to retrieve skill details
    $stmt = $connection->prepare("SELECT * FROM skills WHERE skill_id = ?");
    $stmt->bind_param("i", $skill_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $resume_id = $row['resume_id'];
        $skill_name = $row['skill_name'];
        $proficiency_level = $row['proficiency_level'];
    } else {
        echo "Skill not found.";
    }
}

?>

<html>
<head>
    <title>Update Skills</title>
    <!-- Your CSS styles -->
</head>
<body>
    <form method="POST" onsubmit="return confirmUpdate();">
      <input type="hidden" name="skill_id" value="<?php echo $skill_id; ?>">
        <label for="resume_id">Resume_ID:</label>
        <input type="number" name="resume_id" value="<?php echo $resume_id; ?>">
        <label for="skill_name">Skill_Name:</label>
        <input type="text" name="skill_name" value="<?php echo $skill_name; ?>">
        <label for="proficiency_level">Proficiency_Level:</label>
        <input type="text" name="proficiency_level" value="<?php echo $proficiency_level; ?>">
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
    $skill_id = $_POST['skill_id'];
    $resume_id = $_POST['resume_id'];
    $skill_name = $_POST['skill_name'];
    $proficiency_level = $_POST['proficiency_level'];

    // Update the skill in the database
    $stmt = $connection->prepare("UPDATE skills SET resume_id=?, skill_name=?, proficiency_level=? WHERE skill_id=?");
    $stmt->bind_param("issi", $resume_id, $skill_name, $proficiency_level,  $skill_id);
    
    if ($stmt->execute()) {
        // Redirect to skills.php after successful update
        header('Location: skills.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Error handling
        echo "Error updating skills: " . $stmt->error;
    }
}
?>
