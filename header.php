<?php
	session_start();
	require 'connect.php';
?>

	<nav class="navbar navbar-expand-lg navbar-light bg-light ml-auto">

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		<a class="nav-item nav-link active" href="index.php">Home</a>
		<a class="nav-item nav-link" href="characters.php">Characters</a>
		<a class="nav-item nav-link" href="skills.php">Skills</a>

		<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			<?php if(isset($_SESSION['login']) && isset($_SESSION['username'])):

				$query = "SELECT * FROM users WHERE username = :username";
				$statement = $db->prepare($query);
				$statement->bindValue(':username', $_SESSION['username']);
				$statement->execute();
				$result = $statement->fetch();?>

				<a class="nav-item nav-link" href="create.php">Create</a>
				<?php if($result['admin'] == 1):?>
					<a class="nav-item nav-link" href="admin.php">Users</a>
				<?php endif ?>

				<nav class="navbar navbar-expand-lg navbar-light bg-light ml-auto">
					<a class="nav-item nav-link" href="logout.php">Logout</a>
					<h5>Welcome <a href="profile.php"><?=$_SESSION['username']?></a>!</h5>
				</nav>

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
				<a class="nav-item nav-link" href="login.php">Login</a>
				<a class="nav-item nav-link" href="signup.php">Sign Up</a>
			<?php endif; ?>
		</div>
	</nav>



