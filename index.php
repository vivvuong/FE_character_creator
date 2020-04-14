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

	<?php if(isset($_SESSION['login'])):?>
		
		<?php if(!isset($_POST['command']) || $_POST['sort'] == "Recent"):?>
			<?php 
				$query = "SELECT * FROM user_created_characters 
				JOIN characters ON user_created_characters.character_id = characters.character_id
				JOIN users ON user_created_characters.username_id = users.id
				JOIN classes ON user_created_characters.class = classes.class_id
				ORDER BY build_id DESC";
				$statement = $db->prepare($query); 
				$statement->execute(); 
			?>
		<?php elseif($_POST['sort'] == "Oldest"):?>
			<?php 
				$query = "SELECT * FROM user_created_characters 
				JOIN characters ON user_created_characters.character_id = characters.character_id
				JOIN users ON user_created_characters.username_id = users.id
				JOIN classes ON user_created_characters.class = classes.class_id
				ORDER BY build_id ASC";
				$statement = $db->prepare($query); 
				$statement->execute(); 
			?>
		<?php else: ?>
			<?php 
				$query = "SELECT * FROM user_created_characters 
				JOIN characters ON user_created_characters.character_id = characters.character_id
				JOIN users ON user_created_characters.username_id = users.id
				JOIN classes ON user_created_characters.class = classes.class_id
				ORDER BY build_title ASC";
				$statement = $db->prepare($query); 
				$statement->execute(); 
			?>
		<?php endif ?>

		<form action="" method="POST">
			<input type="radio" id="recent" name="sort" value="Recent" checked>
			<label for="recent">Recent</label><br>
			<input type="radio" id="oldest" name="sort" value="Oldest">
			<label for="female">Oldest</label><br>
			<input type="radio" id="title" name="sort" value="Title">
			<label for="other">Title</label>

			<button type="submit" name="command" value="create">Submit</button>
		</form>

		<?php if(isset($_POST['command'])):?>
			<h5>Currently Sorted By: <?=$_POST['sort']?></h5>
		<?php endif ?>
		

	<?php foreach($statement as $user):	?>
		<?php
			$build_id = $user['build_id'];
			$class_id = $user['class'];

			$query = "SELECT * FROM class_skills  
				JOIN skills on class_skills.class_skill = skills.skill_id
				WHERE class_id = :class_id";
			$class = $db->prepare($query);
			$class->bindValue(':class_id', $class_id);
			$class->execute();

			$query = "SELECT * FROM user_skills 
				JOIN skills ON user_skills.skill_id = skills.skill_id
				WHERE build_id = :build_id";
			$statement = $db->prepare($query);
			$statement->bindValue(':build_id', $build_id);
			$statement->execute();		
		?>

		<h1><a href="focus.php?build_id=<?=$user['build_id']?>"><?=$user['build_title']?></a></h1>

		<img src="images/<?=$user['character_name']?>.png" alt="<?=$user['character_name']?>">
		<h1><?=$user['character_name']?> / <?=$user['class_name']?></h2>

		<?php if(isset($_SESSION['login']) && isset($_SESSION['username'])):?>
			<?php if($_SESSION['username'] === $user['username']):?>
				<a href="edit.php?build_id=<?=$build_id?>">Edit</a>
			<?php endif ?>
		<?php endif ?>

		<h1>CLASS SKILLS</h1>
		<?php foreach($class as $class):?>
			<h2> <?=$class['skill_name']?> </h2>
			<p> <?=$class['description']?> </p>
		<?php endforeach ?>
		<h1>ASSIGNED SKILLS</h1>
		<?php foreach($statement as $skills):?>
			<h2> <?=$skills['skill_name']?> </h2>
			<p> <?=$skills['description']?> </p>
		<?php endforeach ?>
	<?php endforeach ?>

	<?php else: ?>	
		<?php 
			$query = "SELECT * FROM user_created_characters 
			JOIN characters ON user_created_characters.character_id = characters.character_id
			JOIN users ON user_created_characters.username_id = users.id
			JOIN classes ON user_created_characters.class = classes.class_id
			ORDER BY build_id DESC";
			$statement = $db->prepare($query); 
			$statement->execute(); 
		?>

		<?php foreach($statement as $user):	?>
			<?php
				$build_id = $user['build_id'];
				$class_id = $user['class'];

				$query = "SELECT * FROM class_skills  
					JOIN skills on class_skills.class_skill = skills.skill_id
					WHERE class_id = :class_id";
				$class = $db->prepare($query);
				$class->bindValue(':class_id', $class_id);
				$class->execute();

				$query = "SELECT * FROM user_skills 
					JOIN skills ON user_skills.skill_id = skills.skill_id
					WHERE build_id = :build_id";
				$statement = $db->prepare($query);
				$statement->bindValue(':build_id', $build_id);
				$statement->execute();		
			?>

			<h1><a href="focus.php?build_id=<?=$user['build_id']?>"><?=$user['build_title']?></a></h1>

			<img src="images/<?=$user['character_name']?>.png" alt="<?=$user['character_name']?>">
			<h1><?=$user['character_name']?> / <?=$user['class_name']?></h2>

			<?php if(isset($_SESSION['login']) && isset($_SESSION['username'])):?>
				<?php if($_SESSION['username'] === $user['username']):?>
					<a href="edit.php?build_id=<?=$build_id?>">Edit</a>
				<?php endif ?>
			<?php endif ?>

			<h1>CLASS SKILLS</h1>
			<?php foreach($class as $class):?>
				<h2> <?=$class['skill_name']?> </h2>
				<p> <?=$class['description']?> </p>
			<?php endforeach ?>
			<h1>ASSIGNED SKILLS</h1>
			<?php foreach($statement as $skills):?>
				<h2> <?=$skills['skill_name']?> </h2>
				<p> <?=$skills['description']?> </p>
			<?php endforeach ?>
		<?php endforeach ?>

	<?php endif ?>
</body>
</html>