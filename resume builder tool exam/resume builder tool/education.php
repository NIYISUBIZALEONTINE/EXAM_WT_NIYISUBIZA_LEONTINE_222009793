<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education Form</title>
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
    <h1><u>Education Form</u></h1>

    <form method="post" onsubmit="return confirmInsert();">
        <label for="education_id">Education ID:</label>
        <input type="number" id="education_id" name="education_id"><br>
        <label for="resume_id">Resume ID:</label>
        <input type="number" id="resume_id" name="resume_id"><br>
        <label for="institution">Institution:</label>
        <input type="text" id="institution" name="institution" required><br>
        <label for="degree">Degree:</label>
        <input type="text" id="degree" name="degree" required><br>
        <label for="field_of_study">Field of Study:</label>
        <input type="text" id="field_of_study" name="field_of_study" required><br>
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required><br>
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for education insertion
        $stmt = $connection->prepare("INSERT INTO education (education_id, resume_id, institution, degree, field_of_study, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssss", $education_id, $resume_id, $institution, $degree, $field_of_study, $start_date, $end_date);

        // Set parameters from form data
        $education_id = $_POST['education_id'];
        $resume_id = $_POST['resume_id'];
        $institution = $_POST['institution'];
        $degree = $_POST['degree'];
        $field_of_study = $_POST['field_of_study'];
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

    $sql = "SELECT * FROM education";
    $result = $connection->query($sql);
    ?>
</header>

<section>
    <h2>Table of Education</h2>
    <table>
        <tr>
            <th>Education ID</th>
            <th>Resume ID</th>
            <th>Institution</th>
            <th>Degree</th>
            <th>Field of Study</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the education table
        include('dbconnection.php'); // Include your database connection file

        $sql = "SELECT * FROM education";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $education_id = $row['education_id'];
                echo "<tr>
                    <td>" . $row['education_id'] . "</td>
                    <td>" . $row['resume_id'] . "</td>
                    <td>" . $row['institution'] . "</td>
                    <td>" . $row['degree'] . "</td>
                    <td>" . $row['field_of_study'] . "</td>
                    <td>" . $row['start_date'] . "</td>
                    <td>" . $row['end_date'] . "</td>
                    <td><a href='delete_education.php?education_id=$education_id'>Delete</a></td>
                    <td><a href='update_education.php?education_id=$education_id'>Update</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No data found</td></tr>";
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
