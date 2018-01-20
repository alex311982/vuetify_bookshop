<?php 
ini_set('display_errors', 'On');
error_reporting(E_ALL);?>
<!DOCTYPE html>
<html>
<head>
<title> Редоктировать жанр. </title>
<meta charset="utf-8">
<link href="style.css" type="text/css" rel="stylesheet">
</head>
	<body>
	<?php include(BASE_PASS . 'views/menu.php'); ?>	
	<h2>Редоктировать жанр</h2>
	<form action = 'admin.php?c=genre&a=update' method = 'post'>
            жанр: <input type="text" name = "genre" value = '<?=$genre["genre_name"]?>'><br><br>
            <input type = 'hidden' name="hidden" value='<?=$genre["genre_id"]?>'>
            <input type = 'submit' name = 'submit1' value="редактировать" >
            
	</form>
	</body>
</html>