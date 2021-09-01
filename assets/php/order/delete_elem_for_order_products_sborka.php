<?php  
 
	// declare(strict_types=1);
	// ini_set('error_reporting', (string)E_ALL);
	// ini_set('display_errors', '1');
	// ini_set('display_startup_errors', '1');


	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$id_pozition_order_items = $_POST['position_items_order'] ?? null;

		//echo json_encode(['sss' => 'sss']);

		function valid_get($data) {
			$data = trim($data);             //trim - функция  удаляет пробелы до и после слова но в самом слове пробелы не удаляет
			$data = stripslashes($data);     //stripslashes — Удаляет экранирование символов
			$data = strip_tags($data);       //strip_tags — Удаляет теги HTML и PHP из строки
			$data = htmlspecialchars($data); //htmlspecialchars — Преобразует специальные символы в HTML-сущности
			return $data;
	    }

	    $id_pozition_order_items_valid = valid_get($id_pozition_order_items) ?? null;


		

		//подключаемся к products_lesson_6
		require('../db/link_db.php');

		$id_pozition_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($id_pozition_order_items_valid)));

		if(mysqli_query($products_lesson_6, "DELETE FROM  `order_products` WHERE `order_id` = '{$id_pozition_valid_db}' ")){
			echo json_encode([ 'result' => 'succes'              , 
								'id'    => $id_pozition_valid_db]);
		}else{
			$mysql_error = mysqli_error($products_lesson_6);
			echo json_encode([ 'result'      => 'error'       ,
							   'mysql_error' => $mysql_error]);
		}

		mysqli_close($products_lesson_6);

	}

?>