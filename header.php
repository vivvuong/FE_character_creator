<?php
	session_start();
	require 'connect.php';
?>

<div class="header">
	<a class="active" href="#home"><img src="images/logo.jpg" alt="logo"></a>
		<div class="header-right">
			<a href="index.php">Home</a>
			<a href="characters.php">Characters</a>
			<a href="skills.php">Skills</a>

			<?php if(isset($_SESSION['login']) && isset($_SESSION['username'])):
				$query = "SELECT * FROM users WHERE username = :username";
				$statement = $db->prepare($query);
				$statement->bindValue(':username', $_SESSION['username']);
				$statement->execute();
				$result = $statement->fetch();
				?>
					<a href="create.php">Create</a>
					<?php if($result['admin'] == 1):?>
						<a href="admin.php">Users</a>
					<?php endif ?>
					<a href="logout.php">Logout</a>
					Welcome <a href="profile.php"><?=$_SESSION['username']?></a>!

					<?php 
						$username = $_SESSION['username'];

						$query = "SELECT * FROM users
							WHERE username = :username";
						$user = $db->prepare($query);
						$user->bindValue(':username', $username);
						$user->execute();
						$result = $user->fetch();
					?>

				
					<img src="profile_uploads/<?=$result['profile_image_name'] . '_thumbnail' . '.' . $result['profile_image_type']?>" alt="profile_picture">
	

			<?php endif; ?>

			<?php if(!isset($_SESSION['login']) || $_SESSION['login'] == false):?>
				<a href="login.php">Login</a>
				<a href="signup.php">Sign Up</a>
			<?php endif; ?>
		</div>
</div>

