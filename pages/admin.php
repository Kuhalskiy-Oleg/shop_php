








<?php if (!empty($_SESSION['loginn'])): ?>

 <div class="admin">
 	<h2> <?php echo "Добрый день ".$_SESSION['loginn']; ?> </h2>
 	<a class="exit" href="assets/php/personal_account/exit.php">выйти</a>
 </div>




<?php else: ?>

 
<div class="home_avtorizac">
	<form class="form_avtorization" action="assets/php/personal_account/avtorization.php" method="post">
		<label>Авторизация</label>

		<span  class="login_user_error" id="span"></span>
		<input type="text"     name="form_avtorization_login"    placeholder="введите ваш логин">

		<span  class="password_user_error" id="span"></span>
		<input type="password" name="form_avtorization_password" placeholder="введите пароль">

		<input class="submit_form_registration" type="submit"   name="form_avtorization_submit"   value="отправить">
	</form>
</div>
<?php endif; ?>


<?php 
	$session_login = $_SESSION['loginn'] ?? null;
	if($session_login == '12345'): 
?>



<div class="select_admin">
	<a href="index.php?page=admin&select=product_edid">Редактор продуктов</a>
	<a href="index.php?page=admin&select=order_edid">Редактор заказов</a>
</div>


<?php  
	
	$select = $_GET['select'] ?? null;
	if ($select == 'product_edid'):?>
		

		<div class="card">
			<div class="card_wrapper">

				<div class="card_item card_item--add">



				  	<form id="form_add_card" class="form_card" method="post" action="assets/php/add_update_delete_card/add_card.php" enctype="multipart/form-data">
				  		<div class="id_card add">
				  			<span></span>
				  		</div>
				      	<div class="card-header add">
				        	<h4 class="text">
				        		<input class="value_name" type="text" name="value_brand"  placeholder="введите брэнд">
				        		<span class="text_error add"></span>
				        	</h4>
				      	</div>

				      	<div class="card-body add">
				      		
				      		<div class="home_img add">

					      		<label class="file_input" for="file_input_id">
					      			<span class="span_absolut">Выбрать изображение</span>
					      			<img class="img add" id="img_add" src="assets/images/add_card/350.jpg" alt="">
					      		</label>
					      		<input style="display: none;" type="file" name="add_file"  id="file_input_id">
					      		<span class="home_img_error add"></span>
					  		</div>

					  		<div class="description add">
					  			
					  			<textarea class="value_discription add" type="text" name="value_discription"  placeholder="введите описание товара"></textarea>
					  			<span class="description_error add"></span>

					  		</div>

					  		<div class="Model add">
					  			<span>Model: 
					  				<input class="value_model" type="text" name="value_model"  placeholder="введите модель">
					  			</span>
					  			<span class="Model_error add"></span>	
					  		</div>

					  		<div class="color add">
					  			<span>Color:
					  				<input class="value_color" type="text" name="value_color"  placeholder="введите цвет">
					  			</span>
					  			<span class="color_error add"></span>
					  		</div>

					  		<div class="price add">
					  			<span>Price: 
					  				<input class="value_price" type="text" name="value_price"  placeholder="введите стоимость">
					  			</span>
					  			<span class="price_error add"></span>
					  		</div>

					  		
				      	</div>

				      	<input type="submit"  value="Добавить" class="btn btn--add">

				  	</form>

				</div>







				

				<?php 

					//подключаемся к бд
					require('assets/php/db/link_db.php');
					$tabl_products = mysqli_query($products_lesson_6, "SELECT * FROM `products` ");
					mysqli_close($products_lesson_6);
					foreach ($tabl_products as  $items_products): 

				?>

				
				<div class="card_item card_item--update">

				  	<form id="form_update_card_<?= $items_products['id'] ?>" class="form_card" method="post" action="assets/php/add_update_delete_card/update_card.php" enctype="multipart/form-data">
				  		<div class="id_card update">
				  			<span>id = <?= $items_products['id'] ?></span>
				  			<input id="id_card" style="display: none;" name="id_card" type="text" value="<?= $items_products['id'] ?>">
				  		</div>
				      	<div class="card-header update">
				        	<h4 class="text">
				        		<input class="value_brand update" type="text" name="value_brand" value="<?= $items_products['brand']; ?>" placeholder="">
				        		<span class="text_error update"></span>
				        	</h4>
				      	</div>

				      	<div class="card-body update">
				      		
				      		<div class="home_img update">
					      			
				      			<a href="index.php?page=img&id=<?=  $items_products['id'] ?>" target="_blank">
									<img class="img upload" id="img_upload" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
								</a>
					      		
					      		<div class="home_form_zamena_img">
									<input class="input_zamena_file update" type="file" name="input_zamena_img" >
								</div>
					      		<span class="home_img_error update"></span>

					  		</div>

					  		<div class="description update">
					  			
					  			<textarea class="value_discription update" type="text" name="value_discription" value="<?= $items_products['description']; ?>" placeholder=""><?= $items_products['description']; ?></textarea>
					  			<span class="description_error update"></span>

					  		</div>

					  		<div class="Model update">
					  			<span>Model: 
					  				<input class="value_model update" type="text" name="value_model" value="<?= $items_products['model']; ?>" placeholder="">
					  			</span>
					  			<span class="Model_error update"></span>	
					  		</div>

					  		<div class="color update">
					  			<span>Color:
					  				<input class="value_color update" type="text" name="value_color" value="<?= $items_products['color']; ?>" placeholder="">
					  			</span>
					  			<span class="color_error update"></span>
					  		</div>

					  		<div class="price update">
					  			<span>Price: 
					  				<input class="value_price update" type="text" name="value_price" value="<?= $items_products['price']; ?>" placeholder="">
					  			</span>
					  			<span class="price_error update" ></span>
					  		</div>

					  		
				      	</div>

				      	
				      	<input type="submit" id="submit"   value="ИЗМЕНИТЬ" class="btn btn--add btn--create">

				      	<div class="home_btn_delete">

				      		<input id="delete" type="text" name="delete_2" value="delete" class="btn btn--delete">
				      		<label class="delete_label" for="delete">Удалить</label>

					  		<div class="home_input_radio_delete">
						  		<input id="submit"     class="radio_delete yes" name="radio_yes"  type="submit" value="yes" >
						  		<label for="radio_2" class="radio_2">no</label>
						  		<input id="radio_2"  name="radio_no"   class="radio_delete no"   type="text" value="no" >
						  	</div>
						  			  		
					  	</div>
					  	

				  	</form>

				</div>

				<?php endforeach ?>
			</div>
		</div>




		<!-- форма для удаления тех картинок которых нету в бд -->
		<form action="index.php?page=admin&select=product_edid" method="post">
			<label>УДАЛИТЬ ИЗОБРАЖЕНИЯ КОТОРЫЗ НЕТ В БД ?</label>
			<select name="dell_img" >
				<option value="no" selected>no</option>
				<option value="yes" >yes</option>
			</select>
			<input type="submit" value="delete" >
		</form>


		<?php  

			$scandir = scandir(IMG_DIR);
			

			$img = [];
			//фильтруем все файлы в папке и отбираем только с расширением jpg / jpeg / png и помещаем эти файлы в массив img[]
			foreach ($scandir as $file) {

				//проверяем является ли файл обычным файлом а не специальным
				if ( is_file(IMG_DIR . $file)) {

					//strtolower — Преобразует строку в нижний регистр
					$file = strtolower($file);

					//проверяем на совпадение расширения файлов с заданными в условии
					if ((pathinfo($file, PATHINFO_EXTENSION) == 'jpg')  || 
						(pathinfo($file, PATHINFO_EXTENSION) == 'jpeg') || 
						(pathinfo($file, PATHINFO_EXTENSION) == 'png'))  {

						$img[] = pathinfo($file, PATHINFO_BASENAME);

							
						

					}

				}

			}
			echo "изображения в папке " . IMG_DIR;
			echo "<pre><br>";
			print_r($img);
			echo "</pre><br>";

			

			//подключаемся к бд
			require('assets/php/db/link_db.php');

			//вывести все из бызы данных $mysql из таблицы userd
			$tabl_products = mysqli_query($products_lesson_6, "SELECT * FROM `products` ");

			//обходим массив бд
			foreach ($tabl_products as $value) {
				//все строки перведим в нижний регистр
				$value['name_img'] = strtolower($value['name_img']);
				//если в массиве img есть картинки как в бд то
				if (in_array($value['name_img'], $img)) {
					$img = array_flip($img);          //Меняем местами ключи и значения для того чтобы удаление было по значению ключа
					unset($img[$value['name_img']] ); //удаляем элемент в массиве img 
					$img = array_flip($img);          //Меняем местами ключи и значения в исзодное положение
				}
			}

			
			//echo "ПОСЛЕ сортировки по совпадению одинаковых картинок в массивах img и БД";
			echo "картинки которых нет в БД:";
			echo "<pre><br>";
			print_r($img);
			echo "</pre><br>";

			$dell_img = $_POST['dell_img'] ?? null;

			if ($dell_img == 'yes') {
			
				foreach ($img as $file) {

					unlink(IMG_DIR . $file);

				}
			}

			mysqli_close($products_lesson_6);

			
		?>












	<?php elseif ($select == 'order_edid'):?>

		<?php 

			//подключаемся к products_lesson_6
			require('assets/php/db/link_db.php');

			$orders = mysqli_query($products_lesson_6, "SELECT * FROM `order_products` ");

			

			$paid_orders_users = mysqli_query($products_lesson_6, "SELECT * FROM `paid_orders` INNER JOIN `users` ON `users`.`id` = `paid_orders`.`id_users` ORDER BY `id_paid_orders` DESC");


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
		    	<col span="2" style="background-color:Khaki"><!-- С помощью этой конструкции задаем цвет фона для столбцов таблицы-->
		    	<col span="8" style="background-color:LightCyan">
		    	<col span="1" style="background-color:Khaki">
		    	<col span="3" style="background-color:LightCyan">
		    	<col span="3" style="background-color:#d6ffbf">
		  	</colgroup>

		  	<!-- шапка таблицы -->
		  	<tr>
		    	<th>№ заказа</th>
		    	<th>Id клиента</th>
		    	<th>Login</th>
		    	<th>Имя</th>
		   	 	<th>Фамилия</th>
		   		<th>Телефон</th>
		   		<th>Адрес</th>
		   		<th>Email</th>
		   		<th>Дата обновления клиента</th>
		   		<th>Дата регистрации клиента</th>		   		
		   	 	<th>Id продукта</th>
		    	<th>Brand</th>
		    	<th>Model</th>
		    	<th>Color</th>
		    	<th>Кол-во</th>
		    	<th>Цена за 1шт</th>
		    	<th>Общая сумма</th>
		  	</tr>

		  	<!-- тело таблицы -->
		  	<tr>
		    	<td><?= $value['id_paid_orders']?></td>
		    	<td><?= $value['id']?></td>
		    	<td><?= $value['login']?></td>
		    	<td><?= $value['name']?></td>
		    	<td><?= $value['family']?></td>
		    	<td><?= $value['telephone']?></td>
		    	<td><?= $value['adres']?></td>
		    	<td><?= $value['email']?></td>
		    	<td><?= $value['date_update']?></td>
		    	<td><?= $value['date_create']?></td>
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


