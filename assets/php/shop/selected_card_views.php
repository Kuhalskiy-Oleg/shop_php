<?php  
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$select = $_POST['select'] ?? null;

		function valid_DATA($data) {
			$data = trim($data);             //trim - функция  удаляет пробелы до и после слова но в самом слове пробелы не удаляет
			$data = stripslashes($data);     //stripslashes — Удаляет экранирование символов
			$data = strip_tags($data);       //strip_tags — Удаляет теги HTML и PHP из строки
			$data = htmlspecialchars($data); //htmlspecialchars — Преобразует специальные символы в HTML-сущности
			return $data;
	    }

	    $select_valid = valid_DATA($select);


	    if (isset($select_valid)) {
	    	//устанавливаем куки на 4 часа
	    	setcookie("select_card_views", serialize($select_valid), time() + 3600 * 4, "/", "php-lavel-1" );
			echo json_encode(['result' => 'succes']);
		}

	}

?>