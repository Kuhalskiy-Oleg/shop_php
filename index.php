<?php 
	declare(strict_types=1);
	ini_set('error_reporting', (string)E_ALL);
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Document</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="assets/style/style.css">
	<meta name="google" content="notranslate"/>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
	<!-- подключаем иконски с сайта font awesom -->
    <script type="text/javascript" src="https://kit.fontawesome.com/441e03a245.js" crossorigin="anonymous"></script>

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
	        			<a class="item_nav_header" href="index.php?page=admin"><?= (($_SESSION['loginn'] ?? null) ? 'личный кабинет' : 'войти') ?></a>
	        			<a class="item_nav_header" href="index.php?page=order">Корзина</a>
	        		</nav>	        	
		        </div>  
			</header>
		</div>


		<main>
			<div class="container">

				<?php 

					//mysqli_select_db — Выбирает базу данных MySQL

					//подключаемся к phpmyadmin
					require('assets/php/db/link_db.php');
					
					$tabl_products = mysqli_query($products_lesson_6, "SELECT * FROM `products` ");

					mysqli_close($products_lesson_6);

					const IMG_DIR = 'assets/images/';

					//cоздаем переменную и помещаем в нее массив $_GET[] с ключем "page"
					$page = $_GET['page'] ?? null;

					//делаем проверку на инициализацию  $_GET['page'] если в поисковой строке будет обьявлена пара ключ-значение то мы скроем галерею фотографий если нет то покажем галерею
					if(!isset($page)){

						require('pages/main.php');
						
					}elseif($page == 'shop') {

						require('pages/shop.php');

					}elseif($page == 'admin') {

						require('pages/admin.php');

					}elseif($page == 'order') {

						require('pages/order.php');

					}elseif($page == 'registration') {

						require('pages/registration.php');
					
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
						require('pages/open_img.php');

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
						require('pages/open_product.php');

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
	<script type="text/javascript" src="assets/js/order/edit_position_order.js"></script>
	<script type="text/javascript" src="assets/js/shop/add_korzina_ajax.js"></script>
	<script type="text/javascript" src="assets/js/order/delete_elem_korz.js"></script>

</body>
</html>






































