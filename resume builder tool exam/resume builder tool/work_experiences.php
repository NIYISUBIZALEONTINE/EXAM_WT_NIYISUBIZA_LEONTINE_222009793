<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work_Experiences_ID Form</title>
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
            background-color: grey;
        }
        footer {
            background-color: gray;
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
    <h1><u>Work_Experiences_ID Form</u></h1>

    <form method="post" onsubmit="return confirmInsert();">
        <label for="experience_id">Experiences_ID:</label>
        <input type="number" id="experience_id" name="experience_id"><br>
        <label for="resume_id">Resume ID:</label>
        <input type="number" id="resume_id" name="resume_id"><br>
        <label for="company">Company:</label>
        <input type="text" id="company" name="company" required><br>
        <label for="position">Position:</label>
        <input type="text" id="position" name="position" required><br>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required><br>
        <label for="start_date">Start_Date:</label>
        <input type="date" id="start_date" name="start_date" required><br>
        <label for="end_date">End_Date:</label>
        <input type="date" id="end_date" name="end_date" required><br>
        <input type="submit" name="add" value="Insert">
    </form>
    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for work_experiences insertion
        $stmt = $connection->prepare("INSERT INTO work_experiences (experience_id, resume_id, company, position, description, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssi", $experience_id, $resume_id, $company, $position, $description, $start_date, $end_date);

        // Set parameters from form data
        $experience_id = $_POST['experience_id'];
        $resume_id = $_POST['resume_id'];
        $company = $_POST['company'];
        $position = $_POST['position'];
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

    $sql = "SELECT * FROM work_experiences";
    $result = $connection->query($sql);
    ?>
</header>

<section>
    <h2>Table of Work_Experiences</h2>
    <table>
        <tr>
            <th>Experience_ID</th>
            <th>Resume ID</th>
            <th>Company</th>
            <th>Position</th>
            <th>description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the work_experiences table
        include('dbconnection.php'); // Include your database connection file

        $sql = "SELECT * FROM work_experiences";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $experience_id = $row['experience_id'];
                echo "<tr>
                    <td>" . $row['experience_id'] . "</td>
                    <td>" . $row['resume_id'] . "</td>
                    <td>" . $row['company'] . "</td>
                    <td>" . $row['position'] . "</td>
                    <td>" . $row['description'] . "</td>
                    <td>" . $row['start_date'] . "</td>
                    <td>" . $row['end_date'] . "</td>
                    <td><a href='delete work_experiences.php?experience_id=$experience_id'>Delete</a></td>
                    <td><a href='update_work_experiences.php?experience_id=$experience_id'>Update</a></td>
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
    <b>UR CBE BIT &copy; 2024 &reg;, Designed by: @niyisubiza leontine</b>
</footer>
</body>
</html>
