<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styles.css">
	<title>FE: CHARACTER BUILDER</title>
</head>
<body>
	<?php
		include 'header.php';
		require 'connect.php';

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

		<?php
			$username = $_SESSION['username'];

			$query = "SELECT * FROM users WHERE username = :username";
			$statement = $db->prepare($query); 
			$statement->bindValue(':username', $username);
			$statement->execute(); 
			$results = $statement->fetch();
		?>

		<?php if($_POST['edit'] == 'character'):
			$build_id = filter_input(INPUT_GET, 'build_id', FILTER_SANITIZE_NUMBER_INT);
		?>

			<form action="server.php?user=<?=$build_id?>" method="POST">
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
			<button type="submit" name="command" value="edit_character">Submit</button>
			<input type="hidden" id="build_id" name="build_id" value="<?=$build_id?>">
			</form>

		<?php else:?>

			<form action="server.php?user=<?=$results['id']?>" method="POST">
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

		<?php endif ?>

	<?php endif; ?>
</body>
</html>