<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Document</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="assets/style/style.css">
	<meta name="google" content="notranslate"/>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>

</head>
<body>
	<div class="wrapper">

		<div class="container">
			<header>
				<div class="header_home">
		        	<h1 class="CompanyName">Company name</h1>		        	
	        		<nav class="nav_header">
	        			<a class="item_nav_header" href="index.php">Главная</a>
	        			<a class="item_nav_header" href="index.php?page=shop">Магазин</a>
	        			<a class="item_nav_header" href="index.php?page=registration">Регистрация</a>
	        			<a class="item_nav_header" href="index.php?page=admin"><?= ($_SESSION['loginn'] ? 'личный кабинет' : 'войти') ?></a>
	        			<a class="item_nav_header" href="index.php?page=order">Корзина</a>
	        		</nav>	        	
		        </div>  
			</header>
		</div>


		<main>
			<div class="container">

				<?php 

					//mysqli_select_db — Выбирает базу данных MySQL
					//mysqli_fetch_row — Обрабатывает ряд результата запроса и возвращает массив с числовыми индексами

					//КОД ДЛЯ СОЗДАНИЯ БД И ТАБЛИЦ

					//подключаемся к phpmyadmin
					$phpmyadmin = mysqli_connect("127.0.0.1", "root", "root"  ) or die ("НЕ УДАЛОСЬ ПОДКЛЮЧИТСЯ К БАЗЕ ДАННЫХ");

					//cоздаем базу данных
					//mysqli_query($phpmyadmin,"CREATE SCHEMA `products_lesson_6` ");




					//получаем имя текущей базы данных по умолчанию
					$result = mysqli_query($phpmyadmin, "SELECT DATABASE()");
					$row = mysqli_fetch_row($result);
					//print_r("База данных по умолчанию: " . $row[0]);

					//echo "<br>";
					mysqli_select_db($phpmyadmin, "products_lesson_6");

					//получаем имя текущей базы данных по умолчанию
					$result = mysqli_query($phpmyadmin, "SELECT DATABASE()");
					$row = mysqli_fetch_row($result);
					//print_r("База данных по умолчанию: " . $row[0]);





					// mysqli_query($phpmyadmin,"ALTER SCHEMA `products_lesson_6`  DEFAULT CHARACTER SET utf8mb4 ");
					// mysqli_query($phpmyadmin,"ALTER SCHEMA `products_lesson_6`  DEFAULT COLLATE  utf8mb4_general_ci ");


					// mysqli_query($phpmyadmin,"CREATE TABLE `products` (
					// 	`id`          INT NOT NULL ,
					// 	PRIMARY KEY (`id`),
					// 	UNIQUE INDEX `id_products_UNIQUE` (`id` ASC) VISIBLE,
					// 	`brand`       VARCHAR(30)   NOT NULL,
					// 	`description` VARCHAR(10000)NOT NULL,
					// 	`model`		  VARCHAR(100)  NOT NULL,
					// 	`color`       VARCHAR(100)  NULL,
					// 	`price`       DECIMAL(10,2) NOT NULL,
					// 	`name_img`    VARCHAR(100)  NOT NULL,
					// 	`views`       INT           NOT NULL DEFAULT 0,
					// 	`date_create` DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
					// 	`date_update` DATETIME      NULL)
					// 	ENGINE = InnoDB DEFAULT CHARACTER SET =  utf8mb4 COLLATE utf8mb4_general_ci;");

					// mysqli_query($phpmyadmin,"ALTER TABLE `products` CHANGE `id` `id` INT NOT NULL AUTO_INCREMENT;");
					// mysqli_query($phpmyadmin,"ALTER TABLE `products` CHANGE `description` `description` VARCHAR(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;");

					// mysqli_query($phpmyadmin,"CREATE TABLE `order` (
					// 	`user_id`     INT(100) NOT NULL ,
					// 	PRIMARY KEY (`user_id`)         ,
					// 	`products_id` INT(100) NOT NULL ,
					// 	`count`       INT(10) NOT NULL  )
					// 	ENGINE = InnoDB DEFAULT CHARACTER SET =  utf8mb4 COLLATE utf8mb4_general_ci;");
					// mysqli_query($phpmyadmin,"ALTER TABLE `order` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT;");
					// mysqli_query($phpmyadmin,"ALTER TABLE `order` ADD FOREIGN KEY (`products_id`) REFERENCES `products`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;");
					// mysqli_query($phpmyadmin,"ALTER TABLE `products_lesson_6`.`order` DROP PRIMARY KEY, ADD PRIMARY KEY (`user_id`, `products_id`) USING BTREE;");


					// mysqli_query($phpmyadmin,"CREATE TABLE `usersS` (
					//  	`id`          INT NOT NULL AUTO_INCREMENT            ,
					//  	PRIMARY KEY (`id`)                                   ,
					//  	UNIQUE INDEX `id_products_UNIQUE` (`id` ASC) VISIBLE ,       
					//  	`name`        VARCHAR(50) NOT NULL                   ,
					//  	`family`      VARCHAR(50) NOT NULL                   ,
					//  	`login`       VARCHAR(30) NOT NULL                   ,
					//  	`telephone`   VARCHAR(30) NULL DEFAULT NULL          ,
					//  	`email`       VARCHAR(100)NOT NULL                   ,
					//  	`password`    VARCHAR(300)NOT NULL                   ,
					//  	`date_create` DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
					//  	`date_update` DATETIME    NULL                              )
					//  	ENGINE = InnoDB DEFAULT CHARACTER SET =  utf8mb4 COLLATE utf8mb4_general_ci;");
					// mysqli_query($phpmyadmin,"ALTER TABLE `products_lesson_6`.`userss` ADD UNIQUE `login_UNIQUE` (`login`);");
					// mysqli_query($phpmyadmin,"ALTER TABLE `products_lesson_6`.`userss` ADD UNIQUE `password_UNIQUE` (`password`);");


					


					//}else{
					//	echo mysqli_error($phpmyadmin);
					//}



					
					$tabl_products = mysqli_query($phpmyadmin, "SELECT * FROM `products` ");


					// $old_name_img = mysqli_query($phpmyadmin, " SELECT `name_img` FROM `products` WHERE `id` IN (2) ");
					// //удаляем cтарую картинку т.к запись в бд  удалась 
					// $row = mysqli_fetch_assoc($old_name_img);
					// unlink(IMG_DIR . $row['name_img'] );
					


					mysqli_close($phpmyadmin);



					const IMG_DIR = 'assets/images/';

					//cоздаем переменную и помещаем в нее массив $_GET[] с ключем "page"
					$page = $_GET['page'];

					//делаем проверку на инициализацию  $_GET['page'] если в поисковой строке будет обьявлена пара ключ-значение то мы скроем галерею фотографий если нет то покажем галерею
					if(!isset($page)){

						include('pages/main.php');
						
					}elseif($page == 'shop') {

						include('pages/shop.php');

					}elseif($page == 'admin') {

						include('pages/admin.php');

					}elseif($page == 'order') {

						include('pages/order.php');

					}elseif($page == 'registration') {

						include('pages/registration.php');
					
					//если у ключа значение будет = 'img' то покажем страницу с выбранной фотографией 
					}elseif($page == 'img') {

						//cоздаем вторую суперглобальную переменную  и помещаем в нее массив с ключем "id"
						$id = $_GET['id'];

						//создаем пустой массив который в дальнейшим мы наполним нужным элементом из массива с путями к фотографиям
						$open_img = [];

						foreach ($tabl_products as $value) {

							//если индекс элемента совпадает со значением ключа "id" из $_GET[] то мы загрузим в  $open_img[] нужный путь к картинке котоый в дальнейшим передадим в атрибут src у тега img на новой странице
							if ($value['id'] == $id) {
								$open_img[] = $value;
								break;
							}
						}
						include('pages/open_img.php');
					}elseif($page == 'product'){

						//cоздаем вторую суперглобальную переменную  и помещаем в нее массив с ключем "id"
						$id = $_GET['id'];

						//создаем пустой массив который в дальнейшим мы наполним нужным элементом из массива с путями к фотографиям
						$open_product = [];

						foreach ($tabl_products as $value) {

							//если индекс элемента совпадает со значением ключа "id" из $_GET[] то мы загрузим в  $open_img[] нужный путь к картинке котоый в дальнейшим передадим в атрибут src у тега img на новой странице
							if ($value['id'] == $id) {
								$open_product[] = $value;
								break;
							}
						}
						include('pages/open_product.php');

					}


				?>


			</div>


		</main>

		
		<footer>	
			<div class="container">			
				<h3 class="Footer">Footer</h3>
			</div>
		</footer>
		


	</div>

	<script type="text/javascript" src="assets/js/add_update_delete_card/ajax_add_card.js"></script>
	<script type="text/javascript" src="assets/js/add_update_delete_card/ajax_update_card.js"></script>
	<script type="text/javascript" src="assets/js/registration_avtorization/ajax_registration_avtorization.js"></script>
	<script type="text/javascript" src="assets/js/order/ajax_order.js"></script>

</body>
</html>






































