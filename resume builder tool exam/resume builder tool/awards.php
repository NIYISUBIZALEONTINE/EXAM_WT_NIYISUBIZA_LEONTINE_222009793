<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awards Form</title>
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
    <h1><u>Awards Form</u></h1>

    <form method="post" onsubmit="return confirmInsert();">
        <label for="award_id">Award ID:</label>
        <input type="number" id="award_id" name="award_id"><br>
        <label for="award_title">Award Title:</label>
        <input type="text" id="award_title" name="award_title" required><br>
        <label for="issuing_organization">Issuing Organization:</label>
        <input type="text" id="issuing_organization" name="issuing_organization" required><br>
        <label for="issue_date">Issue Date:</label>
        <input type="date" id="issue_date" name="issue_date" required><br>
        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('dbconnection.php'); // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters for award insertion
        $stmt = $connection->prepare("INSERT INTO awards (award_id, award_title, issuing_organization, issue_date) VALUES (?, ?, ?, ?)");
       $stmt->bind_param("siss", $award_title, $issuing_organization, $issue_date, $award_id);


        // Set parameters from form data
        $award_id = $_POST['award_id'];
        $award_title = $_POST['award_title'];
        $issuing_organization = $_POST['issuing_organization'];
        $issue_date = $_POST['issue_date'];

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM awards";
    $result = $connection->query($sql);
    ?>
</header>

<section>
    <h2>Table of Awards</h2>
    <table>
        <tr>
            <th>Award ID</th>
            <th>Award Title</th>
            <th>Issuing Organization</th>
            <th>Issue Date</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Output data from the awards table
        include('dbconnection.php'); // Include your database connection file

        $sql = "SELECT * FROM awards";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $award_id = $row['award_id'];
                echo "<tr>
                    <td>" . $row['award_id'] . "</td>
                    <td>" . $row['award_title'] . "</td>
                    <td>" . $row['issuing_organization'] . "</td>
                    <td>" . $row['issue_date'] . "</td>
                    <td><a href='delete_awards.php?award_id=$award_id'>Delete</a></td>
                    <td><a href='update_awards.php?award_id=$award_id'>Update</a></td>
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
