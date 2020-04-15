<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<title>FE: CHARACTER BUILDER</title>
</head>
<body>

    <?php
        include 'header.php';

        $query = "SELECT * FROM skills WHERE skill_id > 1000 AND skill_id < 2000";
        $class = $db->prepare($query); 
        $class->execute(); 
    ?>

    <div id="characters">
        <h2>Class Skills</h2>
            <ul>
                <?php foreach($class as $class): ?>
                    <li><?=$class['skill_name']?> : <?=$class['description']?></li>
                <?php endforeach ?>
            </ul>
    </div>

</body>
</html>