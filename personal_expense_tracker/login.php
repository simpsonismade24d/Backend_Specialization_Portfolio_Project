
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="access/login.css" rel="stylesheet" />
<title>Login page</title>
</head>
<body>
<div class="login-container">
<?php
$login_success= false;

if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'db_config.php';
    $username=$_POST['username'];
    $password=$_POST['password'];

// Retrieve hashed password from the database based on username
$sql = "SELECT password FROM registration WHERE username = '$username'";
$result = $con->query($sql);

if ($result->num_rows > false) {
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

    // Verify the password
    if (password_verify($password, $hashed_password)) {
        session_start();
    $_SESSION['username'] = $username;
    header("Location: homepage.php");
    exit();
    } else {
        echo "<p style ='color:red;'>Incorrect password or Username, Please try again.</p>";
    }
} else {
    echo "<p style='color:red;'>User not found.</p>";
}

$con->close();

}
?>


<div class = "login-head">
<p><?php
        // Check if a congratulatory message is present in the URL
        if (isset($_GET['registration']) && $_GET['registration'] === 'success') {
            echo '<p style="color:green; font-weight:400;">Congratulations! You have successfully registered. Please log in.</p>';
        }
        ?>
</p>
</div>
  <h2>Login</h2>
  <form id="login-form" action="login.php" method="post">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn">Login</button>
  </form>

  <p>or click the botton below<br>to register new account</p>
  <a href="register.php"><button class="btn">Register</button></a>
</div>

</body>
</html>
