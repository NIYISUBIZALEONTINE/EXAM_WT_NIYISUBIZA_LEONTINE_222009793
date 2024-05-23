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

// Check if Skill_Id is set
if(isset($_REQUEST['skill_id'])) { 
    $Skill_Id = $_REQUEST['skill_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $conn->prepare("DELETE FROM skills WHERE skill_id = ?");
    $stmt->bind_param("i", $Skill_Id);

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
            <input type="hidden" name="skill_id" value="<?php echo $Skill_Id; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($stmt->execute()) {
                // Redirect to skills.php after successful deletion
                header('location: skills.php?msg=Data deleted successfully');
                exit(); // Ensure that no other content is sent after the header redirection
            } else {
                echo "Error deleting data: " . $stmt->error;
            }
        }
        ?>
    </body>
    </html>
    <?php

    $stmt->close();
} else {
    echo "Skill_Id is not set.";
}

$conn->close();
?>
