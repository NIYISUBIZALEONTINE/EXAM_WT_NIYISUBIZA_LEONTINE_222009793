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

// Check if Interest_Id is set in the request
if (isset($_REQUEST['interest_id'])) {
    $Interest_Id = $_REQUEST['interest_id'];

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['interest_id'])) {
        // Prepare and execute the DELETE statement
        $stmt = $conn->prepare("DELETE FROM interest WHERE interest_id = ?");
        $stmt->bind_param("i", $_POST['interest_id']);

        if ($stmt->execute()) {
            // Redirect to interest.php after successful deletion
            header('Location: interest.php?msg=Data deleted successfully');
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
                <input type="hidden" name="interest_id" value="<?php echo htmlspecialchars($Interest_Id); ?>">
                <input type="submit" value="Delete">
            </form>
        </body>
        </html>
        <?php
    }
} else {
    echo "Interest_Id is not set.";
}

$conn->close();
?>
