<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Personal Expense Tracker</title>
    <link href= "access/contact_us.css" rel ="stylesheet"/> 
</head>
<body>
    <div class="navbar">
        <a href="homepage.php">Home</a>
        <a href="expense_report.php">Expense</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
    <?php
$executed = false;
$client = false;
if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'db_config.php';
    $name=$_POST['name'];
    $email=$_POST['email'];
    $country=$_POST['country'];
    $message=$_POST['message'];

    $sql = "select * from enquiry_tb where name = '$name'"; 
   $result=mysqli_query($con,$sql);
   if($result){
    $num=mysqli_num_rows($result);
    if($num>false){
      $client = true;
    }else{
       $sql="insert into enquiry_tb(name,country,email,message)values('$name','$country','$email','$message')";
       $result=mysqli_query($con,$sql); 
       if($result){
          $executed = true;
          }
          else{
           die(mysqli_error($con));
    }
    }
   }
}
?>
<?php
if($executed){
    echo '<div class="alert alert-success" role="alert">
    <strong style = "color: #066c0d;"> Your message was successfully sent, thanks for contacting us!</strong>
  </div>';
}
  ?> 
        <h1>Contact Us</h1>
        <form action="contact_us.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="country">Country:</label>
            <input type="text" id="country" name="country" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>

            <button type="submit">Submit</button>
        </form>
    </div>
    <div style = "background-color: brown; width:100%; height:18px; text-align: center;">
<p style ="color: white; padding-top 10px;">Sim-Technologies © 2023 | All rights reserved</p>
</div>
</body>
</html>
