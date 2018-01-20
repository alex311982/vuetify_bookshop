<!DOCTYPE html>
<html>
<head>
<title> Добавление жанра. </title>
<meta charset="utf-8">
<link href="style.css" type="text/css" rel="stylesheet">
</head>
	<body>
	<?php include(BASE_PASS . 'views/menu.php'); ?>	
	<h2>Добавляем жанр</h2>
	<form action = 'admin.php?c=genre&a=create' method = 'post'>
            жанр: <input type="text" name = 'genre'><br><br>
            <input type = 'submit' name = 'submit' >
            
	</form>
	</body>
</html>