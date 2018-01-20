<!DOCTYPE html>
<html>
<head>
<title> Добавление книги. </title>
<meta charset="utf-8">
<link href="style.css" type="text/css" rel="stylesheet">
</head>
    <body>
        <?php include(BASE_PASS . 'views/menu.php'); ?>
        <a href="admin.php?c=book&a=create"> добавить </a><br><br>

        <?php foreach ($book as $value) { ?>

            <table>
            <th>
            <td> <?=$value['book_genre']?></td>
            <td> <?=$value['book_author']?></td>
            <td> <?=$value['book_name']?></td>
            <td> <?=$value['book_description']?></td>
            <td> price <?=$value['book_price']?></td>
            <td> sale = <?=$value['book_discount']?></td>
            <td><a href=" admin.php?c=book&a=update&book_id=<?=$value["book_id"] ?>"> изменить </a></td>
            <td><a href="admin.php?c=book&a=delete&book_id=<?=$value["book_id"] ?>"> удалить </a></td>
            </th>
            </table>
        <?php }?>


    </body>
</html>
