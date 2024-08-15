<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <title>Sign Up</title>
    <style>
        body {
            font-family: 'Poppins',sans-serif;
            background-color: #303030;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            display: flex;
            width: 800px;
        }
        .background-container {
            background-image: url('pictures/logo12.png');
            background-size: cover;
            width: 50%;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }
        input, button{
            font-family: 'Poppins',sans-serif;
        }
        .signup-container {
            /* background-color: rgba(255,255,255,0.13);*/
            background-color: white;
            padding: 20px;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .signup-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .signup-container input {
            width: 93%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .signup-container button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .signup-container button:hover {
            background-color: #0056b3;
        }
        a {
            color: blue;
            font-size: 10px;
            padding-top: 10px;
        }
        .link-container {
            display: flex;
            justify-content: space-between;
        }
        .img-label {
            font-size: 13px;
        }
    </style>
</head>
<body>
    <form action="insert.php" method="POST" enctype="multipart/form-data">
    <div class="container">
        <div class="background-container"></div>
        <div class="signup-container">
            <h2>Sign Up</h2>
            <input type="text" placeholder="First Name" name="firstn" required>
            <input type="text" placeholder="Middle Name" name="middlen" required>
            <input type="text" placeholder="Last Name" name="lastn" required>
            <input type="text" placeholder="Username" name="usern" required>
            <input type="email" placeholder="Email" name="email" required>
            <input type="password" placeholder="Password" name="passw"required>
            <!--<label for="img" class="img-label">Upload your profile picture</label>
            <input type="file" id="img" name="image">-->
            <button type="submit" name="submit">Sign Up</button>
            <div class="link-container">
                <a href="login.php">Already have an account?</a>
            </div>
        </div>
    </div>
    </form>
</body>
</html>
