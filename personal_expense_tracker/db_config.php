<?php
	$con=mysqli_connect("localhost","root","Mysql8394@NG","personal_expense_tracker_db");

		// Check connection
		if (mysqli_connect_errno())
		  {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  }
		  else
		  {
		  	//echo "Connection on";
		  } 


// function register($host, $user_name, $user_password, $db_name){
// $con=mysqli_connect($host, $user_name, $user_password, $db_name);

// 		// Check connection
// 		if (mysqli_connect_errno())
// 		  {
// 		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
// 		  }
// 		  else
// 		  {
// 		  	echo "Connection on";
// 		  }

// return $con;
// }

// register('localhost', 'root', 'admin', 'expense_tracker');

?>

