<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certifications_ID Form</title>
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
    <h1><u>Certification_ID Form</u></h1>

    <form method="post" onsubmit="return confirmInsert();">
        <label for="certification_id">Certification_ID:</label>
        <input type="number" id="certification_id" name="certification_id"><br>
        <label for="resume_id">Resume ID:</label>
        <input type="number" id="resume_id" name="resume_id"><br>
        <label for="certification_name">Certification Name:</label>
        <input type="text" id="certification_name" name="certification_name" required><br>
        <label for="issuing_organization">Issuing Organization:</label>
        <input type="text" id="issuing_organization" name="issuing_organization" required><br>
        <label for="issue_date">Issue Date:</label>
        <input type="date" id="issue_date" name="issue_date" required><br>
        <label for="expiration_date">Expiration Date:</label>
        <input type="date" id="expiration_date" name="expiration_date" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for certification insertion
        $stmt = $connection->prepare("INSERT INTO certifications (certification_id, resume_id, certification_name, issuing_organization, issue_date, expiration_date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $certification_id, $resume_id, $certification_name, $issuing_organization, $issue_date, $expiration_date);

        // Set parameters from form data
        $certification_id = $_POST['certification_id'];
        $resume_id = $_POST['resume_id'];
        $certification_name = $_POST['certification_name'];
        $issuing_organization = $_POST['issuing_organization'];
        $issue_date = $_POST['issue_date'];
        $expiration_date = $_POST['expiration_date'];

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM certifications";
    $result = $connection->query($sql);
    ?>
</header>

<section>
    <h2>Table of Certifications</h2>
    <table>
        <tr>
            <th>Certification ID</th>
            <th>Resume ID</th>
            <th>Certification Name</th>
            <th>Issuing Organization</th>
            <th>Issue Date</th>
            <th>Expiration Date</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the certifications table
        include('dbconnection.php'); // Include your database connection file

        $sql = "SELECT * FROM certifications";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $certification_id = $row['certification_id'];
                echo "<tr>
                    <td>" . $row['certification_id'] . "</td>
                    <td>" . $row['resume_id'] . "</td>
                    <td>" . $row['certification_name'] . "</td>
                    <td>" . $row['issuing_organization'] . "</td>
                    <td>" . $row['issue_date'] . "</td>
                    <td>" . $row['expiration_date'] . "</td>
                    <td><a href='delete_certifications.php?certification_id=$certification_id'>Delete</a></td>
                    <td><a href='update_certifications.php?certification_id=$certification_id'>Update</a></td>
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
