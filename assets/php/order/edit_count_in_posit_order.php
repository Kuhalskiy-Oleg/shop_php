<?php  

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
           

		function valid_get($data) {
			$data = trim($data);             //trim - функция  удаляет пробелы до и после слова но в самом слове пробелы не удаляет
			$data = stripslashes($data);     //stripslashes — Удаляет экранирование символов
			$data = strip_tags($data);       //strip_tags — Удаляет теги HTML и PHP из строки
			$data = htmlspecialchars($data); //htmlspecialchars — Преобразует специальные символы в HTML-сущности
			return $data;
	    }

		$edit_count_posit = $_POST['edit_count_posit'] ?? null;
		$value_order_id = $_POST['value_order_id'] ?? null;
		$value_order_id_valid = valid_get($value_order_id);

		$count_Err = '';
		$rezult = '';

		


		//______________________ПРОВЕРЯЕМ COUNT______________________
	    if ($edit_count_posit != '') {

	    	if (!empty($edit_count_posit)) {
	    			
	    		if(mb_strlen($edit_count_posit) > 4 ){
					$count_Err = "Недопусимая длина count (до 4 символов)";

				}elseif(!preg_match("/^[0-9]+$/",$edit_count_posit)){
					$count_Err = 'введите только цифры без пробелов и символов';

				}elseif($edit_count_posit > 1000 ){
					$count_Err = "Недопусимое число - введите не больше 1000";

				}elseif($edit_count_posit <= 0 ){
					$count_Err = "Недопусимое число - введите больше 0";

				}else{
					//если ошибок нет то делаем проверки над числом и наполняем массив с кол-вом товаров и id клиента
					$edit_count_posit = (int)$edit_count_posit;
					$edit_count_posit_valid = valid_get($edit_count_posit);
					
				}

	    	}else{
	    		$count_Err = "Недопусимое число - введите больше 0";
	    	}
		
	    }else{
	    	$count_Err = "Это поле обязательно к заполнению";
	    }


	    if (!empty($count_Err)) {
	 
	    	echo json_encode([
								'rezult_valid'     => 'error',
								'rezult_count_Err' => $count_Err
			]);
			exit;
	    	
	    }



	    if (empty($count_Err)) {
	    	if ((isset($edit_count_posit)) && (isset($value_order_id))) {



	    		//подключаемся к products_lesson_6
				require('../db/link_db.php');

				$edit_count_posit_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($edit_count_posit_valid)));
				$value_order_id_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($value_order_id_valid)));

				if (mysqli_query($products_lesson_6, " UPDATE `order_products` SET `count`  = '{$edit_count_posit_valid_db}' 
				                                       WHERE `order_id` IN  ('{$value_order_id_valid_db}')  ")) {

					
				
					echo json_encode([
										'rezult' => 'succes'
					]);
				}else{
					$rezult = mysqli_error($products_lesson_6);
					echo json_encode([
										'rezult'       => 'error',
										'error_my_sql' => $rezult
					]);
				}


				mysqli_close($products_lesson_6);
				

				
				

				
	    	}
	    }
	    
	}











?>