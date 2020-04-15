<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<title>FE: CHARACTER BUILDER</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="header">
        <h2>Login</h2>
    </div>
    <form action="server.php" method="post">
        <div>
            <label for="username">Username</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password_1" required>

            <?php if(isset($_SESSION['log_error'])):?>
                <p><?=$_SESSION['log_error']?></p>
            <?php endif; ?>

        </div>
        <p>Not a user? <a href="signup.php"> Sign up</a></p>
        <button type="submit" name="command" value="login">Login</button>
    </form>
</body>
</html>

