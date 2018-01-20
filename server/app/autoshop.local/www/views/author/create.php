<!DOCTYPE html>
<html>
<head>
<title> Добавление автора. </title>
<meta charset="utf-8">
<link href="style.css" type="text/css" rel="stylesheet">
</head>
	<body>
	<?php include(BASE_PASS . 'views/menu.php'); ?>	
	<h2>Добавляем автора</h2>
	<form action = 'admin.php?c=author&a=create' method = 'post'>
            автор: <input type="text" name = 'author'> <br><br>
            <input type = 'submit' name = 'submit' >
            
	</form>
	</body>
</html>
