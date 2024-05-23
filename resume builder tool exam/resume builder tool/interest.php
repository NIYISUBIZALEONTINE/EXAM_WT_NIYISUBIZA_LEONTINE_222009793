<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interest Form</title>
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
    <h1><u>Interest Form</u></h1>

    <form method="post" onsubmit="return confirmInsert();">
        <label for="interest_id">Interest ID:</label>
        <input type="number" id="interest_id" name="interest_id"><br>
        <label for="resume_id">Resume ID:</label>
        <input type="number" id="resume_id" name="resume_id"><br>
        <label for="interest_name">Interest Name:</label>
        <input type="text" id="interest_name" name="interest_name" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for interest insertion
        $stmt = $connection->prepare("INSERT INTO interest (interest_id, resume_id, interest_name) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $interest_id, $resume_id, $interest_name);

        // Set parameters from form data
        $interest_id = $_POST['interest_id'];
        $resume_id = $_POST['resume_id'];
        $interest_name = $_POST['interest_name'];

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM interest";
    $result = $connection->query($sql);
    ?>
</header>

<section>
    <h2>Table of Interests</h2>
    <table>
        <tr>
            <th>Interest ID</th>
            <th>Resume ID</th>
            <th>Interest Name</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the interest table
        include('dbconnection.php'); // Include your database connection file

        $sql = "SELECT * FROM interest";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $interest_id = $row['interest_id'];
                echo "<tr>
                    <td>" . $row['interest_id'] . "</td>
                    <td>" . $row['resume_id'] . "</td>
                    <td>" . $row['interest_name'] . "</td>
                    <td><a href='delete_interest.php?interest_id=$interest_id'>Delete</a></td>
                    <td><a href='update_interest.php?interest_id=$interest_id'>Update</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No data found</td></tr>";
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
