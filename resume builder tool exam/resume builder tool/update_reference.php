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
$reference_id = $resume_id = $reference_name = $reference_title = $reference_contact = "";

// Check if reference_id is set
if(isset($_POST['reference_id'])) {
    $reference_id = $_POST['reference_id'];
    
    // Prepare and execute SELECT statement to retrieve resume details
    $stmt = $connection->prepare("SELECT * FROM reference WHERE reference_id = ?");
    $stmt->bind_param("i", $reference_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $resume_id = $row['resume_id'];
        $reference_name = $row['reference_name'];
        $reference_title = $row['reference_title'];
        $reference_contact = $row['reference_contact'];
    } else {
        echo "reference not found.";
    }
}

?>

<html>
<head>
    <title>Update Reference</title>
    <!-- Your CSS styles -->
</head>
<body>
    <form method="POST" onsubmit="return confirmUpdate();">
      <input type="hidden" name="reference_id" value="<?php echo $reference_id; ?>">
        <label for="resume_id">resume_id:</label>
        <input type="number" name="resume_id" value="<?php echo $resume_id; ?>">
        <label for="reference_name">reference_name:</label>
        <input type="text" name="reference_name" value="<?php echo $reference_name; ?>">
        <label for="reference_title">reference_title:</label>
        <input type="text" name="reference_title" value="<?php echo $reference_title; ?>">
        <label for="reference_contact">reference_contact:</label>
        <input type="number" name="reference_contact" value="<?php echo $reference_contact; ?>">
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
    $reference_id = $_POST['reference_id'];
    $resume_id = $_POST['resume_id'];
    $reference_name = $_POST['reference_name'];
    $reference_title = $_POST['reference_title'];
    $reference_contact = $_POST['reference_contact'];

    // Update the reference in the database
    $stmt = $connection->prepare("UPDATE reference SET resume_id=?, reference_name=?, reference_title=?, reference_contact=? WHERE reference_id=?");
    $stmt->bind_param("isssi", $resume_id, $reference_name, $reference_title, $reference_contact, $reference_id);
    
    if ($stmt->execute()) {
        // Redirect to reference.php after successful update
        header('Location: reference.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Error handling
        echo "Error updating reference: " . $stmt->error;
    }
}
?>
