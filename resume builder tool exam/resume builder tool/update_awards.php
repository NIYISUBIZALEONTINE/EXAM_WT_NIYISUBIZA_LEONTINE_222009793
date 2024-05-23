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
$award_id = $award_title = $issuing_organization = $issue_date = "";

// Check if award_id is set
if(isset($_POST['award_id'])) {
    $award_id = $_POST['award_id'];
    
    // Prepare and execute SELECT statement to retrieve awards details
    $stmt = $connection->prepare("SELECT * FROM awards WHERE award_id = ?");
    $stmt->bind_param("i", $award_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $award_id = $row['award_id'];
        $award_title = $row['award_title'];
        $issuing_organization = $row['issuing_organization'];
        $issue_date = $row['issue_date'];
    } else {
        echo "Award not found.";
    }
}

?>

<html>
<head>
    <title>Update Awards</title>
    <!-- Your CSS styles -->
</head>
<body>
    <form method="POST" onsubmit="return confirmUpdate();">
        <input type="hidden" name="award_id" value="<?php echo $award_id; ?>">
        <label for="award_title">Award Title:</label>
        <input type="text" name="award_title" value="<?php echo $award_title; ?>">
        <label for="issuing_organization">Issuing Organization:</label>
        <input type="text" name="issuing_organization" value="<?php echo $issuing_organization; ?>">
        <label for="issue_date">Issue Date:</label>
        <input type="date" name="issue_date" value="<?php echo $issue_date; ?>">
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
    $award_id = $_POST['award_id'];
    $award_title = $_POST['award_title'];
    $issuing_organization = $_POST['issuing_organization'];
    $issue_date = $_POST['issue_date'];

    // Update the awards in the database
    $stmt = $connection->prepare("UPDATE awards SET award_title=?, issuing_organization=?, issue_date=? WHERE award_id=?");
    $stmt->bind_param("sssi", $award_title, $issuing_organization, $issue_date, $award_id);
    
    if ($stmt->execute()) {
        // Redirect to awards.php after successful update
        header('Location: awards.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Error handling
        echo "Error updating award: " . $stmt->error;
    }
}
?>
