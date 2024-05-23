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

// Check if Language_Id is set in the request
if (isset($_REQUEST['language_id'])) {
    $language_id = $_REQUEST['language_id'];

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['language_id'])) {
        // Prepare and execute the DELETE statement
        $stmt = $conn->prepare("DELETE FROM languages WHERE language_id = ?");
        $stmt->bind_param("i", $_POST['language_id']);

        if ($stmt->execute()) {
            // Redirect to languages.php after successful deletion
            header('Location: languages.php?msg=Data deleted successfully');
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
                <input type="hidden" name="language_id" value="<?php echo htmlspecialchars($language_id); ?>">
                <input type="submit" value="Delete">
            </form>
        </body>
        </html>
        <?php
    }
} else {
    echo "Language_Id is not set.";
}

$conn->close();
?>
