<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<title>FE: CHARACTER BUILDER</title>
</head>
    <body>
        <?php
            include 'header.php';

            $query = "SELECT * FROM skills WHERE type = 2";
            $two = $db->prepare($query); 
            $two->execute(); 

            $query = "SELECT * FROM skills WHERE type = 3";
            $three = $db->prepare($query); 
            $three->execute(); 

            $query = "SELECT * FROM skills WHERE type = 4";
            $four = $db->prepare($query); 
            $four->execute(); 

            $query = "SELECT * FROM skills WHERE type = 5";
            $five = $db->prepare($query); 
            $five->execute(); 
        ?>

        <?php if(isset($_POST['edit'])):?>

            <form action="server.php" method="POST">

                <h2>Standard Skills</h2>

                <?php foreach($two as $two):?>
                    <input type="checkbox" name="skill[]" value="<?=$two['skill_id']?>">
                    <label for="skill[]"><?=$two['skill_name']?></label>
                <?php endforeach; ?>

                <h2>Master Skills</h2>

                <?php foreach($three as $three):?>
                    <input type="checkbox" name="skill[]" value="<?=$three['skill_id']?>">
                    <label for="skill[]"><?=$three['skill_name']?></label>
                <?php endforeach; ?>

                <h2>Budding Skills</h2>

                <?php foreach($four as $four):?>
                    <input type="checkbox" name="skill[]" value="<?=$four['skill_id']?>">
                    <label for="skill[]"><?=$four['skill_name']?></label>
                <?php endforeach; ?>

                <h2>Other Skills</h2>
                
                <?php foreach($five as $five):?>
                    <input type="checkbox" name="skill[]" value="<?=$four['skill_id']?>">
                    <label for="skill"><?=$four['skill_name']?></label>
                <?php endforeach; ?>

                <?php
                    $build_id = filter_input(INPUT_GET, 'build_id', FILTER_SANITIZE_NUMBER_INT);
                ?>
                    <input type="hidden" id="build_id" name="build_id" value="<?=$build_id?>">
                    <button type="submit" name="command" value="edit_skills">Submit</button>

            </form>

        <?php else :?>
            <form action="server.php" method="POST">

            <h2>Standard Skills</h2>
            <?php foreach($two as $two):?>
                <input type="checkbox" name="skill[]" value="<?=$two['skill_id']?>">
                <label for="skill[]"><?=$two['skill_name']?></label>
            <?php endforeach; ?>

            <h2>Master Skills</h2>
            <?php foreach($three as $three):?>
                <input type="checkbox" name="skill[]" value="<?=$three['skill_id']?>">
                <label for="skill[]"><?=$three['skill_name']?></label>
            <?php endforeach; ?>

            <h2>Budding Skills</h2>
            <?php foreach($four as $four):?>
                <input type="checkbox" name="skill[]" value="<?=$four['skill_id']?>">
                <label for="skill[]"><?=$four['skill_name']?></label>
            <?php endforeach; ?>

            <h2>Other Skills</h2>
            <?php foreach($five as $five):?>
                <input type="checkbox" name="skill[]" value="<?=$four['skill_id']?>">
                <label for="skill"><?=$four['skill_name']?></label>
            <?php endforeach; ?>

            <?php
                $build_id = filter_input(INPUT_GET, 'build_id', FILTER_SANITIZE_NUMBER_INT);
            ?>

            <input type="hidden" id="build_id" name="build_id" value="<?=$build_id?>">

            <button type="submit" name="command" value="skills">Submit</button>
            </form>
        <?php endif ?>

    </body>
</html>