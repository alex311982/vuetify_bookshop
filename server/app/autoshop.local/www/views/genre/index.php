<!DOCTYPE html>
<html>
<head>
<title> Добавление автора. </title>
<meta charset="utf-8">
<link href="style.css" type="text/css" rel="stylesheet">
</head>
	<body>
            <?php include(BASE_PASS . 'views/menu.php'); ?>
<a href='admin.php?c=genre&a=create'>создать</a><br><br>
<?php
foreach ($genre as $value) {
    echo $value['genre_name']."&nbsp;<a href='admin.php?c=genre&a=update&genre_id="
            .$value['genre_id']."'>изменить</a>&nbsp;"
            . "&nbsp;<a href='admin.php?c=genre&a=delete&genre_id="
            .$value['genre_id']."'>Удалить</a><br>";
}
?>
	</body>
</html>
