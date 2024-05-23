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
$certification_id = $resume_id = $certification_name = $issuing_organization = $issue_date = $expiration_date = "";

// Check if certification_id is set
if(isset($_POST['certification_id'])) {
    $certification_id = $_POST['certification_id'];
    
    // Prepare and execute SELECT statement to retrieve certifications details
    $stmt = $connection->prepare("SELECT * FROM certifications WHERE certification_id = ?");
    $stmt->bind_param("i", $certification_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $resume_id = $row['resume_id'];
        $certification_name = $row['certification_name'];
        $issuing_organization = $row['issuing_organization'];
        $issue_date = $row['issue_date'];
        $expiration_date = $row['expiration_date'];
    } else {
        echo "certifications not found.";
    }
}

?>

<html>
<head>
    <title>Update Certifications</title>
    <!-- Your CSS styles -->
</head>
<body>
    <form method="POST" onsubmit="return confirmUpdate();">
        <input type="hidden" name="certification_id" value="<?php echo $certification_id; ?>">
        <label for="resume_id">Resume ID:</label>
        <input type="number" name="resume_id" value="<?php echo $resume_id; ?>">
        <label for="certification_name">Certification_Name:</label>
        <input type="text" name="certification_name" value="<?php echo $certification_name; ?>">
        <label for="issuing_organization">Issuing_Organization:</label>
        <input type="text" name="issuing_organization" value="<?php echo $issuing_organization; ?>">
        <label for="issue_date">Issue_Date:</label>
        <input type="date" name="issue_date" value="<?php echo $issue_date; ?>">
        <label for="expiration_date">expiration_date:</label>
        <input type="date" name="expiration_date" value="<?php echo $expiration_date; ?>">
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
    $certification_id = $_POST['certification_id'];
    $resume_id = $_POST['resume_id'];
    $certifications_name = $_POST['certification_name'];
    $issuing_organization = $_POST['issuing_organization'];
    $issue_date = $_POST['issue_date'];
    $expiration_date = $_POST['expiration_date'];

    // Update the certifications in the database
    $stmt = $certifications->prepare("UPDATE certifications SET resume_id=?, certifications_name=?, issuing_organization=?, issue_date=?, expiration_date=? WHERE certification_id=?");

    $stmt->bind_param("issssi", $resume_id, $certification_name, $issuing_organization, $issue_date, $expiration_date, $certification_id);

    if ($stmt->execute()) {
        // Redirect to certifications.php after successful update
        header('Location: certifications.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Error handling
        echo "Error updating certifications: " . $stmt->error;
    }
}
?>
