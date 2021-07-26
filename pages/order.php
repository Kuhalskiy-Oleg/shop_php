<?php 
	function valid_get($data) {
		$data = trim($data);             //trim - функция  удаляет пробелы до и после слова но в самом слове пробелы не удаляет
		$data = stripslashes($data);     //stripslashes — Удаляет экранирование символов
		$data = strip_tags($data);       //strip_tags — Удаляет теги HTML и PHP из строки
		$data = htmlspecialchars($data); //htmlspecialchars — Преобразует специальные символы в HTML-сущности
		return $data;
    }
	$elem = $_GET['elem'] ?? null;
	//$del_elem_array = $_GET['del_elem_korzin'] ?? null;
	$del_elem_order = $_GET['del_elem_ord'] ?? null;

	//echo $_SESSION['product_id'];


	//удаление всех элементов id продуктов из сессии
	if ($elem == 'del_order') {
		unset($_SESSION['product_id']);
		echo 
		"
		<script>
            window.location.href = \"index.php?page=order\"; 
        </script>
		";
	}


	



	

	//КОД ДЛЯ ОТОБРАЖЕНИЯ ТЕХ ПРОДУКТОВ В КОРЗИНЕ КОТРЫЕ ВЫБРАЛ ПОЛЬЗОВАТЕЛЬ В МАГАЗИНЕ

	//записываем результат сеессии в product_id_S и делаем из строки - массив с разбиением чисел по ;
	$product_id_S = $_SESSION['product_id'] ?? null;
	$product_id_S_array = explode(";", $product_id_S);



	//подключаемся к products_lesson_6
	require('assets/php/db/link_db.php');

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
	//var_dump($row);
	mysqli_close($products_lesson_6);

?>





<h1>Order</h1>
<!-- ЕСЛИ МЫ НАХОДИМСЯ В ПРОСМОТРЕ ТОВАРОВ В КОРЗИНЕ -->
<?php if($elem != 'open_order'): ?>

<div class="items_elements_order">
	<h2>Список товаров в корзине:</h2>
	<a href="index.php?page=order&elem=open_order">Просмотреть заказ</a>
</div>
<a href="index.php?page=order&elem=del_order">Отчистить корзину</a><br><br>

	<!-- если корзина пуста то скрываем кнопку оформить заказ -->
	<?php if (!empty($row)): ?>
		<?php $i = 0; ?>
		<div class="gg">
		<form class="form_card_body_add_order" action="assets/php/order/add_items_order.php" method="post">
		<?php foreach ($row as $key => $items_products):  ?> 
		<?php $i += 1; ?>
			


		

		<span number="<?=$items_products['id']?>">Товар номер <?=$i?>)</span>
		<ul number="<?=$items_products['id']?>">
			<li>id продукта <?=$items_products['id']?></li>
			<li>бренд <?=$items_products['brand']?></li>
			<li>модель <?=$items_products['model']?></li>
			<li>цвет <?=$items_products['color']?></li>
			<li>цена <?=$items_products['price']?></li>
		</ul>
		<div number="<?=$items_products['id']?>" class="count_order two<?=$items_products['id']?>">
			<input id="count_order" data="input" class="value<?=$items_products['id']?>" type="text" placeholder="count" name="count_<?=$items_products['id']?>"><br>
			<span data="span" class="error<?=$items_products['id']?>" id="error_count"></span>
		</div>

		<hr number="<?=$items_products['id']?>">
		<br number="<?=$items_products['id']?>"><br number="<?=$items_products['id']?>">


		

		<?php endforeach; ?>
			<input id="submit_order" type="submit"  value="оформить заказ">	
		</form>


		<?php foreach ($row as $key => $items_products):  ?> 
		<form number="<?=$items_products['id']?>" class="form_delete_elem_korz" method="post" action="assets/php/order/delete_elem_korz.php" style="visibility: hidden; height: 0;">
			<input number="<?=$items_products['id']?>" type="hidden" name="items_products_id_name" value="<?=$items_products['id']?>">
			<input number="<?=$items_products['id']?>" type="submit" data="submit_items_products_id_name" class="vvvv<?=$items_products['id']?>" value="delete" style="visibility: visible;" >
		</form>

		<!-- устанавливаем кнопки (для отправки формы с удалением элемента из корзины) в форму с выбранным товаром -->
		<script>
			


			

		 	$.each($('.count_order.two<?=$items_products['id']?>'), function(index,value){
			    //console.log($(value).position());
			    console.log($(value).position().top);
			    let top_<?=$items_products['id']?> = $(value).position().top;
			    let left_<?=$items_products['id']?> = $(value).position().left;
			    $('.vvvv<?=$items_products['id']?>').offset({top: top_<?=$items_products['id']?> + 28, left: left_<?=$items_products['id']?> });
			})
			
 		</script>

		<?php endforeach; ?>

		
		
		 

		</div>

		

	<?php endif ?>





















<!-- ЕСЛИ МЫ НАХОДИМСЯ В ПРОСМОТРЕ ЗАКАЗОВ -->
<?php elseif($elem == 'open_order'): ?>




<div class="items_elements_order">
	<h2>Ваши заказы:</h2>
	<a href="index.php?page=order">Просмотреть cписок товаров в корзине</a>
</div>

	<?php if(isset($_SESSION['loginn'])): ?>
		
	<h3>Cборка:</h3>

	<!-- если у пользователя нет позиций с выбранным товаром в бд то скрываем код для генерации таблицы с выбранными товарами -->
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
		foreach ($all_orders as $value) {
			$count_mysql_array[] = $value;
		}
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





		//если кнопка удалить позицию из заказа нажата то
		if (isset($del_elem_order)) {
			
			
			if ($del_elem_order != '') {
				
				if(mysqli_query($products_lesson_6, "DELETE FROM  `order_products` WHERE `order_id` = '{$del_elem_order}' ")){
					echo "string";
					echo 
					"
					<script>
			            window.location.href = \"index.php?page=order&elem=open_order\"; 
			        </script>
					";
				}else{
					$mysql_error = mysqli_error($products_lesson_6);
					echo 
					"
					<script>
			            alert('при удалении позиции из заказа возникла ошибка ' + $mysql_error);
			        </script>
					";
				}
			}
				
		}
		


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
		  	<tr>
		  		<td class="delete"><a href="index.php?page=order&elem=open_order&del_elem_ord=<?=$value['order_id']?>"><i class="fas fa-trash-alt"></i></a></td>
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
		    			<input id="submit_order_edit_pos" type="submit" value="edit">
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





















	<?php  
		//КОД ДЛЯ ДОБАВЛЕНИЯ В БД ОПЛАЧЕННОГО ЗАКАЗА И УДАЛЕНИЯ ИЗ БД ТЕХ ПОЗИЦИЙ ТОВАРОВ КОТОРЫЕ БЫЛИ В ЗАКАЗЕ


	  	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	             
	  		$telephone = $_POST['telephone'] ?? null;
	  		$adress = $_POST['adres'] ?? null;
	  		$oplata = $_POST['sum'] ?? null;

	  		$telephone_err = $adress_err = $oplata_err = '';


	  		//______________________ПРОВЕРЯЕМ ТЕЛЕФОН______________________
	  		if(empty($telephone)){
	  			$telephone_err = "это поле обязательно к заполнению";

	  		}elseif(mb_strlen($telephone) > 20 ){
					$telephone_err = "Недопусимая длина строки (до 20 символов)";
	 
	  		}elseif(!preg_match("/^[+]?[0-9]+$/",$telephone)){
	  			$telephone_err = "введите только цифры и один символ +";

	  		}else{
	  			$telephone_valid = valid_get($telephone);
	  		}


	  		//______________________ПРОВЕРЯЕМ АДРЕС______________________
	  		if(empty($adress)){
	  			$adress_err = "это поле обязательно к заполнению";

	  		}elseif(mb_strlen($adress) > 200 ){
					$adress_err = "Недопусимая длина строки (до 200 символов)";

	 		//i - регистронезависимый
	  		//u - юникод для работы с текстами
	  		}elseif(!preg_match("/^([0-9]|[a-z]|[а-яё]|[., -])+$/iu",$adress)){
	  			$adress_err = "введите только буквы и символы . , -";
	  		}else{
	  			$adress_valid = valid_get($adress);
	  		}


	  		
	  		//______________________ПРОВЕРЯЕМ ЦЕНУ______________________
		    if (!empty($oplata)) {
		    	$oplata = str_replace(",",".",$oplata); //заменяем запятую на точку
		    	

				if(mb_strlen($oplata) > 15 ){
					$oplata_err = "Недопусимая длина строки (до 15 символов)";

				//[+-]? один из + или же -
				//^ - начало строки
				//$ - конец строки
				//+  ищем один или более раз (в данном случае цифру с запятой)
				//проверяем, содержит ли число только один знак точка , один знак плюс или мину , и только числа без пробелов если нет то {}
				}elseif(!preg_match("/^[0-9]*[.]?[0-9]+$/",$oplata)){
					$oplata_err = 'введите только цифры без пробелов и символов кроме . и ,';

				}elseif($oplata > 1000000000 ){
					$oplata_err = "Недопусимая сумма - введите не больше 100 000 000";

				}elseif($oplata <= 0 ){
					$oplata_err = "Недопусимая сумма - введите больше 0";


				}elseif(!preg_match("/^\d{0,10}(\d{1,10}[.]\d{0,2})?$/", $oplata)){
					$oplata_err = 'введите корректное число';


				}else{
					
					
					$oplata_valid = valid_get($oplata);
					$oplata_valid = (float)$oplata_valid;
				}
		    }else{
		    	$oplata_err = "Это поле обязательно к заполнению";
		    }




		    if((!empty($telephone_valid)) &&
		       (!empty($adress_valid))    &&
		   	   (!empty($oplata_valid))){

		   	   	if((empty($telephone_err)) &&
			       (empty($adress_err))    &&
			   	   (empty($oplata_err))) {

			   	   	$to_be_paid_two = $to_be_paid['to_be_paid'];
			   	   	$to_be_paid_float = (float)$to_be_paid_two;


		   	   		//если заказ оплачен то добавляем в таблицу paid_orders оплаченный заказ
					if ($oplata_valid === $to_be_paid_float) {
						

						//подключаемся к products_lesson_6
						require('assets/php/db/link_db.php');
						//$products_lesson_6 = mysqli_connect("127.0.0.1", "root", "root", "products_lesson_6", 3307 ) or die ("НЕ УДАЛОСЬ ПОДКЛЮЧИТСЯ К БАЗЕ ДАННЫХ");

						//код для группировки всех count в один столбец через запятую к одному человеку
						$count_products_paid_order = mysqli_query($products_lesson_6, "SELECT `user_id`, GROUP_CONCAT(`count`) as `count` FROM `order_products` WHERE `user_id` = '{$_SESSION['id']}' GROUP BY `user_id`");
						$count_paid_order = mysqli_fetch_assoc($count_products_paid_order);
						//print_r($count_paid_order);


						//код для группировки всех id продуктов в один столбец через запятую к одному человеку
						$paid_order = mysqli_query($products_lesson_6, "SELECT `user_id`, GROUP_CONCAT(`products_id`) as `products_id` FROM `order_products` WHERE `user_id` = '{$_SESSION['id']}' GROUP BY `user_id`");
						$paid_order = mysqli_fetch_assoc($paid_order);
						//print_r($paid_order);



						//защищаем бд от иньекций
						$telephone_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($telephone_valid)));
						$adress_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($adress_valid)));
						$oplata_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($oplata_valid)));

						//добавляем оплаченный заказ в бд
						if (mysqli_query($products_lesson_6, "INSERT INTO `paid_orders` (`id_users`       ,
																						 `id_products`    ,
																						 `count_products` ,
																						  `status`        ,
																						  `adres`         ,
																						  `total_cost`    ,
																						  `telephone`     )
																						   
															  VALUES ('{$paid_order["user_id"]}'          ,
															  		  '{$paid_order["products_id"]}'      ,
															  		  '{$count_paid_order["count"]}'      ,
															  		  'Оплачено'                          ,
															  		  '{$adress_valid_db}'                ,
															  		  '{$oplata_valid_db}'                ,
															  		  '{$telephone_valid_db}'             )")) {

															  		
							
							$rezult_add = mysqli_insert_id($products_lesson_6);
							echo 
							"
							<script>
					            alert('заказ оплачен , ваш номер заказа '+$rezult_add  );
					        </script>
							";

							//перебираем массив со сборкой заказа и удаляем те позиции котрые были в сборке
							foreach ($count_mysql_array as  $value) {
								if(mysqli_query($products_lesson_6, "DELETE FROM  `order_products` WHERE `order_id` = '{$value['order_id']}' ")){
									echo "  
									<script>	                        
			                            setTimeout(function () {
			                               window.location.href = 'index.php?page=order&elem=open_order'; 
			                            }, 10);   
			                        </script>
									";

								}else{
									$mysql_error = mysqli_error($products_lesson_6);
									echo 
									"
									<script>
							            alert('при удалении позиций из собранного заказа возникла ошибка ' + $mysql_error);
							        </script>
									";
								}
							}

						}else{
							$mysql_error = mysqli_error($products_lesson_6);
							echo 
							"
							<script>
					            alert('при добавлении оплаченного заказа в дб возникла ошибка ' + $mysql_error);
					        </script>
							";
						}


						mysqli_close($products_lesson_6);
						
					}else{

						echo 
						"
						<script>
				            alert('цена заказа не соответствует с введенной вами');
				        </script>
						";
					}

		   	   	}

		    }
		
	  	}
		

	?>

	<!-- если у пользователя нет позиций с выбранным товаром в бд то скрываем код для генерации таблицы с выбранными товарами -->
	<?php if($position_order_user_count > 0): ?>
		
	<form class="form_oplata" action="index.php?page=order&elem=open_order" method="post">
		<div class="error_hom">
			<input type="text" value="<?=$telephone??null?>"   placeholder="телефон получателя" name="telephone">
			<span class="error"><?=$telephone_err??null?></span>
		</div>

		<div class="error_hom">
			<input type="text" value="<?=$adress??null?>"  placeholder="адрес доставки"     name="adres">
			<span class="error"><?=$adress_err??null?></span>
		</div>

		<div class="error_hom">
			<input type="text" value="<?=$to_be_paid['to_be_paid']??null?>" placeholder="введите сумму" name="sum" >
			<span class="error"><?=$oplata_err??null?></span>
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



