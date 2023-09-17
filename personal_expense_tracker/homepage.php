
<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    echo "<p style ='color:green;'>Welcome, $username!</p>";
} else {
    header("Location: login.php");
    exit();
}
require_once('db_config.php');
// $con = register('localhost', 'root', 'admin', 'personal expense_tracker');

//A function to get difference between to numbers
function diff($a=0, $b=0){
  $c = ($a - $b);
  return $c;
}
// echo diff(3,5);


	
if(isset($_POST['submit']) && !empty($_POST['amount_spent']) && !empty($_POST['expense_category_id']) && !empty($_POST['expense_date'])
&& !empty($_POST['expense_description'])){  
    // echo print_r($_POST);
  // exit;
    $amount_spent = mysqli_real_escape_string($con,$_POST['amount_spent']);
    @$expense_date = mysqli_real_escape_string($con,$_POST['expense_date']);
    $expense_description = mysqli_real_escape_string($con,$_POST['expense_description']);
    $expense_category_id = mysqli_real_escape_string($con,$_POST['expense_category_id']);
    $created_at = date('Y-m-d');
    $zero ='0';

     //get a particular row amount and expense_name
    $getAll = mysqli_query($con, "SELECT expense_category_name, amount FROM expense_category WHERE expense_category_id ='".$expense_category_id." ' ");
    while($row = mysqli_fetch_assoc($getAll))
    {
    $_amount = $row['amount']; //SET AMOUNT
    $_expense_category_name = $row['expense_category_name']; 
    // exit;
    }
        
    $getBal = mysqli_query($con, "SELECT expense_category_id, SUM(amount_spent) AS amount_spent FROM expense_value WHERE expense_category_id ='".$expense_category_id." ' GROUP BY  expense_category_id ");
    $sum=0;
  while ($row = mysqli_fetch_assoc($getBal)){
    $_amount_spent = $row['amount_spent'];
    $sum += $_amount_spent;
}

$sum;
//exit;

     $balance =  $_amount - $sum;
    // exit;

    if($balance < 0)
    {
    echo '
    <script type="text/javascript">
    confirm("You are spending too much on '.ucfirst($_expense_category_name).' ");
    </script>'; 
    // exit;
    }

		$data = mysqli_query($con, "INSERT INTO expense_value(expense_category_id,expense_description,expense_date,created_at,deleted,amount_spent)
      VALUES('".$expense_category_id."','".$expense_description."','".$expense_date."','".$created_at."','".$zero."','".$amount_spent."')");
		}	


    //if data inserted successfully
    if(@$data === TRUE)
    {
      echo '
         <script type="text/javascript">
          alert("Successfully inserted!");
         </script>';
    
    }

else{
		$message = "All the fields are required";
	}
?>





<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create personal expense</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
   
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    
      <!--ASWESOME ICON-->
    <link rel="stylesheet" href="font-awesome-4.5.0/css/font-awesome.min.css">
    
   <!--  <script language="javascript" type="text/javascript">
function removeSpaces(string) {
 return string.split(' ').join('');
}
</script> -->



<script language="JavaScript"><!--
function trim(strText) {
    // this will get rid of leading spaces
    while (strText.substring(0,1) == ' ')
        strText = strText.substring(1, strText.length);

    // this will get rid of trailing spaces
    while (strText.substring(strText.length-1,strText.length) == ' ')
        strText = strText.substring(0, strText.length-1);

   return strText;
}
//--></script>




</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0; color:#FF0; background-color:#FDCC46;">
            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php" style ="background-color: #9400D3; font-size:30px;">PE-Tracker</a> 
            </div>
           <!--  dddddddddd -->
 <div style="font-weight: 500; color: blue;padding: 15px 50px 5px 50px;float: right;font-size: 25px;">Personal Expense Tracker &nbsp; <div class="btn-group pull-right">
                <button class="btn b-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"> </span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li></li>
                    <li>
			  <a href="logout.php"><span class="glyphicon glyphicon-log-out"> Logout</span></a></li>
            
            <li class="divider"></li>
            
               <li> <a href="homepage.php"><i><?php echo "<p style ='color:green;'> $username  </p>"; ?> </i></a></li>
                </ul>
            </div>
          </div>
        </nav>         
           <!-- /. NAV TOP  -->
                <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				<li class="text-center" >
                    <img src="assets/img/user.png" class="user-image img-responsive"/>
					</li>
				
					
                    <li>
                        <a   href="homepage.php" ><i class="fa fa-dashboard fa-3x"></i><?php echo "$username";?></a>
                    </li>
                   
                      <li>
                        <?php
                      echo" <li><a  href='homepage.php'><i class='fa fa-keyboard-o fa-2x'></i>Expense List</a></li>";
                      ?>
                       
                    </li>
                    <li  >
                       
                  <?php

	
echo' <li><a  href="expense_category.php"><i class="fa fa-cog fa-2x" aria-hidden="true"></i>Create Expense category</a></li>';
			

 ?>          
                     </li>				
					
					<?php     



                            
                    echo'   <li>
                        <a href="expense_report.php"><i class="fa fa-list  fa-2x"></i>Expense Summery<span class="fa arrow"></span></a>
                        
                        
                        
                          <ul class="nav nav-second-level">
             <li>
                                <a href="expense_report.php "><i class="fa fa-file"></i>Expense Report</a>
                            </li>
                            <li>
                                <a href=" "><i class="fa fa-check-circle"></i> </a>
                          
                            
                                    </li>
										  <li>
                                <a href=" "><i class="fa fa-pause"></i> </a>
                          
                            
                                    </li>
                                </ul>
                               
                            </li>';
                            
                            
                   ?>
                          
                   <div style ='height:50px; background-color:#9400D3;'>
                   <a href='about.php' style='color: white; margin-left:42px; Margin-top:20px; font-size:20px; cursor:pointer;'> About this app</a>
                   </div>        
                           
                            
                            
       
                                </ul>
                               
                            </li>
                                                
                           </ul>
                               
                            </li>
                  <!--   </ul>-->
                      </li>  
                
      </li>				
		</ul>                             
  </li>       
                                  
               
                </ul>
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
               
                           <!--  Modals-->
                    <div class="panel panel-default">
                        <!-- <div class="panel-heading">
                            Modals Example
                        </div> -->
                        <div class="panel-body">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                           <i class="fa fa-plus-circle fa-2x"></i> Create New Expenses
                            </button>
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle fa-1x"></i> Enter Expense</h4>
                                        </div>
                                        <div class="modal-body">
                                          <div class="header"  >
    	<!--<h3 >Add New Department</h3>-->
    </div>
    <div class="content">
        <div>
            <form action="homepage.php" method="POST" enctype="multipart/form-data">
                <!-- <div style=" margin-left:100px;"> -->

        <div class="row" >
        <div class="form-group col-md-6">
          <label for="expense_category_id">Expense Name:</label>
            <select class="form-control" name="expense_category_id" id="expense_category_id"  required="">
              <option value="" selected="">Choose Expense Category</option>
              <?php 
                $getAll = mysqli_query($con, "SELECT * FROM expense_category order by expense_category_name ASC");
                  while($row = mysqli_fetch_array($getAll)):
                ?>
             <option value="<?php echo $row['expense_category_id']; ?>">
                <?php echo  $row['expense_category_name'];?>  
             </option>
           <?php endwhile; ?>   
         </select>
        </div>
       
                    
                  
            <div class="form-group col-md-6" >
               <label> Amount Spent: </label>
                 <input type="text" name="amount_spent" id="amount_spent"  class="form-control"placeholder="Enter Expense Amount :"   onBlur="this.value=trim(this.value);" required>
             </div> 
              </div>        
            
         
              <div class="row" >
               <div class="form-group col-md-6">
                 <label> Expense Description: </label>
                <input type="text" name="expense_description" id="expense_description"  class="form-control"placeholder="Enter Expense Description :"   onBlur="this.value=trim(this.value);" required>
        </div> 
        

        <div class="form-group col-md-6">
            <label> Date: </label>
                <input type="date" name="expense_date" id="expense_date"  class="form-control"placeholder="Enter Expense Date :"   onBlur="this.value=trim(this.value);" required>
      
         </div>
        </div>

        
            <?php  if(isset($message)){echo "<font color='FF0000'><h5>$message</font></h5>";} ?>
        
			
    <!-- </div> -->
                                        <!-- </div> -->
              <div class="row" >
               <div class="form-group">                      
                <div class="modal-footer">                   
                    <input type="submit" id="submit" name="submit"  value="Add" class="btn btn-primary" style=""/>
                    <input type="reset" id="rest" value="Cancel / Reset" class="btn btn-danger" style=""/> 
                 </div>
                </div>
             </div>
            </div>
           </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- End Modals-->
               
               
                    
               
               
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Category List
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                               <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
        <th>Expense Name </th>
        <th>Budget </th>
        <th>Amount Spent </th>
        <th>Current Balance </th>
       
    </tr>
    </thead>
    <tbody>
  
                        
    <?php		
				$_sql = mysqli_query($con, "SELECT i.expense_category_id,  s.amount as amount, s.expense_category_name, SUM(i.amount_spent) as amount_spent
           FROM expense_value i, expense_category s  WHERE (i.expense_category_id = s.expense_category_id) group by i.expense_category_id");
	// $sql = mysqli_query($con, "SELECT *FROM expense_category i LEFT JOIN expense_value s ON i.expense_category_id= s.expense_category_id
 //  WHERE (s.expense_category_id>0 )");
//   if (!$_sql) {
//     printf("Error: %s\n", mysqli_error($con));
//     exit();
// } 
							while($row = mysqli_fetch_array($_sql))
			                   	{
							echo '<tr>';
							echo '<td>'. $row['expense_category_name'] . '</td>';
              echo '<td>'. $row['amount'] . '</td>';
							echo '<td>'. number_format((float)$row['amount_spent'], 2, '.', ''). '</td>';
                $diff = diff($row['amount'], $row['amount_spent']);
                 echo '<td>';
              if($diff < 0 ){
               echo'<div class="btn btn-danger btn-xs" title="You have over spent  '.$row['expense_category_name'].'  budget">'. number_format((float)($diff), 2, '.', '') . '</div>';
              }

              if($diff == 0 ){
               echo'<div class="btn btn-warning btn-xs" title="You have no budget for '.$row['expense_category_name'].' budget">'. number_format((float)($diff), 2, '.', '') . '</div>';
              }

              if($diff > 0 ){
                echo '<div class="btn btn-primary btn-xs" title="You are within '.$row['expense_category_name'].'  budget"">'.number_format((float)($diff), 2, '.', '') . '</div>';
              }
             echo' </td>';
						}
						
						
						 ob_flush();
					?>
                        
      
                        
                        
                        </tbody>
                    </table>



                    
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>





                <!-- /. ROW  -->
            <div class="row"><!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <!-- SWEETALERT SCRIPTS -->
   <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> -->


        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();

            });
    </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    
   
<div style = "background-color: brown; width:100%; height:60px; text-align: center;">
<p style ="color: white;">Sim-Technologies © 2023 | All rights reserved</p>
</div>               
</body>
</html>
