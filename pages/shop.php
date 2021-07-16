<?php session_start();  ?>


<!-- 4. * На странице просмотра галереи список фотографий должен быть отсортирован по популярности. Популярность - число просмотров фотографии. -->
<form action="index.php?page=shop" method="post">
	<select name="select">
		<option value="all" selected >все картинки</option>
		<option value="views_pop" >самая просматриваемая</option>
	</select>
	<input type="submit"  value="Отправить">
</form>


<!-- показываем все картинки если селектор в режиме all -->
<?php  $select = $_POST['select']; if ($select == 'all' ): ?>
	
<div class="card">

	<div class="card_wrapper">

		<?php  
			$db_lesson_6_php = mysqli_connect("127.0.0.1", "root", "root", "products_lesson_6" , 3307) or die ("НЕ УДАЛОСЬ ПОДКЛЮЧИТСЯ К БАЗЕ ДАННЫХ");
			$tabl_products = mysqli_query($db_lesson_6_php, "SELECT * FROM `products` ");
			mysqli_close($db_lesson_6_php);
			foreach ($tabl_products as  $items_products): 
		?>
	
		<div class="card_item ">

		  	<div class="card-header">
		    	<h4 class="text"><?= $items_products['brand']; ?></h4>
		  	</div>

		  	<div class="card-body">
		  		
		  		<div class="home_img">
		      		<a href="index.php?page=img&id=<?=  $items_products['id'] ?>" target="_blank">
						<img class="img" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
					</a>
		  		</div>

		  		<div class="description">
		  			<span class="description_span"><?= $items_products['description']; ?></span>
		  		</div>

		  		<div class="Model">
		  			<span>Model:<?= $items_products['model']; ?></span>
		  		</div>

		  		<div class="color">
		  			<span>Color:<?= $items_products['color']; ?></span>
		  		</div>

		  		<div class="price">
		  			<span>Price:<?= $items_products['price']; ?></span>
		  		</div>

		  		<form class="form_card_body_add_order" method="post" action="index.php?page=shop">
		  			<input type="hiden" name="product_id" class="product_id" value="<?= $items_products['id']; ?>">
		  			<input type="submit" value="добавить в коризну">
		  		</form>
		  		
		  	</div>

		  	<button type="button" class="btn"><a class="button_href" href="index.php?page=product&id=<?= $items_products['id']; ?>">more detailed</a></button>

		</div>

		<?php  endforeach; ?>

	</div>
</div>

	
	





<!-- показываем  картинки от самой просматриваемой  -->
<?php elseif ($select == 'views_pop' ):   ?>

<div class="card">

	<div class="card_wrapper">

		<?php  
			$db_lesson_6_php = mysqli_connect("127.0.0.1", "root", "root", "products_lesson_6" , 3307) or die ("НЕ УДАЛОСЬ ПОДКЛЮЧИТСЯ К БАЗЕ ДАННЫХ");
			$tabl_images = mysqli_query($db_lesson_6_php, "SELECT * FROM `products` ORDER BY `views` DESC ");
			mysqli_close($db_lesson_6_php);
			foreach ($tabl_images as  $items_products): 
		?>
	
		<div class="card_item ">

		  	<div class="card-header">
		    	<h4 class="text"><?= $items_products['brand']; ?></h4>
		  	</div>

		  	<div class="card-body">
		  		
		  		<div class="home_img">
		      		<a href="index.php?page=img&id=<?=  $items_products['id'] ?>" target="_blank">
						<img class="img" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
					</a>
		  		</div>

		  		<div class="description">
		  			<span class="description_span"><?= $items_products['description']; ?></span>
		  		</div>

		  		<div class="Model">
		  			<span>Model:<?= $items_products['model']; ?></span>
		  		</div>

		  		<div class="color">
		  			<span>Color:<?= $items_products['color']; ?></span>
		  		</div>

		  		<div class="price">
		  			<span>Price:<?= $items_products['price']; ?></span>
		  		</div>

		  		<form class="form_card_body_add_order" method="post" action="index.php?page=shop">
		  			<input type="hiden" name="product_id" class="product_id" value="<?= $items_products['id']; ?>">
		  			<input type="submit" value="добавить в коризну">
		  		</form>
		  		
		  	</div>

		  	<button type="button" class="btn"><a class="button_href" href="index.php?page=product&id=<?= $items_products['id']; ?>">more detailed</a></button>

		</div>

		<?php  endforeach; ?>

	</div>
</div>




	







<!-- показываем все карточки если селектор не установлен  -->
<?php else: ?>


<div class="card">

	<div class="card_wrapper">

		<?php  
			$db_lesson_6_php = mysqli_connect("127.0.0.1", "root", "root", "products_lesson_6" , 3307) or die ("НЕ УДАЛОСЬ ПОДКЛЮЧИТСЯ К БАЗЕ ДАННЫХ");
			$tabl_products = mysqli_query($db_lesson_6_php, "SELECT * FROM `products` ");
			mysqli_close($db_lesson_6_php);
			foreach ($tabl_products as  $items_products): 
		?>


		<div class="card_item ">

		  	<div class="card-header">
		    	<h4 class="text"><?= $items_products['brand']; ?></h4>
		  	</div>

		  	<div class="card-body">
		  		
		  		<div class="home_img">
		      		<a href="index.php?page=img&id=<?=  $items_products['id'] ?>" target="_blank">
						<img class="img" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
					</a>
		  		</div>

		  		<div class="description">
		  			<span class="description_span"><?= $items_products['description']; ?></span>
		  		</div>

		  		<div class="Model">
		  			<span>Model:<?= $items_products['model']; ?></span>
		  		</div>

		  		<div class="color">
		  			<span>Color:<?= $items_products['color']; ?></span>
		  		</div>

		  		<div class="price">
		  			<span>Price:<?= $items_products['price']; ?></span>
		  		</div>

		  		<form class="form_card_body_add_order" method="post" action="index.php?page=shop">
		  			<input type="hiden" name="product_id" class="product_id" value="<?= $items_products['id']; ?>">
		  			<input type="submit" value="добавить в коризну">
		  		</form>
		  		
		  	</div>

		  	<button type="button" class="btn"><a class="button_href" href="index.php?page=product&id=<?= $items_products['id']; ?>">more detailed</a></button>

		</div>



		<?php  endforeach; ?>

	</div>
</div>

<?php endif ?>



<?php  
	//инициализируем сессию product_id и наполняем ее id товаров
	if ($_POST['product_id'] != '') {
		$_SESSION['product_id']  .= $_POST['product_id'].';';
	}

	
?>













 <!-- СКРИПТ ДЛЯ ОТМЕНЫ АВТОМАТИЧЕСКОГО ПОВТОРНОГО ЗАПОЛНЕНИЯ ФОРМЫ ПОСЛЕ ПЕРЕЗАГРУЗКИ СТРАНИЦЫ-->
<script>
	if ( window.history.replaceState ) {
	window.history.replaceState( null, null, window.location.href );
	}
</script>