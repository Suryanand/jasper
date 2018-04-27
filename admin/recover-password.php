<?php
session_start();
include('config.php');
include('functions.php');
// Login process
if(isset($_POST["submit"]))
{
	$username=mysqli_real_escape_string($con,$_POST["user"]);
	$rslt=mysqli_query($con,"select * from tbl_login where loginUsername='$username' and loginApprove=1 and loginActive=1") or die(mysqli_error($con));
    $rows=mysqli_num_rows($rslt);
    if ($rows>0) 
    { /* logged in*/
    	while($row=mysqli_fetch_array($rslt))
        {
			$password1=decryptIt($row["loginPassword1"]);			
        }
	$email_from="support@jaspermicron.com";
    $email_to = $username;
    $email_subject = "Recover Password - Jasper Micron Billing System";
	$email_message	="Dear User, \n\nYour password has been retrieved successfully.\nYour Details are: \n\n";
	$email_message  .= "User Name: ".$username."\n"; 
    $email_message .= "Password: ".$password1."\n\nplease go to https://billing.jaspermicron.com/login.php to login\n\nThank You,\nJasper Micron\nSupport@jaspermicron.com";
     
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);
		
    echo '<script>alert("Recovery email send to your email")</script>';
        echo "<script>location.href = 'login.php'</script>;";
	}
    else
    {
    	$_SESSION['err-login']="Email id not registered";
    }
}?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
     <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div style=" background-color:#04a6be; height:10px;" class="row"></div>
       <div style="padding:10px;" class="container">
      
       <div style="" class="row">
       
       <h1 style="color:#046776;">JM e-Billing System</h1>
       <h6>DIRECT FROM YOUR SMARTPHONE, LAPTOP OR DESKTOP</h6>
       
       
       
       </div><!--1ST ROW-->
       
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom:9%;">
                      
                      
                <div class="menuhdr"> <a style="text-decoration:none;" href="login.php">CLIENT LOGIN </a> &nbsp;&nbsp;&nbsp; 
                <a style="text-decoration:none;" href="contact-us.php"> CONTACT US </a></div>
          </div>
              
              
              <div class="col-lg-12 col-md-12 col-sm-12">
                      
                      
                <div class="CONTENT">
                
                    <h3  style="color:#337ab7;">RECOVER PASSWORD</h3>
                
                
                
                
                 </div>
              </div>
              
             <div class="col-lg-8 col-md-8 col-sm-12">
        <div id="loginbox" style="margin-top:30px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Enter your registered e-mail id</div>
                       
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" method="post" action="" class="form-horizontal" role="form">                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="login-username" type="text" class="form-control" name="user" value="" placeholder="email">                                        
                                    </div>
                    <?php if(isset($_SESSION["err-login"]))
					{ /* invalid username or password*/
					?> 
	                    <span class="help-block" style="color:#F00;"><?php  echo $_SESSION["err-login"]?></span>
                    <?php 
						unset($_SESSION["err-login"]);
					}
					?>
                                

                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div style="padding-left:15PX;" class="col-sm-12 controls">
                                    <input type="submit" value="Recover" name="submit" id="btn-login" class="btn btn-success" />

                                    </div>
                                </div>


                                <div style="margin-bottom:0PX;"  class="form-group">
                                   
                                </div>    
                            </form>     



                        </div>                     
                    </div>  
        </div>
        <div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Sign Up</div>
                            <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Sign In</a></div>
                        </div>  
                        <div class="panel-body" >
                            <form id="signupform" class="form-horizontal" role="form">
                                
                                <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                                </div>
                                    
                                
                                  
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="email" placeholder="Email Address">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="firstname" class="col-md-3 control-label">First Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="firstname" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lastname" class="col-md-3 control-label">Last Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="lastname" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-md-3 control-label">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="passwd" placeholder="Password">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="icode" class="col-md-3 control-label">Invitation Code</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="icode" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-signup" type="button" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Sign Up</button>
                                        <span style="margin-left:8px;">or</span>  
                                    </div>
                                </div>
                                
                                <div style="border-top: 1px solid #999; padding-top:20px"  class="form-group">
                                    
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-fbsignup" type="button" class="btn btn-primary"><i class="icon-facebook"></i>   Sign Up with Facebook</button>
                                    </div>                                           
                                        
                                </div>
                                
                                
                                
                            </form>
                         </div>
                    </div>

               
               
                
         </div> 
         </div>
         
        
         </div><!--2ND ROW-->
         <div style="padding-left:0px;" class="row"> 
         
             <div style="padding-left:0px;" class="col-lg-8 col-md-8 col-sm-12">
             
                <div style="padding-left:0px;" class="col-lg-6 col-md-6 col-sm-12">   
                 
                 <div style="padding-top:20px;" class="col-lg-12 col-md-12 col-sm-12 foot">
                 
                   <a href="https://www.jaspermicron.com/privacy-policy/">Privacy Policy</a>
                   &nbsp;&nbsp
                    <a href="https://www.jaspermicron.com/terms-and-conditions/">Terms and Conditions</a>
                 </div>   
                 
                 <div style="" class="col-lg-12 col-md-12 col-sm-12 foot">Copyright © 2015 Jasper Micron.	</div>
                 
                   
                 
                        	</div>    
					<!-- copyright text -->
                    
                    
                 
                 
             
             
             </div>
         
          <div class="col-lg-4 col-md-4 col-sm-12">
          
               
            <div class="col-lg-12 col-md-12 col-sm-12">
           <img src="images/paypalicon.png" width="125" height="50"> <img src="images/2checkout.png" width="125" height="50">
           <img src="images/ssl certificate.png" width="125" height="50">
           
           
           
           
            
           </div>
           </div>
         
          </div>
         
        
         
    </div><!--container close-->
    
   
   
   
   
   

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>