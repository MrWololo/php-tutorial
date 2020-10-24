<?php require_once 'includes/header.php'; ?>

<?php if (isset($_SESSION['sessionId'])) {
	echo 'You are logged in';
} else {
	echo 'HOME';
} ?>

<?php require_once 'includes/footer.php'; ?>
