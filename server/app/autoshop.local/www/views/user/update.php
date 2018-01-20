<!DOCTYPE html>
<html>
<head>
<title> Добавление автора. </title>
<meta charset="utf-8">
<link href="style.css" type="text/css" rel="stylesheet">
</head>
	<body>
	<?php include(BASE_PASS . 'views/menu.php'); ?>
	<form action='admin.php?c=user&a=update' method='post'>
            Скидка пользователя <?=$user->login?><br><br>
            <input type='hidden' name='hidden' value='<?=$user->id?>'>
        <br><br>
        <select name="discount" >
            <option value="0">нет скидки</option>
            <?foreach($discounts as $k => $v){?>
                <option value="<?=$v["discount_id"]?>" <?=($v["discount_id"] == $user->discount) ? "selected" : ""?>><?=$v["discount_name"]?></option>
            <?}?>
        </select>
            <br><br>
        <input type='submit' name='submit1' >
	</form>
	</body>
</html>