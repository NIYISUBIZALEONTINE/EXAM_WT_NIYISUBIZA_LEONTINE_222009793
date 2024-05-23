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

// Check if Project_Id is set in the request
if (isset($_REQUEST['project_id'])) {
    $project_id = $_REQUEST['project_id'];

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['project_id'])) {
        // Prepare and execute the DELETE statement
        $stmt = $conn->prepare("DELETE FROM projects WHERE project_id = ?");
        $stmt->bind_param("i", $_POST['project_id']);

        if ($stmt->execute()) {
            // Redirect to projects.php after successful deletion
            header('Location: projects.php?msg=Data deleted successfully');
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
                <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($project_id); ?>">
                <input type="submit" value="Delete">
            </form>
        </body>
        </html>
        <?php
    }
} else {
    echo "Project_Id is not set.";
}

$conn->close();
?>
