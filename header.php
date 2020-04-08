<?php
	session_start();
?>
<div class="header">
	<a class="active" href="#home"><img src="images/logo.jpg" alt="logo"></a>
		<div class="header-right">
			<a href="index.php">Home</a>
			<a href="characters.php">Characters</a>
			<a href="skills.php">Skills</a>

			<?php if(isset($_SESSION['login']) && isset($_SESSION['username'])):?>
					<a href="create.php">Create</a>
					<a href="logout.php">Logout</a>
					<?="Welcome " . $_SESSION['username'] . "!"?>
			<?php endif; ?>

			<?php if(!isset($_SESSION['login']) || $_SESSION['login'] == false):?>
				<a href="login.php">Login</a>
				<a href="signup.php">Sign Up</a>
			<?php endif; ?>
		</div>
</div>

