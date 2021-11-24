<?php
session_start();
error_reporting(0);
include("config.php"); //connet with database

if(isset($_POST['submit']))
{
$ret=mysqli_query($bd, "SELECT * FROM user WHERE matricNum='".$_POST['matricNum']."'");
$num=mysqli_fetch_array($ret);

if($num>0)
{
  $errormsg="Matric number and password not match";//credentials information not match

if (password_verify($_POST['password'], $num['password'])) {
$extra="registration.php";//page after login
$_SESSION['login']=$_POST['matricNum'];
$_SESSION['id']=$num['id'];
$host=$_SERVER['HTTP_HOST'];
$uip=$_SERVER['REMOTE_ADDR'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
}
else //Do not have account
{
$_SESSION['login']=$_POST['matricNum'];	
$errormsg="Account not exist";
$extra="index.php";
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Login Form</title>
        <!-- CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  </head>


  <body>
	  <br>
        <div class="container"> <!-- 1 -->

            <div class="row"> <!-- 2 -->
                <div class="col"></div>
                <div class="col-6"> <!-- 3 -->
                    <div class="card"> <!-- 4 -->
                        <div class="card-header text-center"> 
                            Login Form
                        </div>
						<div class="card-body"> <!-- 5 -->
						<div class="form-group"> <!-- 6 -->
						<p style="padding-left: 1%; color: green; text-align:center;">
		                    	<?php if($msg){
                            echo htmlentities($msg);
		        	            	}?></p>

                         <p style="padding-left: 1%; color: red; text-align:center;">
                             <?php if($errormsg){
                                echo htmlentities($errormsg);
		                      		}?></p>
						<form method="post"> 
		            <input type="text" class="form-control" name="matricNum" placeholder="Matric Number"  required autofocus>
		            <br>
		            <input type="password" class="form-control" name="password" required placeholder="Password">
              	<br>
				  </div> <!-- 6 -->
					       <button class="btn btn-primary" name="submit" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
		            <br>
		           </form>
		            <div class="registration">
		                Don't have an account yet?<br/>
		                <a class="" href="registration.php">
		                    Create an account
		                </a>
		            </div>
		
		    
                    </div> <!-- 5 -->
                </div> <!-- 4 -->
				</div> <!-- 3 -->
                <div class="col"></div>
            </div> <!-- 2 -->

        </div> <!-- 1 -->
    </body>
</html>
