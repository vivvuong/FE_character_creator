<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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