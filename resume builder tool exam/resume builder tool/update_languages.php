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
$language_id = $resume_id = $language_name = $proficiency_level = "";

// Check if language_id is set
if(isset($_POST['language_id'])) {
    $language_id = $_POST['language_id'];
    
    // Prepare and execute SELECT statement to retrieve languages details
    $stmt = $connection->prepare("SELECT * FROM languages WHERE language_id = ?");
    $stmt->bind_param("i", $language_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $language_id = $row['language_id'];
        $resume_id = $row['resume_id'];
        $language_name = $row['language_name'];
        $proficiency_level = $row['proficiency_level'];
    } else {
        echo " Languages not found.";
    }
}

?>

<html>
<head>
    <title>Update Languages</title>
    <!-- Your CSS styles -->
</head>
<body>
    <form method="POST" onsubmit="return confirmUpdate();">
        <input type="hidden" name=" language_id" value="<?php echo $language_id; ?>">
        <label for="resume_id">Resume_ID:</label>
        <input type="number" name="resume_id" value="<?php echo $resume_id; ?>">
        <label for="language_name">Nanguage_name:</label>
        <input type="text" name="language_name" value="<?php echo $language_name; ?>">
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
    $language_id = $_POST['language_id'];
    $resume_id = $_POST['resume_id'];
    $language_name = $_POST['language_name'];
    $proficiency_level = $_POST['proficiency_level'];

    // Update the languages in the database
    $stmt = $connection->prepare("UPDATE languages SET resume_id=?, language_name=?, proficiency_level=? WHERE language_id=?");
    $stmt->bind_param("issi", $resume_id, $language_name, $proficiency_level, $language_id);
    
    if ($stmt->execute()) {
        // Redirect to languages.php after successful update
        header('Location: languages.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Error handling
        echo "Error updating languages: " . $stmt->error;
    }
}
?>
