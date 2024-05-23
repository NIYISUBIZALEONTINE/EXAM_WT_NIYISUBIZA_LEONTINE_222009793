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
        <label for="reference_id">Reference ID:</label>
        <input type="number" id="reference_id" name="reference_id"><br>
        <label for="resume_id">Resume ID:</label>
        <input type="number" id="resume_id" name="resume_id"><br>
        <label for="reference_name">Reference Name:</label>
        <input type="text" id="reference_name" name="reference_name" required><br>
        <label for="reference_title">Reference Title:</label>
        <input type="text" id="reference_title" name="reference_title" required><br>
        <label for="reference_contact">Reference Contact:</label>
        <input type="text" id="reference_contact" name="reference_contact" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for reference insertion
        $stmt = $connection->prepare("INSERT INTO reference (reference_id, resume_id, reference_name, reference_title, reference_contact) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $reference_id, $resume_id, $reference_name, $reference_title, $reference_contact);

        // Set parameters from form data
        $reference_id = $_POST['reference_id'];
        $resume_id = $_POST['resume_id'];
        $reference_name = $_POST['reference_name'];
        $reference_title = $_POST['reference_title'];
        $reference_contact = $_POST['reference_contact'];

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM reference";
    $result = $connection->query($sql);
    ?>
</header>

<section>
    <h2>Table of Reference</h2>
    <table>
        <tr>
            <th>Reference ID</th>
            <th>Resume ID</th>
            <th>Reference Name</th>
            <th>Reference Title</th>
            <th>Reference Contact</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the reference table
        include('dbconnection.php'); // Include your database connection file

        $sql = "SELECT * FROM reference";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $reference_id = $row['reference_id'];
                echo "<tr>
                    <td>" . $row['reference_id'] . "</td>
                    <td>" . $row['resume_id'] . "</td>
                    <td>" . $row['reference_name'] . "</td>
                    <td>" . $row['reference_title'] . "</td>
                    <td>" . $row['reference_contact'] . "</td>
                    <td><a href='delete_reference.php?reference_id=$reference_id'>Delete</a></td>
                    <td><a href='update_reference.php?reference_id=$reference_id'>Update</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No data found</td></tr>";
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
