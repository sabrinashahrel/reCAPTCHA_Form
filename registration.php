
<?php
include('config.php'); //connet with database
error_reporting(0);



if (isset($_POST['submit']) && $_POST['g-recaptcha-response'] != "") 
{
  $secret = 'secret_key';//based on your own secret key
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if ($responseData->success) {
    //first validate then insert in database  
	  $fullname=$_POST['fullname'];
  	$matricNum=$_POST['matricNum'];
  	$email=$_POST['email'];
  	$password = $_POST['password'];
  	$cPassword = $_POST['cPassword'];
  	$contact=$_POST['contact'];
	
	if ($password != $cPassword)//ensure the inserted passwords are matched
			$errormsg = "Password not matched!";
		else {
			$hash = password_hash($password, PASSWORD_BCRYPT);//encrypt using Bcrypt hashing algorithm
    	$query=mysqli_query($bd, "insert into user(fullName,matricNum,email,password,contact) values('$fullname','$matricNum','$email','$hash','$contact')");
    	$msg="Registration successfull. Now You can login";
	    	}
   
  }

}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Registration Form</title>
        <!-- CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        
    
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<style>
/* Style all input fields */

/* The message box is shown when the user clicks on the password field */
#message {
  display:none;
  color: #000;
  position: relative;
  padding: 5px;
  margin-top: 5px;
}

#message p {
  padding: 2px 35px;
  font-size: 12px;
}

/* Add a green text color and a checkmark when the requirements are right */
.valid {
  color: green;
}

.valid:before {
  position: relative;
  left: -15px;
  content: "✔";
}

/* Add a red text color and an "x" when the requirements are wrong */
.invalid {
  color: red;
}

.invalid:before {
  position: relative;
  left: -15px;
  content: "✖";
}
</style>

  </head>
  <body>
    <br>
        <div class="container"> <!-- 1 -->

            <div class="row"> <!-- 2 -->
                <div class="col"></div>
                <div class="col-6"> <!-- 3 -->
                    <div class="card"> <!-- 4 -->
                        <div class="card-header text-center">
                            Registration
                        </div>
                        <div class="card-body"> <!-- 5 -->
                        <p style="padding-left: 1%; color: green; text-align:center;">
		                    	<?php if($msg){
                            echo htmlentities($msg);
		        	            	}?></p>

                         <p style="padding-left: 1%; color: red; text-align:center;">
                             <?php if($errormsg){
                                echo htmlentities($errormsg);
		                      		}?></p>
                            <form method="post">
                            <input type="text"  class="form-control" placeholder="Full Name" name="fullname" required="required" autofocus>
		                         <br>
		                         <input type="text" class="form-control" placeholder="Matric Number" id="matricNum" name="matricNum" required="required">

		                          <br>
				                    	<input type="email" class="form-control" placeholder="Email" required="required" name="email"><br >
		                          <input type="password" class="form-control"  id="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Password" required="required" name="password"><br >
			                    		<input type="password" class="form-control"  id="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Confirm password" required="required" name="cPassword"><br >
			                    	 <input type="text" class="form-control" maxlength="30" name="contact" placeholder="Contact Number" required="required" autofocus>
		                          <br>
                              
        <div id="message"> <!-- Validate the inserted password -->
         <p><b>Password must contain the following:</b></p>
         <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
         <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
         <p id="number" class="invalid">A <b>number</b></p>
         <p id="length" class="invalid">Minimum <b>8 characters</b></p>
         <br>
          </div>
          <div class="g-recaptcha" data-sitekey="site_key"></div><!-- Site key is generate from Google reCaptcha -->
                                <br>
                                <input type="submit" name="submit" class="btn btn-primary">
<br>
					

<script>
var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}


// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>
		            
		            <div class="registration">
		                Already Registered<br/>
		                <a class="" href="index.php">
		                   Sign In
		                </a>
		            </div>
                             
                                <br>
                               
                            </form>
                        </div> <!-- 5 -->
                    </div> <!-- 4 -->
                </div> <!-- 3 -->
                <div class="col"></div>
            </div> <!-- 2 -->

        </div> <!-- 1 -->
    </body>
</html>
 