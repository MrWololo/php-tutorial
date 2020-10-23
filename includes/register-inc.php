<?php

if (isset($_POST['submit'])) {
	require 'database.php';

	$username = $_POST['username'];
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];
}

?>
