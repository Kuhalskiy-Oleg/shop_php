<?php 
	session_start();
	
	
	//записываем результат сеессии в product_id_S и делаем из строки массив с разбиением чисел по :
	$product_id_S = $_SESSION['product_id'];
	$product_id_S_array = explode(";", $product_id_S);



	//подключаемся к products_lesson_6
	require('../db/link_db.php');

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



	

	function valid_DATA($data) {
		$data = trim($data);             //trim - функция  удаляет пробелы до и после слова но в самом слове пробелы не удаляет
		$data = stripslashes($data);     //stripslashes — Удаляет экранирование символов
		$data = strip_tags($data);       //strip_tags — Удаляет теги HTML и PHP из строки
		$data = htmlspecialchars($data); //htmlspecialchars — Преобразует специальные символы в HTML-сущности
		return $data;
    }





	if (isset($row)) {
		$array_count = [];
		foreach ($row as  $value) {
			$id = $value['id'];
			$count = $_POST["count_$id"];
			//______________________ПРОВЕРЯЕМ COUNT______________________
		    if (!empty($count)) {

				if(mb_strlen($count) > 4 ){
					$count_Err = "Недопусимая длина count (до 4 символов)";

				}elseif(!preg_match("/^[0-9]+$/",$count)){
					$count_Err = 'введите только цифры без пробелов и символов';

				}elseif($count > 1000 ){
					$count_Err = "Недопусимое число - введите не больше 1000";

				}elseif($count <= 0 ){
					$count_Err = "Недопусимое число - введите больше 0";

				}else{
					//если ошибок нет то делаем проверки над числом и наполняем массив с кол-вом товаров и id клиента
					$count = (int)$count;
					$count_valid = valid_DATA($count);
					$count_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($count_valid)));
					$array_count[] = ['count' => $count_valid_db, 'pruduct_id' => $value['id']  ];
				}
		    }else{
		    	$count_Err = "Это поле обязательно к заполнению";
		    }

			
		}
		
		//если ошибка инициализировано то
		if (isset($count_Err)) {
			echo json_encode([  'count_Err' => $count_Err , 'id' => $row  ]);
			exit;
		}
						    
		

		//проходимся по массиву с выбранными продуктами пользователем и добавляем их в заказ
		foreach ($array_count as  $value) {
			if(mysqli_query($products_lesson_6, " INSERT INTO `order_products` ( `user_id`      ,
																                 `products_id`  ,
																                 `count`        )		         
							 				      VALUES ('{$_SESSION["id"]}'      ,
							 				              '{$value["pruduct_id"]}' ,
							 				              '{$value["count"]}'      ) ")){

				$rezult_add[] =  mysqli_insert_id($products_lesson_6);

				//удаляем сессию с выбранными товарами в корзине чтобы отчистить корзину при успешном формировании заказа
				unset($_SESSION['product_id']);
				
			}else{
				$rezult_error[] =  mysqli_error($products_lesson_6);					
			}
		}

		if (isset($rezult_add)) {
			echo json_encode([ 'succes' => 'succes_add' ,  'login' => $_SESSION['loginn']  ]);
		}elseif(isset($rezult_error)){
			echo json_encode([ 'succes' => 'succes_err' ,'rezult_error' => $rezult_error , 'login' => $_SESSION['loginn']  ]);
		}
		


	}


	


	
	mysqli_close($products_lesson_6);
    







?> 
	