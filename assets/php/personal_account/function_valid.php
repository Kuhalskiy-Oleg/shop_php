<?php  

	//preg_replace — Выполняет поиск и замену по регулярному выражению
	//mb_eregi_replace — Осуществляет замену по регулярному выражению с поддержкой многобайтовых символов без учёта регистра
	//mb_ereg_replace — Осуществляет замену по регулярному выражению с поддержкой многобайтовых кодировок
	//[\s]	любой пробельный символ
	//[0-9]	любой числовой символ
	function valid_name_family($data) {
		$data = trim($data);                                    //trim - функция  удаляет пробелы до и после слова но в самом слове пробелы не удаляет
		$data = stripslashes($data);                            //stripslashes — Удаляет экранирование символов
		$data = mb_eregi_replace('[0-9]', '', $data);           //Удалить цифры
		$data = mb_eregi_replace('[\s]' , '', $data);           //Удалить все пробелы
		$data = mb_eregi_replace ('[^а-яёА-ЯЁA-Z]', '', $data); //Удалить все Кроме букв 
		$data = htmlspecialchars($data);                        //htmlspecialchars — Преобразует специальные символы в HTML-сущности
		return $data;
    }


    function valid_login_password($data) {
    	$data = trim($data);                                          //trim - функция  удаляет пробелы до и после слова но в самом слове пробелы не удаляет
		$data = stripslashes($data);                                  //stripslashes — Удаляет экранирование символов
		$data = mb_eregi_replace('[№;:#$?[}<+=>{]!%^&*\/`"\']', '', $data); //Удалить символы
		$data = mb_eregi_replace('[\s]' , '', $data);                 //Удалить все пробелы
		$data = htmlspecialchars($data);                              //htmlspecialchars — Преобразует специальные символы в HTML-сущности
		return $data;
    }


    function valid_email($data) {
		$data = trim($data);             //trim - функция  удаляет пробелы до и после слова но в самом слове пробелы не удаляет
		$data = stripslashes($data);     //stripslashes — Удаляет экранирование символов
		$data = htmlspecialchars($data); //htmlspecialchars — Преобразует специальные символы в HTML-сущности
		return $data;
    }





?>