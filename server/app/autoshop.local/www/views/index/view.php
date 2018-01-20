<html>
    <head>
        
        <link href="style.css" rel="stylesheet">
        
    </head>
    <body>
       НАЗВАНИЕ КНИГИ :<?=$book['name'];?> <br>
       АВТОРА :<?php
        $count = 0;
       foreach ($author as $value) {
           
           if($count>0){
               echo ',';
           }
           $count++;
           echo $value;
       }
       ?> <br>
       ЖАНР :<?php

       $count = 0;
       foreach ($genre as $value) {
           
           if($count>0){
               echo ',';
             
           }
           $count++;
           echo $value;
       }
       ?> <br>
       ОПЕСАНИЕ :<?=$book['description'];?> <br>
       ЦЕНА :<?=$book['price'];?> <br>
       <?php if ($book['discountCost'] !=0){?>
       СКИДКА :<?=$book['discountCost'];?> <br>
       ЦЕНА СО СКИДКОЙ :<?=$book['price']-$book['discountCost'];?> <br><br>
       <?php } ?>
 <h3>Оформить заказ :</h3><br/>
	<form action="index.php?c=index&a=order&id=<?=$id?>" method="post">
            
            <?php
        foreach ($form as $k => $v) {
                echo '<label for = "'. $k .'"> Введите '. $v['lable'] .'</label> '
                . '<input type = "'. $v['type'] .'" name = "'. $k .'" id = "'. $k .'" value = "'. $v['value'].'">';
                if($form[$k]['error']){
                    echo '<span class="err">'.$form[$k]['errorText'].'</span>';
                }
                echo '<br><br>';
        }
            
            ?>
		<br><br>
		<input type="hidden" name="book_id" value="<?=$book['id'];?>">
                <input type="submit" name="submit" value="заказать"><br>   
	</form>      
        
