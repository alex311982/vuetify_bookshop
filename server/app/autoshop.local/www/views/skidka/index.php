<!DOCTYPE html>
<html>
<head>
    <title> Добавление скидки. </title>
    <meta charset="utf-8">
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>
<?php include(BASE_PASS . 'views/menu.php'); ?>
<a href='admin.php?c=skidka&a=create'>создать</a><br><br>

<?php foreach ($discount as $value) { ?>
    <table>
    <th>
    <td><?=$value['discount_name']?></td>
    <td><?=$value['discount_tax']?></td>
    <td><?=($value['discount_type'] ==1) ? "на товар" :'для клиента'?></td>
    <td><a href='admin.php?c=skidka&a=update&discount_id=<?=$value['discount_id']?>'>изменить</a></td>
    <td><a href='admin.php?c=skidka&a=delete&discount_id=<?=$value['discount_id']?>'>Удалить</a></td>
    </th>
    </table>
<?php }?>


</body>
</html>
