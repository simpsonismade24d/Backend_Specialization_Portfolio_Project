<?php 
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("Location: login.php");
    exit();
}
	require_once('db_config.php');
?>





<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Record Expense</title>
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
                <a class="navbar-brand" href="homepage.php" style ="background-color: #9400D3; font-size: 30px;">PE-Tracker</a> 
            </div>
           <!--  dddddddddd -->
 <div style="color: white;padding: 15px 50px 5px 50px;float: right;font-size: 25px;">Personal Expense Tracker &nbsp; <div class="btn-group pull-right">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
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
				<li class="text-center">
                    <img src="assets/img/user.png" class="user-image img-responsive"/>
					</li>
				
					
                    <li>
                    <a   href="homepage.php" ><i class="fa fa-dashboard fa-3x"></i><?php echo "$username";?></a>
                    </li>
                  
                      <li  >
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
                        <a class="active-menu" href="#"><i class="fa fa-list  fa-2x"></i>Expense Summery<span class="fa arrow"></span></a>
                        
                        
                        
                          <ul class="nav nav-second-level">
             <li>
                                <a href="expense_report.php"><i class="fa fa-file"></i>Expense Report</a>
                            </li>
                            <li>
                                <a href=" "><i class="fa fa-check-circle"></i>  </a>
                          
                            
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
               
                          
               
               
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Expense Details <cdiv class="pull-right">Filter Report using the search</cdiv> 
                        </div>
        <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
              <!-- <tr> -->
              <th>Expense Name</th>
              <th>Amount Spent</th>
              <th>Description</th>
              <th>Date</th>
              <th>Action</th>
              </tr>
    </thead>
    <tbody>
  
                        
  <?php					
	$sql = mysqli_query($con, "SELECT *FROM expense_category i LEFT JOIN expense_value s ON i.expense_category_id= s.expense_category_id
  WHERE (s.expense_category_id>0 )");
							while($row = mysqli_fetch_array($sql))
			                   	{
                            ?>
							<tr>
							<td><?php echo $row['expense_category_name'];?></td>
							<td><?php echo $row['amount_spent'];?></td>
              <td><?php echo $row['expense_description'];?></td>
              <td><?php echo $row['expense_date'];?></td>
              <td>
              <button type="button" class="btn btn-danger btn-xs" data-target="#modal_delete<?php echo $row['expense_id']?>"data-toggle='modal'><span class='glyphicon glyphicon-trash'></span> Delete</button>
             </td>

             <div class="modal fade" id="modal_delete<?php echo $row['expense_id']?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title">System</h3>
                </div>
                <div class="modal-body">
                  <center><h4>Are you sure you want to delete this expense?</h4></center>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                  <a type="button" class="btn btn-danger" href="delete.php?expense_id=<?php echo $row['expense_id']?>">Yes</a>
                </div>
              </div>
            </div>
          </div>  
            <?php }?>
            
            <?php
						          
						 
						 ob_flush();
             mysqli_close($con);
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