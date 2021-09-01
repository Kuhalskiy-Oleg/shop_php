<?php  
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$poisk_card_products = $_POST['poisk_card_products'] ?? null;
		$count_Err = '';

		function valid_DATA($data) {
			$data = trim($data);             //trim - функция  удаляет пробелы до и после слова но в самом слове пробелы не удаляет
			$data = stripslashes($data);     //stripslashes — Удаляет экранирование символов
			$data = strip_tags($data);       //strip_tags — Удаляет теги HTML и PHP из строки
			$data = htmlspecialchars($data); //htmlspecialchars — Преобразует специальные символы в HTML-сущности
			return $data;
	    }

	    $poisk_card_products_valid = valid_DATA($poisk_card_products);

	    
	    //echo json_encode(['result' => $poisk_card_products_valid ]);
	    if (!empty($poisk_card_products_valid)) {

	    	if(mb_strlen($poisk_card_products_valid) > 15 ){
				$count_Err = "Недопусимая длина count (до 15 символов)";

			}elseif(!preg_match("/^[0-9]+$/",$poisk_card_products_valid)){
				$count_Err = 'введите только цифры без пробелов и символов';

			}else{

				//если ошибок нет то устанавливаем куки
				if (empty($count_Err)) {

					require('../db/link_db.php');

					$id_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($poisk_card_products_valid)));

					$array_poisk_cookie = [];
	    			$array_poisk_cookie[] = ['result' => 'poisk' , 'id' => $id_valid_db];

					//если мы нашли продукт с id введенным пользователем то загрузим его в куки
					$result = mysqli_query($products_lesson_6, "SELECT * FROM `products` WHERE `id` IN ('{$id_valid_db}') ");

					//записываем в result_2 число которое содержится в обьекте(result) в его функции(num_rows)
					$result_2 = $result->num_rows;
					if ($result_2 > 0)  {
						//устанавливаем куки на 4 часа
				    	setcookie("select_card_views", serialize($array_poisk_cookie), time() + 3600 * 4, "/", "php-lavel-1" );
						echo json_encode(['result' => 'succes' ]);
					}else{
						echo json_encode(['result' => 'not_product' , 'count_Err' => 'такого продута ненайдено'  ]);
					}


					mysqli_close($products_lesson_6);


					
				}
			}

			//если есть ошибки то показываем их
			if (!empty($count_Err)) {
				echo json_encode(['result' => 'error' , 'count_Err' => $count_Err  ]);
			}

	
		}else{
			echo json_encode(['result' => 'error' , 'count_Err' => 'введите id товара'  ]);
		}

	}

?>