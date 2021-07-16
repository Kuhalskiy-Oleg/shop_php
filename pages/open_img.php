

<?php  foreach ($open_img as  $item_img): ?>



<!-- 3. * На странице просмотра отдельной фотографии полного размера под картинкой должно быть указано число её просмотров. -->
<?php  
	//подключаемся к бд
	$db_lesson_6_php = mysqli_connect("127.0.0.1", "root", "root", "products_lesson_6" , 3307);

	//прибавляем к просмотрам плюс 1
	mysqli_query($db_lesson_6_php,"UPDATE `products` SET `views` = `views` + 1 WHERE `id` IN ({$item_img['id']}) ");

	mysqli_close($db_lesson_6_php);

?>


<!--2. просмотр конкретной фотографии (изображение оригинального размера) по её ID в базе данных. Отдельная PHP страница  -->
<img style="width: 100%;" src="assets/images/<?= $item_img['name_img'] ?>" alt="">
<?php endforeach ?>
