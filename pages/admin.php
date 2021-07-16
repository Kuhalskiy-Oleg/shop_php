








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


<?php if($_SESSION['loginn'] == '12345'): ?>


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

			
			$db_lesson_6_php = mysqli_connect("127.0.0.1", "root", "root", "products_lesson_6" , 3307) or die ("НЕ УДАЛОСЬ ПОДКЛЮЧИТСЯ К БАЗЕ ДАННЫХ");
			$tabl_products = mysqli_query($db_lesson_6_php, "SELECT * FROM `products` ");
			mysqli_close($db_lesson_6_php);
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
<form action="index.php?page=admin" method="post">
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

		if ( is_file(IMG_DIR . $file)) {

			//strtolower — Преобразует строку в нижний регистр
			$file = strtolower($file);

			if ((pathinfo($file, PATHINFO_EXTENSION) == 'jpg')  || 
				(pathinfo($file, PATHINFO_EXTENSION) == 'jpeg') || 
				(pathinfo($file, PATHINFO_EXTENSION) == 'png'))  {

				$img[] = [

					'name_img'  =>  pathinfo($file, PATHINFO_BASENAME)
				];

			}

		}

	}
	// echo "изображения в папке " . IMG_DIR;
	// echo "<pre><br>";
	// print_r($img);
	// echo "</pre><br>";

	

	//подключаемся к бд
	$db_lesson_6_php = mysqli_connect("127.0.0.1", "root", "root", "products_lesson_6" , 3307) or die ("НЕ УДАЛОСЬ ПОДКЛЮЧИТСЯ К БАЗЕ ДАННЫХ");

	//вывести все из бызы данных $mysql из таблицы userd
	$tabl_products = mysqli_query($db_lesson_6_php, "SELECT * FROM `products` ");

	

	
	//проходимся по двум массивом и удаляем из массива $img те элементы  , которые уже есть в базе данных для того чтобы не загружать в бд то что уже там есть (хоть в бд и стоит проверка на уникальность)
	foreach ($img as $key =>  $value) {

		foreach ($tabl_products as  $tabl_products_items) {

			//strtolower — Преобразует строку в нижний регистр
			$tabl_products_items['name_img'] = strtolower($tabl_products_items['name_img']);

			if ($tabl_products_items['name_img'] == $value['name_img']) {
				
				unset($img[$key] );
				
			}
			
		}

	}

	
	//echo "ПОСЛЕ сортировки по совпадению одинаковых картинок в массивах img и БД";
	echo "картинки которых нет в БД:";
	echo "<pre><br>";
	print_r($img);
	echo "</pre><br>";

	$dell_img = $_POST['dell_img'];

	if ($dell_img == 'yes') {
	
		foreach ($img as $file) {

			unlink(IMG_DIR . $file['name_img']);

		}
	}

	mysqli_close($db_lesson_6_php);

	
?>




<?php endif; ?>

