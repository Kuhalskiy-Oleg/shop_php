
<form action="index.php?page=shop" method="post">
	<select name="select">
		<option value="all" selected >все картинки</option>
		<option value="views_pop" >самая просматриваемая</option>
	</select>
	<input type="submit"  value="Отправить">
</form>


<!-- показываем все картинки если селектор в режиме all -->
<?php  $select = $_POST['select'] ?? null; if ($select == 'all' ): ?>
	
<div class="card">

	<div class="card_wrapper">

		<?php  
			require('assets/php/db/link_db.php');
			$tabl_products = mysqli_query($products_lesson_6, "SELECT * FROM `products` ");
			mysqli_close($products_lesson_6);
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

		  		<form class="form_card_body_add_order" method="post" action="assets/php/shop/add_korzina.php">
		  			<input type="hiden"  name="product_ID" class="product_id" value="<?= $items_products['id']; ?>">
		  			<input type="submit" value="добавить в коризну" id="input_submit_add_elem_in_korzina">
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
			require('assets/php/db/link_db.php');
			$tabl_images = mysqli_query($products_lesson_6, "SELECT * FROM `products` ORDER BY `views` DESC ");
			mysqli_close($products_lesson_6);
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

		  		<form class="form_card_body_add_order" method="post" action="assets/php/shop/add_korzina.php">
		  			<input type="hiden"  name="product_ID" class="product_id" value="<?= $items_products['id']; ?>">
		  			<input type="submit" value="добавить в коризну" id="input_submit_add_elem_in_korzina">
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
			require('assets/php/db/link_db.php');
			$tabl_products = mysqli_query($products_lesson_6, "SELECT * FROM `products` ");
			mysqli_close($products_lesson_6);
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

		  		<form class="form_card_body_add_order" method="post" action="assets/php/shop/add_korzina.php">
		  			<input type="hiden"  name="product_ID" class="product_id" value="<?= $items_products['id']; ?>">
		  			<input type="submit" value="добавить в коризну" id="input_submit_add_elem_in_korzina">
		  		</form>
		  		
		  	</div>

		  	<button type="button" class="btn"><a class="button_href" href="index.php?page=product&id=<?= $items_products['id']; ?>">more detailed</a></button>

		</div>



		<?php  endforeach; ?>

	</div>
</div>

<?php endif ?>















 <!-- СКРИПТ ДЛЯ ОТМЕНЫ АВТОМАТИЧЕСКОГО ПОВТОРНОГО ЗАПОЛНЕНИЯ ФОРМЫ ПОСЛЕ ПЕРЕЗАГРУЗКИ СТРАНИЦЫ-->
<script>
	if ( window.history.replaceState ) {
	window.history.replaceState( null, null, window.location.href );
	}
</script>