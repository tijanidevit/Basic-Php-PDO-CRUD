<?php 
	session_start();
	include_once 'connect.php';
	$username = $_SESSION["username"];

	$query = $db->prepare("DELETE FROM users WHERE username = ?");
	if ($query->execute([$username])) {
		session_unset($_SESSION["username"]);
		session_destroy();
		header('location: index.php');
	}
?>