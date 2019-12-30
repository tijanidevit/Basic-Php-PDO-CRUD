<?php  
	include_once 'connect.php';
	session_start();
	if (isset($_SESSION["username"])) {
		header('location: homepage.php');
	}

	if (isset($_POST["submit"])) {
		$username = $_POST["username"];
		$password = md5($_POST["password"]);

		$query1 = $db->prepare("SELECT * FROM users WHERE username = ? AND password = ? ");
		$query1->execute([$username, $password]);
		if ($query1->rowCount() > 0) {
			$_SESSION['username'] = $username;
			header('location: homepage.php');
		}
		else{ 
			$err = "Invalid Credentials";
		}


		
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
</head>
<body>
	<div class="jumbotron pt-5" style="height: 45em">
		<div class="row pt-5">
			<div class="col-12 col-md-3"></div>	
			<div class="col-12 col-md-6 pt-3 card">
				<div class="container-fluid">
					<h3>Login</h3>
					<form method="post">
						<?php if (isset($err)): ?>
							<div class="alert alert-danger"><?php echo $err ?></div>
						<?php endif ?>
						<div class="form-group">
							<label>Username</label>
							<input required type="text" name="username" class="form-control">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input required type="password" name="password" class="form-control">
						</div>
						
						<div class="form-group">
							<button name="submit" class="btn btn-dark form-control">Login</button>
						</div>
						<p>Don't have an account before? <a href="index.php">register</a></p>
					</form>
				</div>	
			</div>
			<div class="col-12 col-md-3"></div>	
		</div>
	</div>
</body>
</html>