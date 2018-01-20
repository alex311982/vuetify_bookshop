<!DOCTYPE html>
<html>
<head>
<title> Пользователи. </title>
<meta charset="utf-8">
<link href="style.css" type="text/css" rel="stylesheet">
</head>
	<body>
<?php include(BASE_PASS . 'views/menu.php'); ?>

<?php
foreach ($users as $value) {
    echo $value['login']."&nbsp;<a href='admin.php?c=user&a=update&user_id="
            .$value['id']."'>изменить</a><br>";
}
?>
	</body>
</html>
