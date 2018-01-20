<!DOCTYPE html>
<html>
<head>
    <title> Добавление скидки. </title>
    <meta charset="utf-8">
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>
<?php include(BASE_PASS . 'views/menu.php'); ?>
<h2>Добавляем скидку</h2>
<form action = 'admin.php?c=skidka&a=create' method = 'post'>
    название скидки: <input type="text" name = 'name'> <br><br>
    скидка: <input type="text" name = 'tax'> <br><br>
    тип скидки:
    <select name="type">
        <option value="1">на товар</option>
        <option value="2">для клиента</option>
    </select>
    <br><br>
    <input type = 'submit' name = 'submit' >

</form>
</body>
</html>
