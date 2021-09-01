<?php  

	//записываем куки с выбором опции для сортировки и роиском нужного продукта по id в переменную
	$cookie_select = $_COOKIE["select_card_views"] ?? null; 

	$unserialize_cookie = unserialize($cookie_select);

	//print_r( $unserialize_cookie);

	//забираем массив переданный через куки для поиска нужного продукта
	$result_poisk_cookie = $unserialize_cookie[0]['result'] ?? null;
	$id_poisk_cookie = $unserialize_cookie[0]['id'] ?? null;
?>

<div class="nav_products">
	<form class="select_card_views" action="assets/php/shop/selected_card_views.php" method="post" >
		<select name="select">
			<!-- если значение сессии = значению тега option то мы пишем атрибут selected -->
			<option <?=($unserialize_cookie == 'new') ? 'selected' : null;?> data="option_select_views_products" value="new">от новых к старым</option>
			<option <?=($unserialize_cookie == 'old') ? 'selected' : null;?> data="option_select_views_products" value="old">от cтарых к новым</option>
			<option <?=($unserialize_cookie == 'views_pop') ? 'selected' : null;?> data="option_select_views_products" value="views_pop" >самые просматриваемые</option>
		</select>
		<input type="submit"  value="Отправить">
	</form>


	<form class="select_card_poisk" action="assets/php/shop/select_card_poisk.php" method="post">
		<div class="poisk_card_products_elem">
			<input name="poisk_card_products" type="text" placeholder="поиск товара по id">
			<input type="submit">
			<span class="error_select_card_poisk"></span>
		</div>
	</form>
</div>








<?php  
	function valid($data) {
		$data = trim($data);             //trim - функция  удаляет пробелы до и после слова но в самом слове пробелы не удаляет
		$data = stripslashes($data);     //stripslashes — Удаляет экранирование символов
		$data = strip_tags($data);   
		$data = htmlspecialchars($data); //htmlspecialchars — Преобразует специальные символы в HTML-сущности
		$data = intval($data);           //приравниевает значение к числу , если будет строка или null то она заменится на ноль
		return $data;
    }
	
	//принимаем номер страницы пагинации
	$st = $_GET['str'] ?? null;
	$st_valid = valid($st); 

	//если переменная st = null то в переменную str запишется 1 если != null то запишется значение $_GET['str']
	$str = (!($st_valid == 0)) ? $st_valid : 1;

	//cколько карточек будет показано на странице
	$limit_elements = 6;

	//с какого места мы будем выводить запись
	$start = ($str * $limit_elements) - $limit_elements;

	require('assets/php/db/link_db.php');
	$id_poisk_cookie_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($id_poisk_cookie)));
	$start_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($start)));
	$limit_elements_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($limit_elements)));

	//делим полученное кол-во элементов в массиве на кол-во карточек которое должно быть показано на странице
	//забираем обьект mysqli_query
	//забираем из обьекта все массивы преобразованные в ассоциативные mysqli_fetch_all
	//считаем сколько всего массивов получилось count
	//делив кол-во продуктов на число которое показывает сколько карточек должно быть на странице
	//округляем это число в большую сторону
	//условие для того чтобы не показывать все 5 страниц пагинации когда мы в режиме поиска одного продукта по id
	if ($result_poisk_cookie == 'poisk') {
		$count_products = ceil(count(mysqli_fetch_all(mysqli_query($products_lesson_6, "SELECT * FROM `products` WHERE `id` IN ('{$id_poisk_cookie_valid_db}')"))) / $limit_elements);
	}else{	
		$count_products = ceil(count(mysqli_fetch_all(mysqli_query($products_lesson_6, "SELECT * FROM `products`"))) / $limit_elements);
	}
	
	//echo "$count_products";

	//по этим обьектам мы будем в цикле foreach показывать продукты в зависимости от выбранного режима сортировки
	$tabl_products_new = mysqli_query($products_lesson_6, "SELECT * FROM `products` ORDER BY `id` DESC LIMIT {$start_valid_db} , {$limit_elements_valid_db}");
	$tabl_products_old = mysqli_query($products_lesson_6, "SELECT * FROM `products` ORDER BY `id` ASC  LIMIT {$start_valid_db} , {$limit_elements_valid_db}");
	$tabl_products_max_views = mysqli_query($products_lesson_6, "SELECT * FROM `products` ORDER BY `views` DESC LIMIT {$start_valid_db} , {$limit_elements_valid_db}");
	$tabl_products_poisk_id = mysqli_query($products_lesson_6, "SELECT * FROM `products` WHERE `id` IN ('{$id_poisk_cookie}')");
	$tabl_products_all = mysqli_query($products_lesson_6, "SELECT * FROM `products` ORDER BY `id` DESC LIMIT {$start_valid_db} , {$limit_elements_valid_db}");

	//функция для пагинации
	function MyPagination($count_products , $str){

		//cоздаем массив прямо в цикле foreach который идет от 1 до $count_products 
		//range — Создаёт массив, содержащий диапазон элементов
		
		//условия для того чтобы цифры пагинации показывались максимум 5 цифр
		if ($count_products < 5) {					
			foreach (range(1, $count_products) as $value) {
				echo "<a class='pagination_link' id='$value' href='index.php?page=shop&str={$value}'>$value</a>";

			}
		}elseif (($count_products > 4)&&($str < 5)) {
			foreach (range(1, 5) as $value) {
				echo "<a class='pagination_link' id='$value' href='index.php?page=shop&str={$value}'>$value</a>";

			}
		}elseif ((($count_products - 5) < 5)&&($str > 5)) {
			foreach (range($count_products - 4, $count_products) as $value) {
				echo "<a class='pagination_link' id='$value' href='index.php?page=shop&str={$value}'>$value</a>";

			}
		}elseif (($count_products > 4)&&(($count_products - 5) < 5)&&($str == 5)) {
			foreach (range($str - 2, $count_products) as $value) {
				echo "<a class='pagination_link' id='$value' href='index.php?page=shop&str={$value}'>$value</a>";

			}
		}elseif (($count_products > 4)&&(($count_products - 5) > 5)&&($str >= 5)&&($str <= ($count_products - 4))) {
			foreach (range($str - 2, $str + 2) as $value) {
				echo "<a class='pagination_link' id='$value' href='index.php?page=shop&str={$value}'>$value</a>";

			}
		}elseif (($count_products > 4)&&(($count_products - 5) > 5)&&($str > ($count_products - 4))) {
			foreach (range($count_products - 4, $count_products) as $value) {
				echo "<a class='pagination_link' id='$value' href='index.php?page=shop&str={$value}'>$value</a>";

			}
		}
	}
	
	
	
	
	mysqli_close($products_lesson_6);



	?>


<!-- показываем продукты от самого нового если селектор в режиме all -->
<?php if ($unserialize_cookie == 'new' ): ?>

<div class="card">

	<div class="card_wrapper">

		<?php  
			foreach ($tabl_products_new as  $items_products): 
		?>
	
		<div class="card_item ">

		  	<div class="card-header">
		    	<h4 class="text"><?= $items_products['brand']; ?></h4>
		  	</div>

		  	<div class="card-body">
		  		
		  		<div class="home_img">
					<img popup="popup_<?=$items_products['id'];?>" class="img PopupLinks" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
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

		  	<button type="button" class="btn"><a class="button_href" href="index.php?page=product&id=<?= $items_products['id']; ?>">Подробнее</a></button>

		</div>

		<!-- для модальных окон -->
		<div class="popup" id="popup_<?=$items_products['id'];?>">
			<div class="popup_content">
				<div class="close_popup">Закрыть</div>
				<img class="img PopupLinks" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
			</div>
		</div>

		<?php  endforeach; ?>

	</div>
</div>

	
	





<!-- показываем продукты от самого старого если селектор в режиме old -->
<?php elseif ($unserialize_cookie == 'old' ): ?>

<div class="card">

	<div class="card_wrapper">

		<?php  
			foreach ($tabl_products_old as  $items_products): 
		?>
	
		<div class="card_item ">

		  	<div class="card-header">
		    	<h4 class="text"><?= $items_products['brand']; ?></h4>
		  	</div>

		  	<div class="card-body">
		  		
		  		<div class="home_img">
					<img popup="popup_<?=$items_products['id'];?>" class="img PopupLinks" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
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

		  	<button type="button" class="btn"><a class="button_href" href="index.php?page=product&id=<?= $items_products['id']; ?>">Подробнее</a></button>

		</div>

		<!-- для модальных окон -->
		<div class="popup" id="popup_<?=$items_products['id'];?>">
			<div class="popup_content">
				<div class="close_popup">Закрыть</div>
				<img class="img PopupLinks" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
			</div>
		</div>

		<?php  endforeach; ?>

	</div>
</div>

	





<!-- показываем продуты от самого просматриваемого  -->
<?php elseif ($unserialize_cookie == 'views_pop' ):   ?>

<div class="card">

	<div class="card_wrapper">

		<?php  
			foreach ($tabl_products_max_views as  $items_products): 
		?>
	
		<div class="card_item ">

		  	<div class="card-header">
		    	<h4 class="text"><?= $items_products['brand']; ?></h4>
		  	</div>

		  	<div class="card-body">
		  		
		  		<div class="home_img">
					<img popup="popup_<?=$items_products['id'];?>" class="img PopupLinks" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
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

		  	<button type="button" class="btn"><a class="button_href" href="index.php?page=product&id=<?= $items_products['id']; ?>">Подробнее</a></button>

		</div>

		<!-- для модальных окон -->
		<div class="popup" id="popup_<?=$items_products['id'];?>">
			<div class="popup_content">
				<div class="close_popup">Закрыть</div>
				<img class="img PopupLinks" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
			</div>
		</div>

		<?php  endforeach; ?>

	</div>
</div>


<!-- показываем продуты по поиску по id -->
<?php elseif ($result_poisk_cookie == 'poisk'):  ?>


<div class="card">

	<div class="card_wrapper">

		<?php  
			foreach ($tabl_products_poisk_id as  $items_products): 
		?>
	
		<div class="card_item ">

		  	<div class="card-header">
		    	<h4 class="text"><?= $items_products['brand']; ?></h4>
		  	</div>

		  	<div class="card-body">
		  		
		  		<div class="home_img">
					<img popup="popup_<?=$items_products['id'];?>" class="img PopupLinks" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
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

		  	<button type="button" class="btn"><a class="button_href" href="index.php?page=product&id=<?= $items_products['id']; ?>">Подробнее</a></button>

		</div>

		<!-- для модальных окон -->
		<div class="popup" id="popup_<?=$items_products['id'];?>">
			<div class="popup_content">
				<div class="close_popup">Закрыть</div>
				<img class="img PopupLinks" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
			</div>
		</div>

		<?php  endforeach; ?>

	</div>
</div>



	




	







<!-- показываем все карточки если селектор не установлен  -->
<?php else: ?>


<div class="card">

	<div class="card_wrapper">

		<?php  			
			foreach ($tabl_products_all as  $items_products): 
		?>


		<div class="card_item ">

		  	<div class="card-header">
		    	<h4 class="text"><?= $items_products['brand']; ?></h4>
		  	</div>

		  	<div class="card-body">
		  		
		  		<div class="home_img">
					<img popup="popup_<?=$items_products['id'];?>" class="img PopupLinks" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
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

		  	<button type="button" class="btn"><a class="button_href" href="index.php?page=product&id=<?= $items_products['id']; ?>">Подробнее</a></button>

		</div>

		<!-- для модальных окон -->
		<div class="popup" id="popup_<?=$items_products['id'];?>">
			<div class="popup_content">
				<div class="close_popup">Закрыть</div>
				<img class="img PopupLinks" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
			</div>
		</div>


		<?php  endforeach; ?>

	</div>
</div>

<?php endif ?>








<!-- для пагинации -->
<div class="pagination">
	<?php if($str >= 5): ?>
	<a class="pagination_link_first"  href="index.php?page=shop&str=1">1</a>
	<span>...</span>
	<?php endif ?>	
	<!-- вызываем функцию которая генерирует кол-во ссылок для пагинации -->
	<?php MyPagination($count_products , $str); ?>
</div>



<!-- для подсветки той ссылки на странице которой мы находимся -->
<script>
	let pagin_link = $('.pagination_link');
	let str = <?= $str ?>;
	if (pagin_link.length > 0) {
		for (let index = 0; pagin_link.length > index; index++ ){
			const Pagin_link = pagin_link[index];
			//console.log(Pagin_link);
			if ($(Pagin_link).attr('id') == str) {
				$(Pagin_link).css('color','red')
			}
		}
	}
</script>


 <!-- СКРИПТ ДЛЯ ОТМЕНЫ АВТОМАТИЧЕСКОГО ПОВТОРНОГО ЗАПОЛНЕНИЯ ФОРМЫ ПОСЛЕ ПЕРЕЗАГРУЗКИ СТРАНИЦЫ-->
<script>
	if ( window.history.replaceState ) {
	window.history.replaceState( null, null, window.location.href );
	}
</script>