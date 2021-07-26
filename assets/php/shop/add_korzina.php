<?php  
	session_start();
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
		$product_ID = $_POST['product_ID'] ?? null;

		function valid_DATA($data) {
			$data = trim($data);             //trim - функция  удаляет пробелы до и после слова но в самом слове пробелы не удаляет
			$data = stripslashes($data);     //stripslashes — Удаляет экранирование символов
			$data = strip_tags($data);       //strip_tags — Удаляет теги HTML и PHP из строки
			$data = htmlspecialchars($data); //htmlspecialchars — Преобразует специальные символы в HTML-сущности
			return $data;
	    }

	    $product_ID_valid = valid_DATA($product_ID);


	    if (isset($product_ID_valid)) {
			

			//если сессия = null то вначале наполняем ее пустой строкой чтобы к этой пустой строке приклеивались id товаров
			if (!isset($_SESSION['product_id'])) {
				//инициализируем сессию product_id и cначала присваиваем ей пустую строку а далее наполняем ее id товаров
				$_SESSION['product_id'] = '';
				$_SESSION['product_id']  .= $_POST['product_ID'].';';
			//если сессия уже инициализирована то приклеиваем к ней id товаров
			}else{
				$_SESSION['product_id']  .= $_POST['product_ID'].';';
			}

				
			
		}

	}

?>