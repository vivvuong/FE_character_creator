<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<title>FE: CHARACTER BUILDER</title>
</head>
<body>
	<?php
		include 'header.php';

		$query = "SELECT * FROM characters";
		$character = $db->prepare($query); 
		$character->execute(); 

		$query = "SELECT * FROM classes";
		$classes = $db->prepare($query);
		$classes->execute();

		$query = "SELECT * FROM skills WHERE type != 1";
		$skill = $db->prepare($query); 
		$skill->execute(); 
	?>
		
	<?php if(!isset($_SESSION['login'])):?>
		<?php header('location: index.php'); ?>
	<?php else:?>
	<!-- CODE INSIDE HERE -->

		<?php
			$username = $_SESSION['username'];
	
			$query = "SELECT * FROM users WHERE username = :username";
			$statement = $db->prepare($query); 
			$statement->bindValue(':username', $username);
			$statement->execute(); 
			$results = $statement->fetch();
		?>

		<form action="server.php?user=<?=$results['id']?>" method="POST">

			<label for="fname">Build Name:</label>
			<input type="text" id="title" name="title">

			<label for="character">Choose a character:</label>
			<select name="character">
				<?php foreach($character as $character):?>
					<option value="<?=$character['character_id']?>"><?=$character['character_name']?></option>
				<?php endforeach ?>
			</select>

			<label for="class">Choose a class:</label>
			<select name="class">
				<?php foreach($classes as $classes):?>
					<option value="<?=$classes['class_id']?>"><?=$classes['class_name']?></option>
				<?php endforeach ?>
			</select>

			<button type="submit" name="command" value="create">Submit</button>
		</form>

		<?php if(isset($_POST['command'])):?>
			<?php 
				$character  = filter_input(INPUT_POST, 'character', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				$class  = filter_input(INPUT_POST, 'class', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

				$query = "SELECT * FROM class_skills 
					JOIN classes ON class_skills.class_id = classes.class_id
					JOIN skills ON class_skills.class_skill = skills.skill_id
					WHERE classes.class_name = :class";
				$statement = $db->prepare($query); 
				$statement->bindValue(':class', $class);
				$statement->execute(); 
			?>
			<img src="images/<?=$character?>.png" alt="<?=$character?>">
			<h2><?=$class?></h2>
			<?php foreach($statement as $statement):?>
				<h3><?=$statement['skill_name']?></h3>
				<p><?=$statement['description']?><p>
			<?php endforeach ?>
		<?php endif ?>	

	<!-- CODE INSIDE HERE -->
	<?php endif; ?>
		
</body>
</html>