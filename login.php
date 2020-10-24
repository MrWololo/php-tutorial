<?php require_once 'includes/header.php'; ?>

<div>
    <h1>Log In</h1>
    <p>No account? <a href="register.php">Register Here</a> </p>

    <form action="includes/login-inc.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button type="submit" name="submit">LOGIN</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
