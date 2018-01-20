
<html>
<body>
	<h3>Каталог книг</h3>
    <form action="#" method="post">
    <h3>выбор жанра</h3>    
        <select name="genres">
            <option value="">select genre</option>
            <?php foreach ($genre as $key => $value) { ?>
            <option  <?php if($post_genre === $value['genre_id']):?> selected="selected"<?php endif ?> value="<?=$value['genre_id'];?>">
            <?=$value['genre_name'];?> </option>
            <?php }?>
        </select>
    <h3>выбор автора</h3> 
        <select name="authors">
            <option value="">select author</option>
            <?php foreach ($author as $key => $value) { ?>
            <option <?php if($post_author === $value['author_id']):?>selected="selected"<?php endif ?> value="<?=$value['author_id'];?>">
            <?=$value['author_name'];?> </option> 
            <?php }?>
        </select><br><br>
    <input type = 'submit' name = 'submit' >
    </form>
    <h3>список книг:</h3>
        <?php
        foreach ($book as $key => $value) {
                if(is_array($value)){
        ?>
    <a href="index.php?c=index&a=view&id=<?=$value['book_id'];?>" ><?=$value['book_name'];?> </a><br>
        <?php }else{
            echo '<a href="index.php?c=index&a=view&id=$value->book_id" >'.$value->book_name.'</a><br>';

            }
        }
        ?> 
 
	
</body>
</html>