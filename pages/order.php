<?php 
	session_start(); 
?>





<?php 
	//ЕСЛИ КНОПКА --УДАЛИТЬ ЭЛЕМЕНТ ИЗ КОРЗИНЫ-- НАЖАТА
	$del = $_GET['del'];
	if (isset($del)) {
		
		$elem_array = $del;

		if ($elem_array != 'no') {
			$_SESSION['product_id'] = mb_eregi_replace("$elem_array;", '', $_SESSION['product_id']);          
		}	
	}

?>







<h1>Order</h1>

<h2>Список товаров в корзине:</h2>

<?php  
	

	
	
		//записываем результат сеессии в product_id_S и делаем из строки массив с разбиением чисел по :
		$product_id_S = $_SESSION['product_id'];
		$product_id_S_array = explode(";", $product_id_S);



		//подключаемся к products_lesson_6
		$products_lesson_6 = mysqli_connect("127.0.0.1", "root", "root", "products_lesson_6", 3307 ) or die ("НЕ УДАЛОСЬ ПОДКЛЮЧИТСЯ К БАЗЕ ДАННЫХ");

		$row = [];
		$tabl_products = [];

		//наполняем массив данными по тем карточкам которые есть в сессии
		foreach ($product_id_S_array as $key => $value) {
			$tabl_products[] =  mysqli_query($products_lesson_6, "SELECT * FROM `products` WHERE `id` = '{$value}'  ");
			$row[] = mysqli_fetch_assoc($tabl_products[$key]);	
		}

		//удаляем пустой последний элемент в массиве
		array_pop($row);

		
		//удаляем дубликаты карточек из массива
		$row = array_unique($row,SORT_REGULAR);

		//print_r($row );

		

		//$session_id = session_id();
		//echo json_encode(['ss' => $session_id]);



		mysqli_close($products_lesson_6);

		//unset($_SESSION['product_id']);
		
 

?>






<?php if (!empty($row)): ?>

	<form class="form_card_body_add_order" action="assets/php/order/add_items_order.php" method="post">
	<?php foreach ($row as $key => $items_products):  ?> 
	<?php $i += 1;  ?>

	<span>Товар номер <?=$i?>)</span>
	<ul>
		<li>id продукта <?=$items_products['id']?></li>
		<li>бренд <?=$items_products['brand']?></li>
		<li>модель <?=$items_products['model']?></li>
		<li>цвет <?=$items_products['color']?></li>
		<li>цена <?=$items_products['price']?></li>
	</ul>
	<div class="count_order">
		<input id="count_order" data="input" class="value<?=$items_products['id']?>" type="text" placeholder="count" name="count_<?=$items_products['id']?>"><br>
		<span data="span" class="error<?=$items_products['id']?>" id="error_count"></span>
	</div>
	<a href="index.php?page=order&del=<?=$items_products['id']?>">delete</a>
	<hr>
	<br><br>

	<?php endforeach; ?>
		<input id="submit_order" type="submit"  value="оформить заказ">	
	</form>

<?php endif ?>







 <!-- СКРИПТ ДЛЯ ОТМЕНЫ АВТОМАТИЧЕСКОГО ПОВТОРНОГО ЗАПОЛНЕНИЯ ФОРМЫ ПОСЛЕ ПЕРЕЗАГРУЗКИ СТРАНИЦЫ-->
<script>
	if ( window.history.replaceState ) {
	window.history.replaceState( null, null, window.location.href );
	}
</script>



