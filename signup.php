<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styles.css">
	<title>FE: CHARACTER BUILDER</title>
</head>
<body>

    <?php
		include 'header.php';
	?>

    <div class="header">
        <h2>Sign Up</h2>

    </div>

    <form action="server.php" method="post">

        <?php if(isset($_SESSION['reg_error'])):?>
            <p><?=$_SESSION['reg_error']?></p>
        <?php endif; ?>


        <div>
            <label for="username">Username</label>
            <input type="text" name="username" required>

        </div>

        <div>

            <label for="email">Email</label>
            <input type="email" name="email" required>

        </div>

        <div>

            <label for="password">Password</label>
            <input type="password" name="password_1" required>

        </div>

        
        <div>

            <label for="password">Confirm Password</label>
            <input type="password" name="password_2" required>

        </div>

        <p>Already a user? <a href="login.php"> Login</a></p>

        <button type="submit" name="command" value="signup">Sign Up</button>

    </form>


</body>
</html>