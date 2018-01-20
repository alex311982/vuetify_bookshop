<!DOCTYPE html>
<html>
<head>
<title> Добавление книги. </title>
<meta charset="utf-8">
<link href="style.css" type="text/css" rel="stylesheet">
</head>
	<body>
	<?php include(BASE_PASS . 'views/menu.php'); ?>	
	<h2>Добавляем книгу</h2>
	<form action = '' method = 'post'>
<h3>выбор жанра</h3><select name="genre[]" multiple="" style="height: 150px;">
                <?php foreach ($genres as $key => $value) {?>
                <option value="<?php echo $value["genre_id"];?>"><?php echo $value["genre_name"];?></option>
                <?php } ?>
            </select><br><br>
<h3>выбор автора</h3> <select name="author[]" multiple="" style="height: 150px;">
                <?php foreach ($authors as $key => $value) {?>
                <option value="<?php echo $value["author_id"];?>"><?php echo $value["author_name"];?></option>
                <?php } ?>
            </select><br><br>
            книга: <input type="text" name = 'name_book'><br><br>
            описание: <textarea name = 'description_book'></textarea><br><br>
            цена: <input type="text" name = 'price_book'><br><br>
            скидка: <select name="discount">
            <option value="0" >нет</option>
            <?php
            foreach ($discount as $value){ ?>
                <option value="<?=$value['discount_id']?>" ><?=$value['discount_name'].' '.$value['discount_tax'];?></option>
            <?php } ?>
        </select><br><br>
            <input type = 'submit' name = 'submit' >
            
	</form>
	</body>
</html>