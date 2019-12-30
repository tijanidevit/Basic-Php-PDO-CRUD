<?php  
	include_once 'connect.php';
	session_start();
	if (isset($_SESSION["username"])) {
		header('location: homepage.php');
	}

	if (isset($_POST["submit"])) {
		$username = $_POST["username"];
		$email = $_POST["email"];
		$password = $_POST["password"];

		$query1 = $db->prepare("SELECT username FROM users WHERE username = ? ");
		$query1->execute([$username]);
		if ($query1->rowCount() > 0) {
			$err = "Username already registered";
		}
		else{
			if ($username =="") {
				$err = "Username cannot be empty";
			}
			else{
				if (strlen($password) < 6) {
					$err = "Password should be more than 5 characters";
				}
				else
				{
					$password = md5($password);
					$query = "INSERT INTO users(username,email,password) VALUES(?,?,?)";
					$query = $db->prepare($query);
					if ($query->execute([$username,$email,$password])) {
						$_SESSION["username"] = $username;
						header('location: homepage.php');
					}
				}
			}
		}


		
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
</head>
<body>
	<div class="jumbotron pt-5" style="height: 45em">
		<div class="row pt-5">
			<div class="col-12 col-md-3"></div>	
			<div class="col-12 col-md-6 pt-3 card">
				<div class="container-fluid">
					<h3>Register</h3>
					<form method="post">
						<?php if (isset($err)): ?>
							<div class="alert alert-danger"><?php echo $err ?></div>
						<?php endif ?>

						<?php if (isset($success)): ?>
							<div class="alert alert-success">Successful</div>
						<?php endif ?>
						<div class="form-group">
							<label>Username</label>
							<input required type="text" <?php if (isset($username)):?>
							value="<?php echo $username ?>"<?php endif ?> 
							name="username" class="form-control">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input required type="email" <?php if (isset($email)):?>
							value="<?php echo $email ?>"<?php endif ?> 
							name="email" class="form-control">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input required type="password" name="password" class="form-control">
						</div>
						
						<div class="form-group">
							<button name="submit" class="btn btn-dark form-control">Register</button>
						</div>

						<p>Already have an account before? <a href="login.php">login</a></p>
					</form>
				</div>	
			</div>
			<div class="col-12 col-md-3"></div>	
		</div>
	</div>
</body>
</html>