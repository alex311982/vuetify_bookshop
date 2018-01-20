<!DOCTYPE html>
<html>
<head>
<title> Добавление автора. </title>
<meta charset="utf-8">
<link href="style.css" type="text/css" rel="stylesheet">
</head>
	<body>
<?php include(BASE_PASS . 'views/menu.php'); ?>
<a href='admin.php?c=author&a=create'>создать</a><br><br>
<?php
foreach ($author as $value) {
    echo $value['author_name']."&nbsp;<a href='admin.php?c=author&a=update&author_id="
            .$value['author_id']."'>изменить</a>&nbsp;"
            . "&nbsp;<a href='admin.php?c=author&a=delete&author_id="
            .$value['author_id']."'>Удалить</a><br>";
}
?>
	</body>
</html>
