<?php

function headerMessage($attachedMessage)
{
	header('Location: ../register.php?' . $attachedMessage);
	exit();
}

if (isset($_POST['submit'])) {
	require 'database.php';

	$username = $_POST['username'];
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];

	if (empty($username) || empty($password) || empty($confirmPassword)) {
		headerMessage('error=emptyfields&username=' . $username);
	} elseif (!preg_match('/^[a-zA-Z0-9]*/', $username)) {
		headerMessage('error=invalidusername&username=' . $username);
	} elseif ($password !== $confirmPassword) {
		headerMessage('error=passworddoesnotmatch&username=' . $username);
	} else {
		$query = 'SELECT username FROM users WHERE username = ?';
		$statement = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($statement, $query)) {
			headerMessage('error=sqlerror1');
		} else {
			mysqli_stmt_bind_param($statement, 's', $username);
			mysqli_stmt_execute($statement);
			mysqli_stmt_store_result($statement);
			$rowCount = mysqli_stmt_num_rows($statement);

			if ($rowCount > 0) {
				headerMessage('error=usernametaken');
			} else {
				$query = 'INSERT INTO users (username, password) VALUES (?, ?)';
				$statement = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($statement, $query)) {
					headerMessage('error=sqlerror2');
				} else {
					$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

					mysqli_stmt_bind_param($statement, 'ss', $username, $hashedPassword);
					mysqli_stmt_execute($statement);

					headerMessage('success=registered');
				}
			}
		}
	}
	mysqli_stmt_close($statement);
	mysqli_close($conn);
}

?>
