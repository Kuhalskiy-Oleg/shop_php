<?php  
	//КОД ДЛЯ ОТОБРАЖЕНИЯ ТЕХ ПРОДУКТОВ В КОРЗИНЕ КОТРЫЕ ВЫБРАЛ ПОЛЬЗОВАТЕЛЬ В МАГАЗИНЕ
	require('assets/php/no_ajax/basket/add_id_session_in_order_products.php');
?>


<h1>Order</h1>
<!-- ЕСЛИ МЫ НАХОДИМСЯ В ПРОСМОТРЕ ТОВАРОВ В КОРЗИНЕ -->
<?php if($elem != 'open_order'): ?>

<div class="items_elements_order">
	<h2>Список товаров в корзине:</h2>
	<a href="index.php?page=basket&elem=open_order">Просмотреть заказ</a>
</div>
<a href="index.php?page=basket&elem=del_order">Отчистить корзину</a><br><br>

<!-- если корзина пуста то скрываем код для отображения  выбранных товаров -->
<?php require('assets/php/no_ajax/basket/if_basket_not_null_to.php'); ?>
	


<!-- ЕСЛИ МЫ НАХОДИМСЯ В ПРОСМОТРЕ ЗАКАЗОВ -->
<?php elseif($elem == 'open_order'): ?>




<div class="items_elements_order">
	<h2>Ваши заказы:</h2>
	<a href="index.php?page=basket">Просмотреть cписок товаров в корзине</a>
</div>

	<?php if(isset($_SESSION['loginn'])): ?>
		
	<h3>Cборка:</h3>

	<?php 
		$position_order_user = '';
		$position_order_user_count = '';

		//подключаемся к products_lesson_6
		require('assets/php/db/link_db.php');
		$position_order_user = mysqli_query($products_lesson_6, "SELECT * FROM `order_products` WHERE `user_id` = {$_SESSION['id']}");
		$position_order_user = mysqli_fetch_assoc($position_order_user);
		mysqli_close($products_lesson_6);

		if (isset($position_order_user)){
			$position_order_user_count = count($position_order_user);
		} 

		if($position_order_user_count > 0):
	?>


	<?php 

		//КОД ДЛЯ ОТОБРАЖЕНИЯ ТАБЛИЦЫ С ТОВАРАМИ КОТРЫЕ ВЫБРАД ПОЛЬЗОВАТЕЛЬ И КОНЕЧНОЙ СУММОЙ

		//подключаемся к products_lesson_6
		require('assets/php/db/link_db.php');

		$orders = mysqli_query($products_lesson_6, "SELECT * FROM `order_products` ");

		//получаем список товаров котрый сделал ползьзователь и создаем отдельную колонку где будем выводить результат умножения кол-во товара на его стоимость
		$all_orders = mysqli_query($products_lesson_6, "SELECT *, `price` * `count` as `total_price` FROM `order_products` INNER JOIN `users` ON `users`.`id` = `order_products`.`user_id` INNER JOIN `products` ON `products`.`id` = `order_products`.`products_id` WHERE `user_id` = {$_SESSION['id']} ");

		//в дальнейшем мы будем считать сколько элементов в массиве из count_mysql_array[]
		$count_mysql_array = [];
		// foreach ($all_orders as $value) {
		// 	$count_mysql_array[] = $value;
		// }
		$count_mysql_array = mysqli_fetch_all($all_orders , MYSQLI_ASSOC ); // можно обойтись без foreach 
		// echo('<pre>');
		// print_r($count_mysql_array);
		// echo('</pre>');

		



		//получаем общую сумму заказа
		$to_be_paid = mysqli_query($products_lesson_6, "SELECT  sum(`price` * `count`) as `to_be_paid`  FROM `order_products` INNER JOIN `users` ON `users`.`id` = `order_products`.`user_id` INNER JOIN `products` ON `products`.`id` = `order_products`.`products_id` WHERE `user_id` = {$_SESSION['id']} ");
		//записываем ее в ассоциативный массив
		$to_be_paid = mysqli_fetch_assoc($to_be_paid);
		// echo('<pre>');
		// print_r($to_be_paid);
		// echo('</pre>');





		
		


		mysqli_close($products_lesson_6);
			
	?>
	<!-- ПОКАЗЫВАЕМ ТАБЛИЦУ СО СБОРКОЙ ЗАКАЗА -->
	<table id="table">

		<colgroup>
			<col span="1" style="background-color:#ff5454b0">
	    	<col span="1" style="background-color:Khaki"><!-- С помощью этой конструкции задаем цвет фона для столбцов таблицы-->
	    	<col span="7" style="background-color:LightCyan">
	    	<col span="8" style="background-color:#d6ffbf">
	  	</colgroup>

	  	<!-- шапка таблицы -->
	  	<tr>
	  		<th>удалить позицию</th>
	    	<th>№ позиции в заказе</th>
	    	<th>Имя</th>
	   	 	<th>Фамилия</th>
	   		<th>email</th>
	   	 	<th>id продукта</th>
	    	<th>brand</th>
	    	<th>model</th>
	    	<th>color</th>
	    	<th>кол-во</th>
	    	<th>Цена за 1шт</th>
	    	<th>итого</th>
	    	<th>к оплате</th>
	  	</tr>

		<?php 
			$count_orders = count($count_mysql_array);
			foreach ($all_orders as $value): 
		?>
			<!-- тело таблицы -->
		  	<tr id_tr_tabl_sborka="<?=$value['order_id']?>">
		  		<td class="delete">
		  			<!-- удаление позиции из order_products -->
		  			<form action="assets/php/order/delete_elem_for_order_products_sborka.php" method="post" class="del_element_order_products">
		  				<input type="hidden" name="position_items_order" value="<?=$value['order_id']?>">
		  				<label for="submit_del_element_order_products_<?=$value['order_id']?>"><i class="fas fa-trash-alt"></i></label>
		  				<input type="submit" class="submit_del_element_order_products" id="submit_del_element_order_products_<?=$value['order_id']?>" style="display: none;">
		  			</form>	
		  			
		  		</td>
		    	<td><?= $value['order_id']?></td>
		    	<td><?= $value['name']?></td>
		    	<td><?= $value['family']?></td>
		    	<td><?= $value['email']?></td>
		    	<td><?= $value['products_id']?></td>
		    	<td><?= $value['brand']?></td>
		    	<td><?= $value['model']?></td>
		    	<td><?= $value['color']?></td>
		    	<td>
		    		<form class="count_pos_items_order" action="assets/php/order/edit_count_in_posit_order.php" method="post">
		    			<input type="hidden" name="value_order_id" value="<?= $value['order_id']?>">
		    			<input class="count_input" name="edit_count_posit" type="text" value="<?= $value['count']?>">
		    			<input class="submit_order_edit_pos" type="submit" value="edit">
		    		</form>
		    	</td>
		    	<td><?= $value['price']?></td>
		    	<td><?= $value['total_price']?></td>
		  	</tr>

		
	  	<?php endforeach; ?>

	  	<!-- код для добавления полследнего столбца который будет обьединен со всеми рядами -->
	  	<script>
	  		//ищем второй ряд
		  	let trs = document.querySelectorAll('#table tr:nth-child(' + 2 + ')');
		  	//добавляем ко второму ряду в последнюю колонну один элемент
			for (let tr of trs) {
				let td = document.createElement('td');
				//rowspan делает элемент одним общим блоком с указанным кол-вом рядов
				//кол-во рядов берем из кол-ва элементов в массиве с заказами
				td.setAttribute('rowspan','<?=$count_orders?>');
				td.innerHTML = (<?=$to_be_paid['to_be_paid']?>).toFixed(2);//toFixed(2) чтобы были два нуля после точки если число целое
				tr.appendChild(td);
			}		
		</script>


	</table>

	<?php endif ?>











	<br><br>





















	
	<!-- если у пользователя нет позиций с выбранным товаром в бд то скрываем код для генерации таблицы с выбранными товарами -->
	<?php if($position_order_user_count > 0): ?>
		
	<form class="form_oplata" action="assets/php/order/add_item_zakaz_for_products_order_in_paid_order.php" method="post">
		<div class="error_hom">
			<input type="text"   placeholder="телефон получателя" name="telephone">
			<span class="error error_telephone"></span>
		</div>

		<div class="error_hom">
			<input type="text"   placeholder="адрес доставки"     name="adres">
			<span class="error error_adress"></span>
		</div>

		<div class="error_hom">
			<input type="text" value="<?=$to_be_paid['to_be_paid']??null?>" placeholder="введите сумму" name="sum" >
			<span class="error error_sum"><?=$oplata_err??null?></span>
		</div>

		<input type="submit" value="оплатить" >
	</form>
	<?php endif; ?>


	<h3>Оплаченные:</h3>

	<?php  
		//КОД ДЛЯ ОТОБРАЖЕНИЯ ТАБЛИЦ С ОПЛАЧЕННЫМИ ТОВАРАМИ

		//подключаемся к products_lesson_6
		require('assets/php/db/link_db.php');


		//выводим всю инфу о пользователе по вторичному ключy из таблицы users в таблицу paid_orders
		//соединение двух таблиц users - paid_orders
		//сортируем поиск от самого большего значения номера заказа у определенного пользователя id_paid_orders к самому меньшему
		$paid_orders_users = mysqli_query($products_lesson_6, "SELECT * from `paid_orders`  INNER JOIN `users` ON `users`.`id` = `paid_orders`.`id_users`  WHERE `id_users` = '{$_SESSION['id']}' ORDER BY `id_paid_orders` DESC ");

		// echo'<pre>';
		// print_r($paid_orders_users);
		// echo'</pre>';






		$id_products_array = [];
		$id_products_array_explode = [];
		$id_count_array = [];
		$id_count_array_explode = [];

		foreach ($paid_orders_users as $key => $value) {
			// echo'<pre>';
			// print_r($value);
			// echo'</pre>';
			$id_products_array[] = $value['id_products'];
			$id_products_array_explode[] = explode(",", $id_products_array[$key]);
			$id_count_array[] = $value['count_products'];
			$id_count_array_explode[] = explode(",", $id_count_array[$key]);

		}
		// echo'<pre>';
		// print_r($id_products_array);
		// echo'</pre><br>';

		//array_reverse — Возвращает массив с элементами в обратном порядке
		//$id_products_array_explode = array_reverse($id_products_array_explode);
		// echo'<pre>';
		// print_r($id_products_array_explode);
		// echo'</pre><br>';

		// echo'<pre>';
		// print_r($id_count_array);
		// echo'</pre><br>';

		// echo'<pre>';
		// print_r($id_count_array_explode);
		// echo'</pre><br>';
		

		
		mysqli_close($products_lesson_6);


		//запускаем цикл в котором будут создаваться таблицы в том кол-ве сколько элементов в массиве . элемент - оплаченный заказ
		foreach ($paid_orders_users as $KEY => $value):
	?>

	<table id="table" class="paid_orders<?=$KEY?>">

		<colgroup>
	    	<col span="1" style="background-color:Khaki"><!-- С помощью этой конструкции задаем цвет фона для столбцов таблицы-->
	    	<col span="9" style="background-color:LightCyan">
	    	<col span="10" style="background-color:#d6ffbf">
	  	</colgroup>

	  	<!-- шапка таблицы -->
	  	<tr>
	    	<th>№ заказа</th>
	    	<th>Имя</th>
	   	 	<th>Фамилия</th>
	   		<th>Телефон</th>
	   		<th>Адрес</th>
	   		<th>email</th>
	   	 	<th>id продукта</th>
	    	<th>brand</th>
	    	<th>model</th>
	    	<th>color</th>
	    	<th>Кол-во</th>
	    	<th>Цена за 1шт</th>
	    	<th>Общая сумма</th>
	  	</tr>

	  	<!-- тело таблицы -->
	  	<tr>
	    	<td><?= $value['id_paid_orders']?></td>
	    	<td><?= $value['name']?></td>
	    	<td><?= $value['family']?></td>
	    	<td><?= $value['telephone']?></td>
	    	<td><?= $value['adres']?></td>
	    	<td><?= $value['email']?></td>
	    	<td></td>
	    	<td></td>
	    	<td></td>
	    	<td></td>
	    	<td></td>
	    	<td></td>
	  	</tr>

	  	<!-- для подсчета сколько продуктов в заказе для того чтобы js смог растянуть последний элемент таблицы на все ряды -->
	  	<?php $count_id_products = count($id_products_array_explode[$KEY]) + 1; //echo "$count_id_products"; ?>

	  	<!-- код для добавления полследнего столбца который будет обьединен со всеми рядами -->
	  	<script>
	  		//ищем второй ряд
		  	let trs<?=$KEY?> = document.querySelectorAll('#table.paid_orders<?=$KEY?> tr:nth-child(' + 2 + ')');
		  	//добавляем ко второму ряду в последнюю колонну один элемент
			for (let tr<?=$KEY?> of trs<?=$KEY?>) {
				let td<?=$KEY?> = document.createElement('td');
				//rowspan делает элемент одним общим блоком с указанным кол-вом рядов
				//кол-во рядов берем из кол-ва элементов в массиве с заказами
				td<?=$KEY?>.setAttribute('rowspan','<?=$count_id_products?>');
				td<?=$KEY?>.innerHTML = (<?= $value['total_cost']?>).toFixed(2);//toFixed(2) чтобы были два нуля после точки если число целое
				tr<?=$KEY?>.appendChild(td<?=$KEY?>);
			}	
		</script>


		
		<?php 
			//подключаемся к products_lesson_6
			require('assets/php/db/link_db.php');


			$products_array = [];
			//перебираем массив в котором хранятся id тех товаров , которые заказал пользователь
			//и далее ищем эти товары в бд и наполняем ими массив products_array[]
			foreach ($id_products_array_explode[$KEY] as $key =>  $value){
				$id_products_array_items_mysql = mysqli_query($products_lesson_6, "SELECT * FROM `products` WHERE `id` = '{$value}' ");
				$products_array[] = mysqli_fetch_assoc($id_products_array_items_mysql);
				
			}
			// echo'<pre>';
			// print_r($products_array);
			// echo'</pre>';


			mysqli_close($products_lesson_6);


			//запускаем цикл в котором перебираются все товары которые были в заказе
			foreach ($products_array as $key => $value_product): 
		?>
		<!-- тело таблицы -->
		<tr>
			<td></td>
	    	<td></td>
	    	<td></td>
	    	<td></td>
	    	<td></td>
	    	<td></td>
	    	<td><?= $value_product['id']?></td>
	    	<td><?= $value_product['brand']?></td>
	    	<td><?= $value_product['model']?></td>
	    	<td><?= $value_product['color']?></td>
	    	<td><?= $id_count_array_explode[$KEY][$key]?></td>
	    	<td><?= $value_product['price']?></td>
	  	</tr>
	  	

	  	<?php endforeach ?>

	</table>
	<br>
	<?php endforeach; ?>

	  	


	<?php endif; ?>


<?php endif; ?>





 <!-- СКРИПТ ДЛЯ ОТМЕНЫ АВТОМАТИЧЕСКОГО ПОВТОРНОГО ЗАПОЛНЕНИЯ ФОРМЫ ПОСЛЕ ПЕРЕЗАГРУЗКИ СТРАНИЦЫ-->
<script>
	if ( window.history.replaceState ) {
	window.history.replaceState( null, null, window.location.href );
	}
</script>




