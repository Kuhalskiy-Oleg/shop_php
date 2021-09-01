<?php  
	
	//подключаемся к бд
	require('assets/php/db/link_db.php');

	//прибавляем к просмотрам плюс 1
	mysqli_query($products_lesson_6,"UPDATE `products` SET `views` = `views` + 1 WHERE `id` IN ({$open_product[0]['id']}) ");

	mysqli_close($products_lesson_6);


?>



<?php foreach ($open_product as $value):?>

<section class="content">
	<div class="contetn_img">
		<img  src="assets/images/<?= $value['name_img']; ?>" alt="">
	</div>
	<div class="content_description">
		<h1 class="name_telephone"><?= $value['brand']; ?></h1>
		<span class="description_telephone"><?= $value['description']; ?></span>
		<span class="color_telephone">Model: <?= $value['model']; ?></span>
		<span class="color_telephone">Color: <?= $value['color']; ?></span>
		<span class="price_telephone">Price: <?= $value['price']; ?></span>
	</div>
</section>


<?php endforeach ?>







