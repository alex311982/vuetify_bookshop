<!DOCTYPE html>
<html>
<head>
<title> Добавление автора. </title>
<meta charset="utf-8">
<link href="style.css" type="text/css" rel="stylesheet">
</head>
	<body>
	<?php include(BASE_PASS . 'views/menu.php'); ?>	
	<h2>Редоктировать автора</h2>
	<form action='admin.php?c=author&a=update' method='post'>
            редоктировать:
            <input type="text" name='author' value='<?=$author["author_name"]?>'> <br><br>
            <input type='hidden' name='hidden' value='<?=$author["author_id"]?>'>
            <input type='submit' name='submit1' >
            
	</form>
	</body>
</html>