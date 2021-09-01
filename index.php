<?php 
	declare(strict_types=1);
	ini_set('error_reporting', (string)E_ALL);
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	ini_set ('session.cookie_lifetime', '0');//чтобы сеансовые куки удалялась после закрытия браузера
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
	

		<?php 
			//cоздаем переменную и помещаем в нее массив $_GET[] с ключем "page"
			$page = $_GET['page'] ?? null;
			$activ_index = $activ_shop = $activ_basket = $activ_registr = $activ_entrance = '';

			//код для подсветки навигационного меню
			if(!isset($page)){

				$activ_index = 'activ';
				
			}elseif($page == 'shop') {

				$activ_shop = 'activ';

			}elseif($page == 'admin') {

				$activ_entrance = 'activ';

			}elseif($page == 'basket') {

				$activ_basket = 'activ';

			}elseif($page == 'registration') {

				$activ_registr = 'activ';

			}elseif($page == 'product'){

				$activ_shop = 'activ';
			}
		?>


		<!-- шапка фиксированная -->
		<div class="head_intro_osnovnoy LockPadding">

			<div class="nav_panel_left">

				<nav class="nav">

					<ul class="nav_list"><!-- правильно будет использовать тег ul со списком навигации -->

						<li class="nav_list_item">
							<a class="item_nav_header button_nav <?=$activ_index?>" href="index.php">Главная</a>						
						</li>

						<li class="nav_list_item">
							<a class="item_nav_header button_nav <?=$activ_shop?>" href="index.php?page=shop">Магазин</a>
						</li>

						<li class="nav_list_item">
							<a class="item_nav_header button_nav <?=$activ_basket?>" href="index.php?page=basket">Корзина</a>
						</li>


					</ul>
					
				</nav>

			</div>

			<div class="nav_panel_right">

				<nav class="nav">

					<ul class="nav_list">

						<li class="nav_list_item">
							<a class="item_nav_header button_nav <?=$activ_registr?>" href="index.php?page=registration">Регистрация</a>
						</li>

						<li class="nav_list_item">
							<a class="item_nav_header button_nav <?=$activ_entrance?>" href="index.php?page=admin"><?= (($_SESSION['loginn'] ?? null) ? $_SESSION['loginn'] : 'войти') ?></a>
						</li>

					</ul>
					
				</nav>

			</div>

		</div>



		<div class="head_intro_mini LockPadding">

			<nav>

				<button class="burger"   type="button">
					<span class="palka"></span>
				</button>


				<li class="nav_list_item">

					<button class="button_nav strelka" type="button">Меню</button>

					<ul class="open_list">
						<li class="open_list_items">
							<a class="item_nav_header button_nav" href="index.php">Главная</a>	
						</li>

						<li class="open_list_items">
							<a class="item_nav_header button_nav" href="index.php?page=shop">Магазин</a>
						</li>

						<li class="open_list_items">
							<a class="item_nav_header button_nav" href="index.php?page=registration">Регистрация</a>
						</li>

						<li class="open_list_items">
							<a class="item_nav_header button_nav" href="index.php?page=admin"><?= (($_SESSION['loginn'] ?? null) ? $_SESSION['loginn'] : 'войти') ?></a>
						</li>

						<li class="open_list_items">
							<a class="item_nav_header button_nav" href="index.php?page=basket">Корзина</a>
						</li>
					</ul>
				</li>

			</nav>
		
		</div>


		<!-- для сайтбара используем специальный тег aside -->
		<div class="maska_sidebar LockPadding">
			<aside class="sidebar" id="accardion" >
				
				<!-- разбиваем сайт бар на три части шапку - контент -подвал -->
				<div class="sidebar_headr">
					<img src="assets/images/sitebar/header_sidebar.jpg" alt="">
				</div>



				<!-- для сайтбара используем container так же как и для ранее написанных сайтов -->
				<div class="container_saidbar">



				</div>
			</aside>
		</div>

		<main class="main LockPadding">
			<div class="container">

				<?php 

					//mysqli_select_db — Выбирает базу данных MySQL

					//подключаемся к phpmyadmin
					require('assets/php/db/link_db.php');
					
					$tabl_products = mysqli_query($products_lesson_6, "SELECT * FROM `products` ");

					mysqli_close($products_lesson_6);

					const IMG_DIR = 'assets/images/';

					

					//делаем проверку на инициализацию  $_GET['page'] если в поисковой строке будет обьявлена пара ключ-значение то мы скроем галерею фотографий если нет то покажем галерею
					if(!isset($page)){

						require('pages/main.php');
						
					}elseif($page == 'shop') {

						require('pages/shop.php');

					}elseif($page == 'admin') {

						require('pages/admin.php');

					}elseif($page == 'basket') {

						require('pages/basket.php');

					}elseif($page == 'registration') {

						require('pages/registration.php');

					}elseif($page == 'product'){

						//cоздаем вторую суперглобальную переменную  и помещаем в нее массив с ключем "id"
						$id = $_GET['id'];

						//создаем пустой массив который в дальнейшим мы наполним нужным элементом из массива с продуктами
						$open_product = [];

						foreach ($tabl_products as $value) {

							//если индекс элемента совпадает со значением ключа "id" из $_GET[] то мы загрузим в  $open_product[] нужные данные о конкретном продукте 
							if ($value['id'] == $id) {
								$open_product[] = $value;
								break;
							}
						}
						require('pages/open_product.php');

					}


				?>


			</div>

			<footer>	
				<div class="container">			
					<h3 class="Footer">Footer</h3>
				</div>
			</footer>


		</main>

		
		
		


	

	<!-- для редактирования карточек -->
	<script type="text/javascript" src="assets/js/add_update_delete_card/ajax_add_card.js"></script>
	<script type="text/javascript" src="assets/js/add_update_delete_card/ajax_update_card.js"></script>



	<!-- для регистрации и авторизации -->
	<script type="text/javascript" src="assets/js/registration_avtorization/ajax_registration_avtorization.js"></script>




	<!-- для заполнения таблицы order_products теми товарами которые были в корзине -->
	<script type="text/javascript" src="assets/js/order/add_items_for_basket_in_order.js"></script>

	<!-- для редактирования кол-ва товара в режиме сборка заказа -->
	<script type="text/javascript" src="assets/js/order/edit_position_order.js"></script>

	<!-- для добавления товара в корзину -->
	<script type="text/javascript" src="assets/js/shop/add_korzina_ajax.js"></script>

	<!-- для удаления позиции из корзины -->
	<script type="text/javascript" src="assets/js/order/delete_elem_korz.js"></script>

	<!-- для добавления оплаченного заказа в бд в таблицу paid_orders -->
	<script type="text/javascript" src="assets/js/order/add_item_zakaz_for_products_order_in_paid_order.js"></script>

	<!-- для удаления позиции из заказа в режиме сборка из таблицы order_products -->
	<script type="text/javascript" src="assets/js/order/delete_elem_for_order_products_sborka.js"></script>



	<!-- для выбора режима отображения товара на странице магазин shop-->
	<script type="text/javascript" src="assets/js/shop/selectes_card_views.js"></script>
	<script type="text/javascript" src="assets/js/shop/select_card_poisk.js"></script>

	<!-- для выбора режима отображения товара на странице магазин admin-->
	<script type="text/javascript" src="assets/js/admin/select_edit_card/selectes_card_views.js"></script>
	<script type="text/javascript" src="assets/js/admin/select_edit_card/select_card_poisk.js"></script>

	<!-- для выбора режима отображения заказа на странице магазин admin-->
	<script type="text/javascript" src="assets/js/admin/select_order/selectes_card_views.js"></script>
	<script type="text/javascript" src="assets/js/admin/select_order/select_card_poisk.js"></script>


	<!-- попапы -->
	<script type="text/javascript" src="assets/js/shop/popap_auto_padding.js"></script>

	<!-- cайтбар -->
	<script type="text/javascript" src="assets/js/sitebar/logic_portfolio.js"></script>

</body>
</html>






































