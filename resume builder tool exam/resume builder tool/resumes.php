<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumes Form</title>
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
    <h1><u>Resumes Form</u></h1>

    <form method="post" onsubmit="return confirmInsert();">
        <label for="resume_id">resume_id:</label>
        <input type="number" id="resume_id" name="resume_id"><br>
        <label for="user_id">user_id:</label>
        <input type="number" id="user_id" name="user_id"><br>
        <label for="title">title:</label>
        <input type="text" id="title" name="title" required><br>
        <label for="summary">summary:</label>
        <input type="text" id="summary" name="summary" required><br>
        <label for="created_date">created_date:</label>
        <input type="date" id="created_date" name="created_date" required><br>
        <label for="modified_date">modified_date:</label>
        <input type="date" id="modified_date" name="modified_date" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for resume insertion
        $stmt = $connection->prepare("INSERT INTO resumes (resume_id,user_id,title,summary, created_date,modified_date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $resume_id, $user_id, $title, $summary, $created_date, $modified_date);

        // Set parameters from form data
        $resume_id = $_POST['resume_id'];
        $user_id= $_POST['user_id'];
        $title = $_POST['title'];
        $summary = $_POST['summary'];
        $created_date = $_POST['created_date'];
        $modified_date = $_POST['modified_date'];

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM resumes";
    $result = $connection->query($sql);
    ?>
</header>

<section>
    <h2>Table of Resumes</h2>
    <table>
        <tr>
            <th>resume_id</th>
            <th>user_id</th>
            <th>title</th>
            <th>summary</th>
            <th>created_date</th>
            <th>modified_date</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the resumes table
        include('dbconnection.php'); // Include your database connection file

        $sql = "SELECT * FROM resumes";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $resume_id = $row['resume_id'];
                echo "<tr>
                    <td>" . $row['resume_id'] . "</td>
                    <td>" . $row['user_id'] . "</td>
                    <td>" . $row['title'] . "</td>
                    <td>" . $row['summary'] . "</td>
                    <td>" . $row['created_date'] . "</td>
                    <td>" . $row['modified_date'] . "</td>
                    <td><a href='delete_resumes.php?resume_id=$resume_id'>Delete</a></td>
                    <td><a href='update_resumes.php?resume_id=$resume_id'>Update</a></td>
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
