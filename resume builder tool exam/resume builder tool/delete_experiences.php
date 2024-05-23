<?php
// Connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resume_builder_tool";

// Create the connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if Experience_Id is set in the request
if (isset($_REQUEST['experience_id'])) {
    $Experience_Id = $_REQUEST['experience_id'];

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['experience_id'])) {
        // Prepare and execute the DELETE statement
        $stmt = $conn->prepare("DELETE FROM work_experiences WHERE experience_id = ?");
        $stmt->bind_param("i", $_POST['experience_id']);

        if ($stmt->execute()) {
            // Redirect to work_experiences.php after successful deletion
            header('Location: work_experiences.php?msg=Data deleted successfully');
            exit(); // Ensure that no other content is sent after the header redirection
        } else {
            echo "Error deleting data: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Show the confirmation form
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Delete Record</title>
            <script>
                function confirmDelete() {
                    return confirm("Are you sure you want to delete this record?");
                }
            </script>
        </head>
        <body>
            <form method="post" onsubmit="return confirmDelete();">
                <input type="hidden" name="experience_id" value="<?php echo htmlspecialchars($Experience_Id); ?>">
                <input type="submit" value="Delete">
            </form>
        </body>
        </html>
        <?php
    }
} else {
    echo "Experience_Id is not set.";
}

$conn->close();
?>
