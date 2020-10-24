<?php

function headerMessage($attachedMessage)
{
	header('Location: ../index.php?' . $attachedMessage);
	exit();
}

if (isset($_POST['submit'])) {
	require 'database.php';

	$username = $_POST['username'];
	$password = $_POST['password'];

	if (empty($username) || empty($password)) {
		headerMessage('error=emptyfields');
	} else {
		$query = 'SELECT * FROM users WHERE username = ?';
		$statement = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($statement, $query)) {
			headerMessage('error=sqlerror');
		} else {
			mysqli_stmt_bind_param($statement, 's', $username);
			mysqli_stmt_execute($statement);
			$result = mysqli_stmt_get_result($statement);

			if ($row = mysqli_fetch_assoc($result)) {
				$passCheck = password_verify($password, $row['password']);
				if ($passCheck == false) {
					headerMessage('error=wrongpassword');
				} elseif ($passCheck == true) {
					session_start();
					$_SESSION['sessionId'] = $row['id'];
					$_SESSION['sessionUser'] = $row['username'];
					headerMessage('success=loggedin');
				} else {
					headerMessage('error=wrongpassword');
				}
			} else {
				headerMessage('error=nouser');
			}
		}
	}
} else {
	headerMessage('error=accessforbidden');
}

?>
