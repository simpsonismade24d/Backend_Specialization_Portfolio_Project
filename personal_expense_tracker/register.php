<?php
 $user = false;
 $isRegistrationSuccessful = false;

if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'db_config.php';
    $username=$_POST['username'];
    $password=$_POST['password'];
    $email=$_POST['email'];
    $country=$_POST['country'];
    $gender=$_POST['gender'];
    
   $sql = "select * from registration where username = '$username'"; 
   $result=mysqli_query($con,$sql);
   if($result){
    $num=mysqli_num_rows($result);
    if($num>false){
      $user = true;
    }else{
       $hashed_password = password_hash($password,PASSWORD_DEFAULT);
       $sql="insert into registration(username,password,email,country,gender)values('$username','$hashed_password','$email','$country','$gender')";
       $result=mysqli_query($con,$sql); 

       $isRegistrationSuccessful = true;

       if ($isRegistrationSuccessful) {
        // Redirect to the login page with a congratulatory message
        header("Location: login.php?registration=success");
        exit();
          }else{
           die(mysqli_error($con));
    }
    }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Personal Expense Tracker</title>
    <link href="access/register.css" rel ="stylesheet"/>
</head>
<body>
    <div class="container">
    <?php
       if($user){
       echo '<div class="alert alert-danger" role="alert">
       <strong style="color:red;">Oop! sorry.. that username already exists, try to use another one!</strong>
       </div>';
       }
    ?> 
        <h1>Personal Expense Tracker PET<br>Register</h1>
        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            <label for="country">Country:</label>
            <select id="country" name="country" required>
                <option value="">Select Country</option>
                <option value="Egypt">Egypt</option>
                <option value="Tunisia">Tunisia</option>
                <option value="Nigeria">Nigeria</option>
                <option value="South Africa">South Africa</option>
                <option value="Ghana">Ghana</option>
                <option value="Ghana">Liberia</option>
                <option value="Kenya">Kenya</option>
                <option value="Europe">Europe</option>
                <option value="Australia">Australia</option>
                <option value="North America">North America</option>
                <option value="South America">South America</option>
                <option value="Northern Africa">Northern Africa</option>
                <option value="Asia">Asia</option>
                <option value="Other African Country">Other African Country</option>
                <!-- Add more countries as needed -->
            </select>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Click here to log in</a></p>
    </div>
</body>
</html>
