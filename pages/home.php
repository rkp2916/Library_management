
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Library management system</title>
	<?php
	include("../core/meta.php");
	include("../core/modules/reader_class.php");
	$reader = new Reader();
	if(isset($_POST)){
		if(isset($_POST['admin_username'])){
			if($_POST['admin_username'] == 'admin' &&
			  $_POST['admin_pwd'] == 'admin123'){
				header('Location: admin.php');
			}
			else{
				echo '<script> $("#adminError).show(); </script>';
			}
		}
		else if(isset($_POST['reader_card_no'])){
			$reader_id = $_POST['reader_card_no'];
			if($reader->check_reader_exists($reader_id)){
				$_SESSION['lib_id'] = $_POST['reader_lib_id'];
				$_SESSION['reader_id'] = $reader_id;
				header('Location: reader_dashboard.php');
			}
			else{
				echo '<script> $("#readerError).show(); </script>';
			}
		}
	}
	?>
	<script type="text/javascript">
		function showDialog(type){
			if(type == "admin"){
				$(".home_center_wrapper").hide();
				$(".admin_login_wrapper").show();
			}
			else if(type == "reader"){
				$(".home_center_wrapper").hide();
				$(".reader_login_wrapper").show();
			}
		}
	</script>
</head>

<body class="main-panel" style="background-repeat: no-repeat; background-size: contain;">
	<div class="home_center_wrapper">
		<table>
			<tr>
				<td>
					<div class="jumbotron" onClick="showDialog('admin');">
						<center><image src="http://localhost/library/core/img/admin.png" /><br>
						<h2>Admin</h2>
						</center>
					</div>
				</td>
				<td>
					<div class="jumbotron" onClick="showDialog('reader');">
						<center><image src="http://localhost/library/core/img/reader.png" /><br>
						<h2>Reader</h2>
						</center>
					</div>
				</td>
			</tr>
		</table>
	</div>

	<div class="admin_login_wrapper">
		<h2>Admin login</h2>
		<form action="#" method="post">
			<div class="form-group">
				<label for="usernameField">Username</label>
				<input type="text" class="form-control" id="usernameField" placeholder="Username" name="admin_username">
			  </div>
			  <div class="form-group">
				<label for="passwordField">Password</label>
				<input type="password" class="form-control" id="passwordField" placeholder="Password" name="admin_pwd">
			  </div>
			  <button type="submit" class="btn btn-default">Login</button>
		</form>
		<div class="alert alert-danger" style="display: none" id="admin_error">Username or password is incorrect</div>
	</div>
	
	<div class="reader_login_wrapper">
		<h2>Reader login</h2>
		<form action="#" method="post">
			<div class="form-group">
				<label for="libField">Select branch</label>
				<select name="reader_lib_id" class="form-control" id="libField">
					<?php
						echo $reader->get_branches_only_id();
					?>
				</select>
				<label for="cardNoField">Enter card no</label>
				<input type="text" class="form-control" id="cardNoField" placeholder="Card number" name="reader_card_no">
			  </div>
			  <button type="submit" class="btn btn-default">Login</button>
		</form>
		<div class="alert alert-danger" style="display: none" id="admin_error">Wrong credentials</div>
	</div>
	<div style="
    position: fixed;
    bottom: 10%;
    left: 50%;
    margin-left: -15px;
">
	<button onclick="close();" class="btn btn-danger">Exit</button></div>
</body>
</html>