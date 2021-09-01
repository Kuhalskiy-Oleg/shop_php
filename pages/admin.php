<!-- если мы вошли на сайт -->
<?php if (!empty($_SESSION['loginn'])): ?>
 <div class="admin">
 	<h2> <?php echo "Добрый день ".$_SESSION['loginn']; ?> </h2>
 	<a class="exit" href="assets/php/personal_account/exit.php">выйти</a>
 </div>



<!-- если мы не вошли на сайт -->
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



<!-- если зашел админ сайта то покажем редактор товаров -->
<?php 
	$session_login = $_SESSION['loginn'] ?? null;
	if($session_login == '12345'): 
?>

<?php  
	//записываем куки с выбором опции для сортировки и роиском нужного продукта по id в переменную
	$cookie_select = $_COOKIE["select_card_views"] ?? null; 

	$unserialize_cookie = unserialize($cookie_select);

	//print_r( $unserialize_cookie);

	//забираем массив переданный через куки для поиска нужного продукта
	$result_poisk_cookie = $unserialize_cookie[0]['result'] ?? null;
	$id_poisk_cookie = $unserialize_cookie[0]['id'] ?? null;
?>



<div class="select_admin">
	<a href="index.php?page=admin&select=product_edid">Редактор продуктов</a>
	<a href="index.php?page=admin&select=order_edid">Редактор заказов</a>
</div>





<?php  
	// если мы в режиме редактирования продуктов
	$select = $_GET['select'] ?? null;
	if ($select == 'product_edid'):?>

		<!-- поисковое меню -->
		<div class="nav_products">
			<form class="select_card_views_admin" action="assets/php/shop/selected_card_views.php" method="post" >
				<select name="select">
					<!-- если значение сессии = значению тега option то мы пишем атрибут selected -->
					<option <?=($unserialize_cookie == 'new') ? 'selected' : null;?> data="option_select_views_products" value="new">от новых к старым</option>
					<option <?=($unserialize_cookie == 'old') ? 'selected' : null;?> data="option_select_views_products" value="old">от cтарых к новым</option>
					<option <?=($unserialize_cookie == 'views_pop') ? 'selected' : null;?> data="option_select_views_products" value="views_pop" >самые просматриваемые</option>
				</select>
				<input type="submit"  value="Отправить">
			</form>


			<form class="select_card_poisk_admin" action="assets/php/shop/select_card_poisk.php" method="post">
				<div class="poisk_card_products_elem">
					<input name="poisk_card_products" type="text" placeholder="поиск товара по id">
					<input type="submit">
					<span class="error_select_card_poisk"></span>
				</div>
			</form>
		</div>
		

		<div class="card">
			<div class="card_wrapper">

				<!-- карточка для добавления продуктов -->
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







				
				<!-- код для пагинации -->
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
					$limit_elements = 5;

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
								echo "<a class='pagination_link' id='$value' href='index.php?page=admin&select=product_edid&str={$value}'>$value</a>";

							}
						}elseif (($count_products > 4)&&($str < 5)) {
							foreach (range(1, 5) as $value) {
								echo "<a class='pagination_link' id='$value' href='index.php?page=admin&select=product_edid&str={$value}'>$value</a>";

							}
						}elseif ((($count_products - 5) < 5)&&($str > 5)) {
							foreach (range($count_products - 4, $count_products) as $value) {
								echo "<a class='pagination_link' id='$value' href='index.php?page=admin&select=product_edid&str={$value}'>$value</a>";

							}
						}elseif (($count_products > 4)&&(($count_products - 5) < 5)&&($str == 5)) {
							foreach (range($str - 2, $count_products) as $value) {
								echo "<a class='pagination_link' id='$value' href='index.php?page=admin&select=product_edid&str={$value}'>$value</a>";

							}
						}elseif (($count_products > 4)&&(($count_products - 5) > 5)&&($str >= 5)&&($str <= ($count_products - 4))) {
							foreach (range($str - 2, $str + 2) as $value) {
								echo "<a class='pagination_link' id='$value' href='index.php?page=admin&select=product_edid&str={$value}'>$value</a>";

							}
						}elseif (($count_products > 4)&&(($count_products - 5) > 5)&&($str > ($count_products - 4))) {
							foreach (range($count_products - 4, $count_products) as $value) {
								echo "<a class='pagination_link' id='$value' href='index.php?page=admin&select=product_edid&str={$value}'>$value</a>";

							}
						}
					}
					

					mysqli_close($products_lesson_6);
			
				?>

				<!-- показываем продукты от самого нового если селектор в режиме all -->
				<?php if ($unserialize_cookie == 'new' ): ?>

					<?php foreach ($tabl_products_new as  $items_products): ?> 
				
					<!-- карточки для редактирования продуктов -->
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
						      			
					      			<div class="tag_a">
										<img popup="popup_<?=$items_products['id'];?>" class="img upload PopupLinks" id="img_upload" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
									</div>
						      		
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

					<!-- для модальных окон -->
					<div class="popup" id="popup_<?=$items_products['id'];?>">
						<div class="popup_content">
							<div class="close_popup">Закрыть</div>
							<img class="img PopupLinks" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
						</div>
					</div>

					<?php endforeach ?>












				<!-- показываем продукты от самого старого если селектор в режиме old -->
				<?php elseif ($unserialize_cookie == 'old' ): ?>

					<?php foreach ($tabl_products_old as  $items_products): ?>

					<!-- карточки для редактирования продуктов -->
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
						      			
					      			<div class="tag_a">
										<img popup="popup_<?=$items_products['id'];?>" class="img upload PopupLinks" id="img_upload" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
									</div>
						      		
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

					<!-- для модальных окон -->
					<div class="popup" id="popup_<?=$items_products['id'];?>">
						<div class="popup_content">
							<div class="close_popup">Закрыть</div>
							<img class="img PopupLinks" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
						</div>
					</div>

					<?php  endforeach; ?>  










				<!-- показываем продуты от самого просматриваемого  -->
				<?php elseif ($unserialize_cookie == 'views_pop' ):   ?>
						
					<?php foreach ($tabl_products_max_views as  $items_products): ?>

					<!-- карточки для редактирования продуктов -->
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
						      			
					      			<div class="tag_a">
										<img popup="popup_<?=$items_products['id'];?>" class="img upload PopupLinks" id="img_upload" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
									</div>
						      		
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

					<!-- для модальных окон -->
					<div class="popup" id="popup_<?=$items_products['id'];?>">
						<div class="popup_content">
							<div class="close_popup">Закрыть</div>
							<img class="img PopupLinks" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
						</div>
					</div>

					<?php  endforeach; ?>









				<!-- показываем продуты по поиску по id -->
				<?php elseif ($result_poisk_cookie == 'poisk'):  ?>

					<?php  foreach ($tabl_products_poisk_id as  $items_products): ?>

					<!-- карточки для редактирования продуктов -->
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
						      			
					      			<div class="tag_a">
										<img popup="popup_<?=$items_products['id'];?>" class="img upload PopupLinks" id="img_upload" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
									</div>
						      		
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


					<!-- для модальных окон -->
					<div class="popup" id="popup_<?=$items_products['id'];?>">
						<div class="popup_content">
							<div class="close_popup">Закрыть</div>
							<img class="img PopupLinks" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
						</div>
					</div>

					<?php  endforeach; ?>
								
			
		
		
			
		
				





				<!-- показываем все карточки если селектор не установлен  -->
				<?php else: ?>

					<?php  foreach ($tabl_products_all as  $items_products): ?>	

					<!-- карточки для редактирования продуктов -->
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
						      			
					      			<div class="tag_a">
										<img popup="popup_<?=$items_products['id'];?>" class="img upload PopupLinks" id="img_upload" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
									</div>
						      		
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

					<!-- для модальных окон -->
					<div class="popup" id="popup_<?=$items_products['id'];?>">
						<div class="popup_content">
							<div class="close_popup">Закрыть</div>
							<img class="img PopupLinks" src="assets/images/<?= $items_products['name_img'] ?>" alt="">
						</div>
					</div>


					<?php  endforeach; ?>

				<?php endif ?>


			</div>
		</div>


		<!-- для пагинации -->
		<div class="pagination">
			<?php if($str >= 5): ?>
			<a class="pagination_link_first"  href="index.php?page=admin&select=product_edid&str=1">1</a>
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











	<!-- если мы в режиме редактирования заказов -->
	<?php elseif ($select == 'order_edid'):?>

		<!-- поисковое меню -->
		<div class="nav_products order_edid">
			<form class="select_card_views_admin_order" action="assets/php/shop/selected_card_views.php" method="post" >
				<select name="select">
					<!-- если значение сессии = значению тега option то мы пишем атрибут selected -->
					<option <?=($unserialize_cookie == 'new') ? 'selected' : null;?> data="option_select_views_products" value="new">от новых к старым</option>
					<option <?=($unserialize_cookie == 'old') ? 'selected' : null;?> data="option_select_views_products" value="old">от cтарых к новым</option>
				</select>
				<input type="submit"  value="Отправить">
			</form>


			<form class="select_card_poisk_admin_order" action="assets/php/admin/select_edit_order/select_paid_order_poisk.php" method="post">
				<div class="poisk_card_products_elem">
					<input name="poisk_card_products" type="text" placeholder="поиск товара по id">
					<input type="submit">
					<span class="error_select_card_poisk"></span>
				</div>
			</form>
		</div>

		<?php 


			// //запускаем цикл в котором будут создаваться таблицы в том кол-ве сколько элементов в массиве . элемент - оплаченный заказ
			// foreach ($paid_orders_users as $KEY => $value):

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
			$limit_elements = 5;

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
				$count_products = ceil(count(mysqli_fetch_all(mysqli_query($products_lesson_6, "SELECT * FROM `paid_orders` WHERE `id_paid_orders` IN ('{$id_poisk_cookie_valid_db}')"))) / $limit_elements);
			}else{	
				$count_products = ceil(count(mysqli_fetch_all(mysqli_query($products_lesson_6, "SELECT * FROM `paid_orders`"))) / $limit_elements);
			}
			
			//echo "$count_products";






			$orders = mysqli_query($products_lesson_6, "SELECT * FROM `order_products` ");
			$id_products_array = [];
			$id_products_array_explode = [];
			$id_count_array = [];
			$id_count_array_explode = [];

			//explode - разбивает строку по разделителю и преобразует в массив
			//implode — Объединяет элементы массива в строку

			//по этим обьектам мы будем в цикле foreach показывать продукты в зависимости от выбранного режима сортировки
			// для работы в режиме new 
 			if ($unserialize_cookie == 'new' ){
 				$paid_orders_users_new = mysqli_query($products_lesson_6, "SELECT * FROM `paid_orders` INNER JOIN `users` ON `users`.`id` = `paid_orders`.`id_users` ORDER BY `id_paid_orders` DESC LIMIT {$start_valid_db} , {$limit_elements_valid_db}");

 				foreach ($paid_orders_users_new as $key => $value) {
					// echo'<pre>';
					// print_r($value);
					// echo'</pre>';
					$id_products_array[] = $value['id_products'];
					$id_products_array_explode[] = explode(",", $id_products_array[$key]);
					$id_count_array[] = $value['count_products'];
					$id_count_array_explode[] = explode(",", $id_count_array[$key]);

				}

			// для работы в режиме old 
 			}elseif ($unserialize_cookie == 'old' ){
 				$paid_orders_users_old = mysqli_query($products_lesson_6, "SELECT * FROM `paid_orders` INNER JOIN `users` ON `users`.`id` = `paid_orders`.`id_users` ORDER BY `id_paid_orders` ASC LIMIT {$start_valid_db} , {$limit_elements_valid_db}");

 				foreach ($paid_orders_users_old as $key => $value) {
					// echo'<pre>';
					// print_r($value);
					// echo'</pre>';
					$id_products_array[] = $value['id_products'];
					$id_products_array_explode[] = explode(",", $id_products_array[$key]);
					$id_count_array[] = $value['count_products'];
					$id_count_array_explode[] = explode(",", $id_count_array[$key]);

				}

 			// для работы в режиме poisk 
 			}elseif ($result_poisk_cookie == 'poisk' ){
 				$paid_orders_users_poisk = mysqli_query($products_lesson_6, "SELECT * FROM `paid_orders`  INNER JOIN `users` ON `users`.`id` = `paid_orders`.`id_users` WHERE `id_paid_orders` IN ('{$id_poisk_cookie}') ORDER BY `id_paid_orders` ");

 				foreach ($paid_orders_users_poisk as $key => $value) {
					// echo'<pre>';
					// print_r($value);
					// echo'</pre>';

					$id_products_array[] = $value['id_products'];
					$id_products_array_explode[] = explode(",", $id_products_array[$key]);
					$id_count_array[] = $value['count_products'];
					$id_count_array_explode[] = explode(",", $id_count_array[$key]);

				}

			//если селектор не установлен
 			}else {
 				$paid_orders_users_new = mysqli_query($products_lesson_6, "SELECT * FROM `paid_orders` INNER JOIN `users` ON `users`.`id` = `paid_orders`.`id_users` ORDER BY `id_paid_orders` DESC LIMIT {$start_valid_db} , {$limit_elements_valid_db}");

 				foreach ($paid_orders_users_new as $key => $value) {
					// echo'<pre>';
					// print_r($value);
					// echo'</pre>';
					$id_products_array[] = $value['id_products'];
					$id_products_array_explode[] = explode(",", $id_products_array[$key]);
					$id_count_array[] = $value['count_products'];
					$id_count_array_explode[] = explode(",", $id_count_array[$key]);

				}
			}


			




			//функция для пагинации
			function MyPagination($count_products , $str){

				//cоздаем массив прямо в цикле foreach который идет от 1 до $count_products 
				//range — Создаёт массив, содержащий диапазон элементов
				
				//условия для того чтобы цифры пагинации показывались максимум 5 цифр
				if ($count_products < 5) {					
					foreach (range(1, $count_products) as $value) {
						echo "<a class='pagination_link' id='$value' href='index.php?page=admin&select=order_edid&str={$value}'>$value</a>";

					}
				}elseif (($count_products > 4)&&($str < 5)) {
					foreach (range(1, 5) as $value) {
						echo "<a class='pagination_link' id='$value' href='index.php?page=admin&select=order_edid&str={$value}'>$value</a>";

					}
				}elseif ((($count_products - 5) < 5)&&($str > 5)) {
					foreach (range($count_products - 4, $count_products) as $value) {
						echo "<a class='pagination_link' id='$value' href='index.php?page=admin&select=order_edid&str={$value}'>$value</a>";

					}
				}elseif (($count_products > 4)&&(($count_products - 5) < 5)&&($str == 5)) {
					foreach (range($str - 2, $count_products) as $value) {
						echo "<a class='pagination_link' id='$value' href='index.php?page=admin&select=order_edid&str={$value}'>$value</a>";

					}
				}elseif (($count_products > 4)&&(($count_products - 5) > 5)&&($str >= 5)&&($str <= ($count_products - 4))) {
					foreach (range($str - 2, $str + 2) as $value) {
						echo "<a class='pagination_link' id='$value' href='index.php?page=admin&select=order_edid&str={$value}'>$value</a>";

					}
				}elseif (($count_products > 4)&&(($count_products - 5) > 5)&&($str > ($count_products - 4))) {
					foreach (range($count_products - 4, $count_products) as $value) {
						echo "<a class='pagination_link' id='$value' href='index.php?page=admin&select=order_edid&str={$value}'>$value</a>";

					}
				}
			}

			mysqli_close($products_lesson_6);
		?>

		<!-- показываем продукты от самого нового если селектор в режиме all -->
		<?php if ($unserialize_cookie == 'new' ): ?>

			<?php foreach ($paid_orders_users_new as $KEY => $value): ?>
			
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







		<!-- показываем продукты от самого старого если селектор в режиме old -->
		<?php elseif ($unserialize_cookie == 'old' ): ?>

	  		<?php foreach ($paid_orders_users_old as $KEY => $value): ?>

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








	  	<!-- показываем продуты по поиску по id -->
		<?php elseif ($result_poisk_cookie == 'poisk'):  ?>
			<?php foreach ($paid_orders_users_poisk as $KEY => $value): ?>

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








		<!-- показываем все карточки если селектор не установлен  -->
		<?php else: ?>
		
			<?php foreach ($paid_orders_users_new as $KEY => $value): ?>
			
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

		<!-- для пагинации -->
		<div class="pagination">
			<?php if($str >= 5): ?>
			<a class="pagination_link_first"  href="index.php?page=admin&select=order_edid&str=1">1</a>
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
	<?php endif; ?>


	







	








<?php endif; ?>

 <!-- СКРИПТ ДЛЯ ОТМЕНЫ АВТОМАТИЧЕСКОГО ПОВТОРНОГО ЗАПОЛНЕНИЯ ФОРМЫ ПОСЛЕ ПЕРЕЗАГРУЗКИ СТРАНИЦЫ-->
<script>
	if ( window.history.replaceState ) {
	window.history.replaceState( null, null, window.location.href );
	}
</script>


