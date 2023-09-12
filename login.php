<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	  <script>
	function opena(){
		$('#myModal2').modal('show');
	}
		
</script>
<?php
session_start();
$conn = mysqli_connect("localhost","root","","test");
	
$message="";

if(!empty($_POST["login"])) {
	$result = mysqli_query($conn,"SELECT * FROM usuario WHERE user_name='" . $_POST["user_name"] . "'");
	$row  = mysqli_fetch_array($result);
	$query = mysqli_query($conn,"UPDATE usuario SET logged=1 WHERE user_id =".$row['user_id']);
	setcookie('logged', $row['user_id'], time() + (86400 * 30), "/");
	if(is_array($row)) {
	$_SESSION["user_id"] = $row['user_id'];
	} else {
	$message = "Invalid Username or Password!";
	}
}
if(!empty($_POST["logout"])) {
	$query_get = mysqli_query($conn,"SELECT * FROM usuario where user_id=".$_COOKIE['logged']);
	$row  = mysqli_fetch_array($query_get);
	$result = mysqli_query($conn,"UPDATE usuario SET logged=0 WHERE user_id =".$row['user_id']);
	$_SESSION["user_id"] = "";
	session_destroy();
}
?>
<html>
<head>
<title>Web Scrape</title>
<style>
#frmLogin { 
	padding: 20px 60px;
	background: #B6E0FF;
	color: #555;
	display: inline-block;
	border-radius: 4px; 
}
.field-group { 
	margin:15px 0px; 
}
.input-field {
	padding: 8px;width: 200px;
	border: #A3C3E7 1px solid;
	border-radius: 4px; 
}
.form-submit-button {
	background: #65C370;
	border: 0;
	padding: 8px 20px;
	border-radius: 4px;
	color: #FFF;
	text-transform: uppercase; 
}
.member-dashboard {
	padding: 40px;
	background: #D2EDD5;
	color: #555;
	border-radius: 4px;
	display: inline-block;
	text-align:center; 
}
.logout-button {
	color: #09F;
	text-decoration: none;
	background: none;
	border: none;
	padding: 0px;
	cursor: pointer;
}
.error-message {
	text-align:center;
	color:#FF0000;
}
.demo-content label{
	width:auto;
}
</style>
</head>
<body>

<div>
<div style="display:block;margin:0px auto;">
<?php if(empty($_SESSION["user_id"])) { ?>    	
	<div class="modal fade rotate" id="myModal2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Login</h4>
            </div>
            <div class="container"></div>
            <div class="modal-body">
			<form action="" method="post" id="myForm">
			<div class="error-message"><?php if(isset($message)) { echo $message; } ?></div>	
			<select id="user_name" name='user_name'>
    			<option name="user_name">a</option>
    			<option name="user_name">s</option>
			</select>
			
            </div>
            <div class="modal-footer"><a href="#" data-dismiss="modal" class="btn">Close</a>
			<div class="field-group">
			<div><input type="submit" name="login" value="Login" class="form-submit-button"></span></div>
			</div> 
			</form>
            </div>
        </div>
    </div>
	<script>
		
		opena();

		
	</script>
</div>
<?php 
} else { 
$result = mysqlI_query($conn,"SELECT * FROM  usuario WHERE logged=1 AND user_id=".$_COOKIE['logged']);
$logged_in  = mysqli_fetch_array( $result);
?>
<form action="" method="post" id="frmLogout">
<?php
	echo ('Utilizador: '.ucwords($logged_in[1].'<br />'));
?>
<input type="submit" name="logout" value="Logout" class="logout-button">
</form>
</div>
</div>
<?php } ?>
</body></html>
