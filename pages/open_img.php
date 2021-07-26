

<?php  foreach ($open_img as  $item_img): ?>



<!-- 3. * На странице просмотра отдельной фотографии полного размера под картинкой должно быть указано число её просмотров. -->
<?php  
	//подключаемся к бд
	require('assets/php/db/link_db.php');

	//прибавляем к просмотрам плюс 1
	mysqli_query($products_lesson_6,"UPDATE `products` SET `views` = `views` + 1 WHERE `id` IN ({$item_img['id']}) ");

	mysqli_close($products_lesson_6);

?>


<!--2. просмотр конкретной фотографии (изображение оригинального размера) по её ID в базе данных. Отдельная PHP страница  -->
<img style="width: 100%;" src="assets/images/<?= $item_img['name_img'] ?>" alt="">
<?php endforeach ?>
