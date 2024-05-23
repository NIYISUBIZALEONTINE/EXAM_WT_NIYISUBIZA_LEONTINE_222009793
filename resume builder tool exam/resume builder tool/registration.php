<!DOCTYPE html>
<html lang="en">
<head>
    <!-- official website designed by G8 on 24th march 2024-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"],
        button[type="reset"] {
            width: 48%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
        }

        button[type="reset"] {
            background-color: #6c757d;
            color: #fff;
        }

        button[type="submit"]:hover,
        button[type="reset"]:hover {
            opacity: 0.8;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 class="text-center mt-5 mb-4"><i>REGISTRATION FORM</i></h3>
        <form action="userdata.php" method="POST">
            <div class="form-group">
                <label>UserID</label>
                <input type="text" name="UserID" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="Email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="Password" class="form-control" required>
            </div>
            <div class="form-group">   
                <label>Gender</label>
                <select name="gender" class="form-control" required>
                <option value="">Select Gender</option>
                <option value=""> female</option>
                <option value="">male</option>   
            </div>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" name="submit" class="btn btn-primary">Registration</button>
                <button type="reset" name="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
    </div>
</body>
</html>
