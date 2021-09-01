<?php  
	declare(strict_types=1);
	ini_set('error_reporting', (string)E_ALL);
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	session_start();
	//КОД ДЛЯ ДОБАВЛЕНИЯ В БД тб=paid_orders ОПЛАЧЕННОГО ЗАКАЗА И УДАЛЕНИЯ ИЗ БД тб=order_products ТЕХ ПОЗИЦИЙ ТОВАРОВ КОТОРЫЕ БЫЛИ В ЗАКАЗЕ

	function valid_get($data) {
		$data = trim($data);             //trim - функция  удаляет пробелы до и после слова но в самом слове пробелы не удаляет
		$data = stripslashes($data);     //stripslashes — Удаляет экранирование символов
		$data = strip_tags($data);       //strip_tags — Удаляет теги HTML и PHP из строки
		$data = htmlspecialchars($data); //htmlspecialchars — Преобразует специальные символы в HTML-сущности
		return $data;
    }


  	if ($_SERVER["REQUEST_METHOD"] == "POST") {

             
  		$telephone = $_POST['telephone'] ?? null;
  		$adress = $_POST['adres'] ?? null;
  		$oplata = $_POST['sum'] ?? null;

  		$telephone_err = $adress_err = $oplata_err = '';



  		//______________________ПРОВЕРЯЕМ ТЕЛЕФОН______________________
  		if(empty($telephone)){
  			$telephone_err = "это поле обязательно к заполнению";

  		}elseif(mb_strlen($telephone) > 20 ){
				$telephone_err = "Недопусимая длина строки (до 20 символов)";
 
  		}elseif(!preg_match("/^[+]?[0-9]+$/",$telephone)){
  			$telephone_err = "введите только цифры и один символ +";

  		}else{
  			$telephone_valid = valid_get($telephone) ?? null;
  		}


  		//______________________ПРОВЕРЯЕМ АДРЕС______________________
  		if(empty($adress)){
  			$adress_err = "это поле обязательно к заполнению";

  		}elseif(mb_strlen($adress) > 70 ){
				$adress_err = "Недопусимая длина строки (до 70 символов)";

 		//i - регистронезависимый
  		//u - юникод для работы с текстами
  		}elseif(!preg_match("/^([0-9]|[a-z]|[а-яё]|[., -])+$/iu",$adress)){
  			$adress_err = "введите только буквы и символы . , -";
  		}else{
  			$adress_valid = valid_get($adress) ?? null;
  		}


  		
  		//______________________ПРОВЕРЯЕМ ЦЕНУ______________________
	    if (!empty($oplata)) {
	    	$oplata = str_replace(",",".",$oplata); //заменяем запятую на точку
	    	
			if(mb_strlen($oplata) > 13 ){
				$oplata_err = "Недопусимая длина строки (до 12 символов)";

			//[+-]? один из + или же -
			//^ - начало строки
			//$ - конец строки
			//+  ищем один или более раз (в данном случае цифру с запятой)
			//проверяем, содержит ли число только один знак точка , один знак плюс или мину , и только числа без пробелов если нет то {}
			}elseif(!preg_match("/^[0-9]*[.]?[0-9]+$/",$oplata)){
				$oplata_err = 'введите только цифры без пробелов и символов кроме . и ,';

			}elseif($oplata > 1000000 ){
				$oplata_err = "Недопусимая сумма - введите не больше  1 000 000";

			}elseif($oplata <= 0 ){
				$oplata_err = "Недопусимая сумма - введите больше 0";

			}elseif(!preg_match("/^\d{0,10}(\d{1,10}[.]\d{0,2})?$/", $oplata)){
				$oplata_err = 'введите корректное число';

			}else{
									
				$oplata_valid = valid_get($oplata) ?? null;
				$oplata_valid = (float)$oplata_valid ?? null;
			}
	    }else{
	    	$oplata_err = "Это поле обязательно к заполнению";
	    }



	    if((!empty($telephone_err)) ||
	       (!empty($adress_err))    ||
	   	   (!empty($oplata_err))){

	   	   	echo json_encode(['result'        => 'error_valid' ,
                              'oplata_err'    => $oplata_err   ,
                              'adress_err'    => $adress_err   ,
                              'telephone_err' => $telephone_err
	   	   ]);	
	   	   exit;	

	    }elseif((!empty($telephone_valid)) &&
	            (!empty($adress_valid))    &&
	   	        (!empty($oplata_valid))){


	   	   	if((empty($telephone_err)) &&
		       (empty($adress_err))    &&
		   	   (empty($oplata_err))) {

		   	   	

		   	   	//подключаемся к products_lesson_6
				require('../db/link_db.php');

				//получаем общую сумму заказа
				$to_be_paid = mysqli_query($products_lesson_6, "SELECT  sum(`price` * `count`) as `to_be_paid`  FROM `order_products` INNER JOIN `users` ON `users`.`id` = `order_products`.`user_id` INNER JOIN `products` ON `products`.`id` = `order_products`.`products_id` WHERE `user_id` = {$_SESSION['id']} ");
				//записываем ее в ассоциативный массив
				$to_be_paid = mysqli_fetch_assoc($to_be_paid);

				//делаем у общей цены тип данных float
		   	   	$to_be_paid_two = $to_be_paid['to_be_paid'] ?? null;
		   	   	$to_be_paid_float = (float)$to_be_paid_two ?? null;


	   	   		//если заказ оплачен то добавляем в таблицу paid_orders оплаченный заказ
				if ($oplata_valid === $to_be_paid_float) {
					
										
					//получаем список товаров котрый сделал ползьзователь и создаем отдельную колонку 'total_price' где будем выводить результат умножения кол-во товара на его стоимость
					$all_orders = mysqli_query($products_lesson_6, "SELECT *, `price` * `count` as `total_price` FROM `order_products` INNER JOIN `users` ON `users`.`id` = `order_products`.`user_id` INNER JOIN `products` ON `products`.`id` = `order_products`.`products_id` WHERE `user_id` = {$_SESSION['id']} ");

					//для удаления из таблицы order_products тех строк которые папали в таблицу paid_order
					$count_mysql_array = [];
					//для преобразования всех полученных данных в ассоциативный массив
					$count_mysql_array = mysqli_fetch_all($all_orders , MYSQLI_ASSOC );

					//код для группировки всех count в один столбец через запятую к одному человеку
					$count_products_paid_order = mysqli_query($products_lesson_6, "SELECT `user_id`, GROUP_CONCAT(`count`) as `count` FROM `order_products` WHERE `user_id` = '{$_SESSION['id']}' GROUP BY `user_id`");
					$count_paid_order = mysqli_fetch_assoc($count_products_paid_order);
					//print_r($count_paid_order);


					//код для группировки всех id продуктов в один столбец через запятую к одному человеку
					$paid_order = mysqli_query($products_lesson_6, "SELECT `user_id`, GROUP_CONCAT(`products_id`) as `products_id` FROM `order_products` WHERE `user_id` = '{$_SESSION['id']}' GROUP BY `user_id`");
					$paid_order = mysqli_fetch_assoc($paid_order);
					//echo json_encode(['result'        => $paid_order   ]); 
	   	  			//exit;


					//защищаем бд от иньекций
					$telephone_valid_db = $adress_valid_db = $oplata_valid_db = '';
					$telephone_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($telephone_valid)));
					$adress_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($adress_valid)));
					$oplata_valid_db = mysqli_real_escape_string($products_lesson_6, htmlspecialchars(strip_tags((string)$oplata_valid)));
					// echo json_encode(['result'        => $adress_valid_db  ]); 
	   	//   			exit;

					


					//добавляем оплаченный заказ в бд
					if (mysqli_query($products_lesson_6, "INSERT INTO `paid_orders` (`id_users`       ,
																					 `id_products`    ,
																					 `count_products` ,
																					  `status`        ,
																					  `adres`         ,
																					  `total_cost`    ,
																					  `telephone`     )
																					   
														  VALUES ('{$paid_order["user_id"]}'          ,
														  		  '{$paid_order["products_id"]}'      ,
														  		  '{$count_paid_order["count"]}'      ,
														  		  'Оплачено'                          ,
														  		  '{$adress_valid_db}'                ,
														  		  '{$oplata_valid_db}'                ,
														  		  '{$telephone_valid_db}'             )")) {

						$rezult_add = mysqli_insert_id($products_lesson_6);

						

														  		
						
						//перебираем массив со сборкой заказа и удаляем те позиции котрые были в сборке
						foreach ($count_mysql_array as  $value) {
							if(mysqli_query($products_lesson_6, "DELETE FROM  `order_products` WHERE `order_id` = '{$value['order_id']}' ")){


							}else{
								$mysql_error = mysqli_error($products_lesson_6);
								// echo 
								// "
								// <script>
						  //           alert('при удалении позиций из собранного заказа возникла ошибка ' + $mysql_error);
						  //       </script>
								// ";
							}
						}

						
						echo json_encode(['result'           => 'succes' ,
			                              'oplata_succes'    => "заказ успешно оплачен, ваш номер заказа $rezult_add "  
				   	    ]);	



					}else{
						$mysql_error = mysqli_error($products_lesson_6);
						// echo 
						// "
						// <script>
				  //           alert('при добавлении оплаченного заказа в дб возникла ошибка ' + $mysql_error);
				  //       </script>
						// ";
						echo json_encode(['result'           => 'error_add_item_in_order' ,
			                              'oplata_error'     => "при добавлении оплаченного заказа в дб возникла ошибка $mysql_error "  
				   	    ]);	
					}


					mysqli_close($products_lesson_6);
					
				}else{

					echo json_encode(['result'        => 'sum_no_sovpad' ,
		                              'oplata_err'    => 'введенная вами сумма не совпадает с суммой "к оплате"'   

			   	   ]);	
			   	   exit;
				}

	   	   	}

	    }
	
  	}



?>