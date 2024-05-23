<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skills Form</title>
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
    <h1><u>Skills Form</u></h1>

    <form method="post" onsubmit="return confirmInsert();">
        <label for="skill_id">Skill ID:</label>
        <input type="number" id="skill_id" name="skill_id"><br>
        <label for="resume_id">Resume ID:</label>
        <input type="number" id="resume_id" name="resume_id"><br>
        <label for="skill_name">Skill Name:</label>
        <input type="text" id="skill_name" name="skill_name" required><br>
        <label for="proficiency_level">Proficiency Level:</label>
        <input type="text" id="proficiency_level" name="proficiency_level" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for skill insertion
        $stmt = $connection->prepare("INSERT INTO skills (skill_id, resume_id, skill_name, proficiency_level) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $skill_id, $resume_id, $skill_name, $proficiency_level);

        // Set parameters from form data
        $skill_id = $_POST['skill_id'];
        $resume_id = $_POST['resume_id'];
        $skill_name = $_POST['skill_name'];
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

    $sql = "SELECT * FROM skills";
    $result = $connection->query($sql);
    ?>
</header>

<section>
    <h2>Table of Skills</h2>
    <table>
        <tr>
            <th>Skill ID</th>
            <th>Resume ID</th>
            <th>Skill Name</th>
            <th>Proficiency Level</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the skills table
        include('dbconnection.php'); // Include your database connection file

        $sql = "SELECT * FROM skills";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $skill_id = $row['skill_id'];
                echo "<tr>
                    <td>" . $row['skill_id'] . "</td>
                    <td>" . $row['resume_id'] . "</td>
                    <td>" . $row['skill_name'] . "</td>
                    <td>" . $row['proficiency_level'] . "</td>
                    <td><a href='delete_skill.php?skill_id=$skill_id'>Delete</a></td>
                    <td><a href='update_skill.php?skill_id=$skill_id'>Update</a></td>
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