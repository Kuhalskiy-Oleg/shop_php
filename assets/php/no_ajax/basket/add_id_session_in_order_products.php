<?php 
	//КОД ДЛЯ ОТОБРАЖЕНИЯ ТЕХ ПРОДУКТОВ В КОРЗИНЕ КОТРЫЕ ВЫБРАЛ ПОЛЬЗОВАТЕЛЬ В МАГАЗИНЕ

	function valid_get($data) {
		$data = trim($data);             //trim - функция  удаляет пробелы до и после слова но в самом слове пробелы не удаляет
		$data = stripslashes($data);     //stripslashes — Удаляет экранирование символов
		$data = strip_tags($data);       //strip_tags — Удаляет теги HTML и PHP из строки
		$data = htmlspecialchars($data); //htmlspecialchars — Преобразует специальные символы в HTML-сущности
		return $data;
    }
	$elemm = $_GET['elem'] ?? null;
	$elem = valid_get($elemm);

	//удаление всех элементов id продуктов из сессии
	if ($elem == 'del_order') {
		unset($_SESSION['product_id']);
		echo 
		"
		<script>
            window.location.href = \"index.php?page=basket\"; 
        </script>
		";
	}


	
	


	

	//смотрим на элементы id товаров выбранные пользователем в магазины
	//echo $_SESSION['product_id'] ?? null;

	//записываем результат сеессии в product_id_S  
	$product_id_S_tranzit = $_SESSION['product_id'] ?? null;

	//делаем из строки - массив с разбиением чисел по ; и записываем это в массив massiv_tranzit_product_id_S
	$massiv_tranzit_product_id_S = [];
	$massiv_tranzit_product_id_S = explode(";", $product_id_S_tranzit);

	//удаляем последний пустой элемнт в массиве
	array_pop($massiv_tranzit_product_id_S);

	// echo('<br><pre>');
	// print_r($massiv_tranzit_product_id_S);
	// echo('</pre><br>');

	//удаляем повторяющиеся элементы массива
	$massiv_tranzit_product_id_S = array_unique($massiv_tranzit_product_id_S);


	// echo('<br><pre>');
	// print_r($massiv_tranzit_product_id_S);
	// echo('</pre><br>');


	//разбиваем массив в строку с разделнеием по ;
	$product_id_S_array_tranzit = implode(";", $massiv_tranzit_product_id_S);
	//дописываем к последнему id знак ;
	if ($product_id_S_array_tranzit != '') {
		$product_id_S_array_tranzit .= ';';
	}

	// echo('<br>');
	// echo($product_id_S_array_tranzit);
	// echo('<br>');
	

	//перезаписываем сессию теми значениями у которых нет дубликатов
	$_SESSION['product_id'] = $product_id_S_array_tranzit;
	//записываем обновленный результат сеессии в product_id_S  
	$product_id_S = $_SESSION['product_id'] ?? null;


	//echo $_SESSION['product_id'] ?? null;


	//делаем из строки массив с разбиением по ;
	$product_id_S_array = explode(";", $product_id_S);
	array_pop($product_id_S_array);

	// echo('<br><pre>');
	// print_r($product_id_S_array);
	// echo('</pre><br>');
	

	//подключаемся к products_lesson_6
	require('assets/php/db/link_db.php');

	$row = [];
	$tabl_products = [];

	//наполняем массив данными по тем карточкам которые есть в сессии
	foreach ($product_id_S_array as $key => $value) {
		$tabl_products[] =  mysqli_query($products_lesson_6, "SELECT * FROM `products` WHERE `id` = '{$value}'  ");
		$row[] = mysqli_fetch_assoc($tabl_products[$key]);	
	}

	// $row =  mysqli_fetch_all(
 //            mysqli_query($products_lesson_6, "SELECT * FROM `products` WHERE `id` IN (" . implode(",", $product_id_S_array) .")")
 //            );
         



	//удаляем дубликаты карточек из массива
	$row = array_unique($row,SORT_REGULAR);//SORT_REGULAR - для удаления дубликатов в ассоциативном массиве
	//var_dump($row);
	// echo('<pre>');
	// print_r($row);
	// echo('</pre>');
	mysqli_close($products_lesson_6);

?>