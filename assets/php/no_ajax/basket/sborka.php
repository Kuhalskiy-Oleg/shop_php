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

<?php endif; ?>