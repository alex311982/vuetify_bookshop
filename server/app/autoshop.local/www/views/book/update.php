<!DOCTYPE html>
<html>
<head>
<title> Редоктировать книгу. </title>
<meta charset="utf-8">
<link href="style.css" type="text/css" rel="stylesheet">
</head>
	<body>
	<?php include(BASE_PASS . 'views/menu.php'); ?>	
    <h2>Редоктировать книгу</h2>
	<form action = 'admin.php?c=book&a=update' method = 'post'>
    <h3>выбор жанра</h3>
            <select name="genre[]" multiple="" style="height: 150px; width: 125px;">
                <?php foreach ($genres as $key => $value) {?>
                <option value="<?php echo $value["genre_id"];?>" <?=(in_array($value["genre_id"], $books["book_genre"])) ? "selected" : ""?>><?php echo $value["genre_name"];?></option>
                <?php } ?>
            </select><br><br>
    <h3>выбор автора</h3> 
            <select name="author[]" multiple="" style="height: 150px; width: 125px;">
                <?php foreach ($authors as $key => $value) {?>
                <option value="<?php echo $value["author_id"];?>" <?=(in_array($value["author_id"], $books["book_author"])) ? "selected" : ""?>><?php echo $value["author_name"];?></option>
                <?php } ?>
            </select><br><br>
    книга: <input type="text" name = 'book' value ='<?=$books["book_name"]?>'><br><br>
    описание: <input type="text" name = 'book_description' value ='<?=$books["book_description"]?>'><br><br>
    цена: <input type="text" name = 'book_price' value ='<?=$books["book_price"]?>'><br><br>
    скидка: <select name="discount">
        <option value="0" >нет</option>
        <?php
        foreach ($discount as $value){ ?>
            <option <?=$value["discount_id"] == $books["book_discount_id"] ? "selected" : ""?>
                    value="<?=$value['discount_id']?>" ><?=$value['discount_name'].' %'.$value['discount_tax'];?></option>
        <?php } ?>
    </select><br><br>
            <input type = 'hidden' name = 'hidden' value='<?=$books["book_id"]?>'>
            <input type = 'submit' name = 'submit' >
            
	</form>
	</body>
</html>