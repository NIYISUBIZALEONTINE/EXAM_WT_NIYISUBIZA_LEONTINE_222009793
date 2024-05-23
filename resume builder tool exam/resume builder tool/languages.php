<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Languages Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* CSS styles */
        /* Add CSS for table styling */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: blue;
        }
        footer {
            background-color: green;
            text-align: center;
            width: 100%;
            color: white;
            font-size: 25px;
            position: fixed;
            bottom: 0;
            padding: 10px 0;
        }
        button a {
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>
<header>
    <h1><u>Languages Form</u></h1>

    <form method="post" onsubmit="return confirmInsert();">
        <label for="language_id">Language ID:</label>
        <input type="number" id="language_id" name="language_id"><br>
        <label for="resume_id">Resume ID:</label>
        <input type="number" id="resume_id" name="resume_id"><br>
        <label for="language_name">Language Name:</label>
        <input type="text" id="language_name" name="language_name" required><br>
        <label for="proficiency_level">Proficiency Level:</label>
        <input type="text" id="proficiency_level" name="proficiency_level" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for language insertion
        $stmt = $connection->prepare("INSERT INTO languages (language_id, resume_id, language_name, proficiency_level) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $language_id, $resume_id, $language_name, $proficiency_level);

        // Set parameters from form data
        $language_id = $_POST['language_id'];
        $resume_id = $_POST['resume_id'];
        $language_name = $_POST['language_name'];
        $proficiency_level = $_POST['proficiency_level'];

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM languages";
    $result = $connection->query($sql);
    ?>
</header>

<section>
    <h2>Table of Languages</h2>
    <table>
        <tr>
            <th>Language ID</th>
            <th>Resume ID</th>
            <th>Language Name</th>
            <th>Proficiency Level</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the languages table

        $sql = "SELECT * FROM languages";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $language_id = $row['language_id'];
                echo "<tr>
                    <td>" . $row['language_id'] . "</td>
                    <td>" . $row['resume_id'] . "</td>
                    <td>" . $row['language_name'] . "</td>
                    <td>" . $row['proficiency_level'] . "</td>
                    <td><a href='delete_languages.php?language_id=$language_id'>Delete</a></td>
                    <td><a href='update_languages.php?language_id=$language_id'>Update</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        // Close the database connection
        $connection->close();
        ?>
    </table>
    <center><button><a href="home.html">Back Home</a></button></center>
</section>
<footer>
    <b>UR CBE BIT &copy; 2024 &reg;, Designed by: @niyisubiza leontine</b>
</footer>
</body>
</html>
