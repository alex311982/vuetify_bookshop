<!DOCTYPE html>
<html>
<head>
    <title> Добавление скидку. </title>
    <meta charset="utf-8">
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>
<?php include(BASE_PASS . 'views/menu.php'); ?>
<h2>Редоктировать скидку</h2>
<form action = 'admin.php?c=skidka&a=update' method = 'post'>
    редоктировать:<br><br>
    название скидки: <input type="text" name = 'name' value="<?=$discount["discount_name"]?>"> <br><br>
    скидка: <input type="text" name = 'tax' value="<?=$discount["discount_tax"]?>"> <br><br>
    тип скидки:
    <select name="type">
        <option value="1" <?=($discount["discount_type"] == 1) ? "selected" : "" ?>>на товар</option>
        <option value="2" <?=($discount["discount_type"] == 2) ? "selected" : "" ?>>для клиента</option>
    </select>
    <br><br>
    <input type = 'hidden' name = 'hidden' value = '<?=$discount["discount_id"]?>'>
    <input type = 'submit' name = 'submit' >

</form>
</body>
</html>