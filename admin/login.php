<?php
session_start();
include('config.php');
include('functions.php');
// Login process
if(isset($_POST["submit"]))
{
        $date=date("Y-m-d H:i:s");
		$ip=$_SERVER['REMOTE_ADDR'];
	$username=mysqli_real_escape_string($con,$_POST["user"]);
	$password1=encryptIt(mysqli_real_escape_string($con,$_POST["password1"]));
	$rslt=mysqli_query($con,"select * from tbl_login where loginUsername='$username' and loginPassword='$password1' and loginActive=1") or die(mysqli_error($con));
    $rows=mysqli_num_rows($rslt);
    if ($rows>0) 
    {
 /* logged in*/
    	while($row=mysqli_fetch_array($rslt))
        {
        	$username=$row['loginUsername'];
            $userType=$row['loginType'];
			$loginId=$row['loginId'];
        }
        $_SESSION['username'] = $username; /*set username to session */
        $_SESSION['userType'] = $userType; /*set userType to session- admin/user */
        $_SESSION['loginId'] = $loginId; /*set userType to session- admin/user */
        mysqli_query($con,"insert into tbl_user_log (logUsername,logTime,logIp,loginStatus) values('$username','$date','$ip','Success')") or die(mysqli_error($con));/* login log */
        echo "<script>location.href = 'index.php'</script>;";
	}
    else
    {
        mysqli_query($con,"insert into tbl_user_log (logUsername,logTime,logIp,loginStatus) values('$username','$date','$ip','Failed')");/* login log */		
    	$_SESSION['err-login']="Invalid Username or Password";
    }
}    
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php echo $title; ?></title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<!--[if IE 8]><link href="css/ie8.css" rel="stylesheet" type="text/css" /><![endif]-->
<!--[if IE 9]><link href="css/ie9.css" rel="stylesheet" type="text/css" /><![endif]-->
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script><script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&amp;sensor=false"></script>

<script type="text/javascript" src="js/plugins/forms/jquery.uniform.min.js"></script>

<script type="text/javascript" src="js/files/bootstrap.min.js"></script>

<script type="text/javascript" src="js/files/login.js"></script>

</head>

<body class="no-background">

	<!-- Fixed top -->
	<div id="top">
		<div class="fixed">
			<a href="index.html" title="" class="logo"><img src="img/logo.png" alt="" /></a>
			<ul class="top-menu">
				<li class="dropdown">
					<a class="login-top" data-toggle="dropdown"></a>
					<ul class="dropdown-menu pull-right">
						<li><a href="#" title=""><i class="icon-group"></i>Change user</a></li>
						<li><a href="#" title=""><i class="icon-plus"></i>New user</a></li>
						<li><a href="#" title=""><i class="icon-cog"></i>Settings</a></li>
						<li><a href="#" title=""><i class="icon-remove"></i>Go to the website</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /fixed top -->


    <!-- Login block -->
    <div class="login">
        <div class="navbar">
            <div class="navbar-inner" style="padding-left: 4%;
    border: 1px solid #00aeef;
    position: relative;
    width: 96%;
    color: #fff;
    margin-left: 0%;
    margin-top: 0%;
    margin-bottom: 0%;
    border-radius: 0px;
    background: #00aeef;">
              <h6><i class="icon-user" style="color: #fff;"></i>Login page</h6>
                  <!--<h5 class="widget-name"><i class="ico-user"></i>Login page</h5>-->
                <div class="nav pull-right">
                    <a href="#" class="dropdown-toggle navbar-icon" data-toggle="dropdown"><i class="icon-cog" style="color: #fff;"></i></a>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="recover-password.php"><i class="icon-refresh"></i>Recover password</a></li>
                        <!--<li><a href="#"><i class="icon-plus"></i>Register</a></li>
                        <li><a href="#"><i class="icon-cog"></i>Settings</a></li>-->
                    </ul>
                </div>
            </div>
        </div>
        <div class="well">
        
        <!-- login form -->
            <form action="login.php" method="post" class="row-fluid">
                <div class="control-group" style="margin-top:40px;">
                    <label class="control-label">User Name</label>
                    <div class="controls"><input class="span12" type="text" name="user" placeholder="User Name" /></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Password:</label>
                    <div class="controls"><input class="span12" type="password" name="password1" placeholder="Password" />
                    <?php if(isset($_SESSION["err-login"]))
					{ /* invalid username or password*/
					?> 
	                    <span class="help-block" style="color:#F00;">Incorrect Username or Password</span>
                    <?php 
						unset($_SESSION["err-login"]);
					}
					?></div>
                </div>

                <div class="control-group">
                    <div class="controls"><label class="checkbox inline"><input type="checkbox" name="checkbox1" class="styled" value="">Remember me</label></div>
                </div>

                <div class="login-btn"><input type="submit" name="submit" value="Log me in" class="btn btn-danger btn-block" style="
    background: #00aeef;
    border: 1px solid #00aeef;
"></div>
            </form>
        <!-- /login form -->            
        </div>
    </div>
    <!-- /login block -->

	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->

</body>
</html>
