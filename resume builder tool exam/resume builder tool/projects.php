<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects Form</title>
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
    <h1><u>Projects Form</u></h1>

    <form method="post" onsubmit="return confirmInsert();">
        <label for="project_id">Project ID:</label>
        <input type="number" id="project_id" name="project_id"><br>
        <label for="resume_id">Resume ID:</label>
        <input type="number" id="resume_id" name="resume_id"><br>
        <label for="project_name">Project Name:</label>
        <input type="text" id="project_name" name="project_name" required><br>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required><br>
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required><br>
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for project insertion
        $stmt = $connection->prepare("INSERT INTO projects (project_id, resume_id, project_name, description, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $project_id, $resume_id, $project_name, $description, $start_date, $end_date);

        // Set parameters from form data
        $project_id = $_POST['project_id'];
        $resume_id = $_POST['resume_id'];
        $project_name = $_POST['project_name'];
        $description = $_POST['description'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM projects";
    $result = $connection->query($sql);
    ?>
</header>

<section>
    <h2>Table of Projects</h2>
    <table>
        <tr>
            <th>Project ID</th>
            <th>Resume ID</th>
            <th>Project Name</th>
            <th>Description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the projects table
        include('dbconnection.php'); // Include your database connection file

        $sql = "SELECT * FROM projects";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $project_id = $row['project_id'];
                echo "<tr>
                    <td>" . $row['project_id'] . "</td>
                    <td>" . $row['resume_id'] . "</td>
                    <td>" . $row['project_name'] . "</td>
                    <td>" . $row['description'] . "</td>
                    <td>" . $row['start_date'] . "</td>
                    <td>" . $row['end_date'] . "</td>
                    <td><a href='delete_projects.php?project_id=$project_id'>Delete</a></td>
                    <td><a href='update_projects.php?project_id=$project_id'>Update</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No data found</td></tr>";
        }
        // Close the database connection
        $connection->close();
        ?>
    </table>
    <center><button><a href="home.html">Back Home</a></button></center>
</section>
<footer>
    <b>UR CBE BIT &copy; 2024 &reg;, Designed by: @leontine niyisubiza</b>
</footer>
</body>
</html>
