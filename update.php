<?php  
	include_once 'connect.php';
	session_start();
	if (! isset($_SESSION["username"])) {
		header('location: index.php');
	}
	$session_username = $_SESSION["username"];

	if (isset($_POST["submit"])) {
		$username = $_POST["username"];
		$email = $_POST["email"];

		$query1 = $db->prepare("SELECT username FROM users WHERE username = ? ");
		$query1->execute([$username]);
		if ($query1->rowCount() > 0) {
			$err = "Username already taken";
		}
		else{
			$query = "UPDATE users SET username = ? , email = ?";
			$query = $db->prepare($query);
			if ($query->execute([$username,$email])) {
				$_SESSION["username"] = $username;
				header('location: homepage.php');
			}
		}	
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Update</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
</head>
<body>
	<div class="jumbotron pt-5" style="height: 45em">
		<div class="row pt-5">
			<div class="col-12 col-md-3"></div>	
			<div class="col-12 col-md-6 pt-3 card">
				<div class="container-fluid">
					<?php  
						$query = $db->prepare("SELECT * FROM users WHERE username = ? ");
						$query->execute([$session_username]);
						$user = $query->fetch();

						$preUsername = $user["username"];
						$preemail = $user["email"];
						
					?>
					<h3>Update</h3>
					<form method="post">
						<?php if (isset($err)): ?>
							<div class="alert alert-danger"><?php echo $err ?></div>
						<?php endif ?>

						<?php if (isset($success)): ?>
							<div class="alert alert-success">Successful</div>
						<?php endif ?>
						<div class="form-group">
							<label>Username</label>
							<input required type="text" value="<?php echo $preUsername ?>" name="username" class="form-control">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input required type="email" value="<?php echo $preemail ?>" name="email" class="form-control">
						</div>
						
						<div class="form-group">
							<button name="submit" class="btn btn-dark form-control">Update</button>
						</div>
					</form>
				</div>	
			</div>
			<div class="col-12 col-md-3"></div>	
		</div>
	</div>
</body>
</html>