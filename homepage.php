<?php  
include_once 'connect.php';
session_start();
if (! isset($_SESSION["username"])) {
	header('location: index.php');
}
$session_username = $_SESSION['username'];
?>


<!DOCTYPE html>
<html>
<head>
	<title>Homepage</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
</head>
<body>
	<div class="jumbotron pt-5" style="height: 45em">
		<div class="row pt-5">
			<div class="col-12 col-md-3"></div>	
			<div class="col-12 col-md-6 pt-3 pb-3 card">
				<div class="container-fluid">
					<h3>Welcome <?php echo $session_username ?></h3>
					<h5>Your account details are: </h5>

					<?php  
					$query = $db->prepare("SELECT * FROM users WHERE username = ? ");
					$query->execute([$session_username]);
					$user = $query->fetch();

					$username = $user["username"];
					$email = $user["email"];

					?>
					<table class="table">
						<tr>
							<td>Username</td>
							<td><?php echo $username ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><?php echo $email ?></td>
						</tr>
					</table>
					<a href="logout.php">Logout</a> |
					<a href="update.php">update Account</a> |
					<a href="delete.php">Delete Account</a>
				</div>	
			</div>
			<div class="col-12 col-md-3"></div>	
		</div>
	</div>
</body>
</html>