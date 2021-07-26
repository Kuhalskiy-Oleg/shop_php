<?php  
	date_default_timezone_set("Asia/Yekaterinburg");
	const IMG_DIR = '../../../assets/images/';

	$value_brand       = $_POST['value_brand'];
	$value_discription = $_POST['value_discription'];
	$value_model       = $_POST['value_model'];
	$value_color       = $_POST['value_color'];
	$value_price       = $_POST['value_price'];
	$id_card           = $_POST['id_card'];
	$radio_no          = $_POST['radio_no'];
	$delete            = $_POST['delete_2'];

	$date_time = date("Y-m-d H:i:s");

	$rezult =  [];
	$brand_Err = $discription_Err = $model_Err = $color_Err = $price_Err  = $file_Err  =  '';

	function valid_DATA($data) {
		$data = trim($data);             //trim - функция  удаляет пробелы до и после слова но в самом слове пробелы не удаляет
		$data = stripslashes($data);     //stripslashes — Удаляет экранирование символов
		$data = strip_tags($data);       //strip_tags — Удаляет теги HTML и PHP из строки
		$data = htmlspecialchars($data); //htmlspecialchars — Преобразует специальные символы в HTML-сущности
		return $data;
    }

    $date_time_valid = valid_DATA($date_time);

   
    
    


    //______________________УДАЛЕНИЕ КАРТОЧКИ_____________________
    
	
	if ($delete == 'delete') {

		
		if ($radio_no != 'no'){
			
			
			//подключаемся к бд
			require('../db/link_db.php');

			//защищаем бд от иньекций
			$value_id_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($id_card)));

			//берем имя картинки и помещаем результат запроса в переменную
			$old_name_img = mysqli_query($products_lesson_6, " SELECT `name_img` FROM `products` WHERE `id` IN ({$value_id_db}) ");

			if(mysqli_query($products_lesson_6, " DELETE  FROM `products` WHERE `id` IN ({$value_id_db}) ")){

				$rezult_delete_card =  mysqli_insert_id($products_lesson_6);

				if ($rezult_delete_card['update_brand'] == 0) {
					$rezult_delete_card = "удаление карточки id № $value_id_db из БД произведено успешно";
				}

				echo json_encode([ 

		   		 					'delete'               => 'succes'                , 
		   		 					'mysql_rezult'         =>  $rezult_delete_card    , 
		   		 					
		   						]);



				//____________________________код для удаления старой картинки__________________________

				$scandir = scandir(IMG_DIR);
				$img = [];
				//фильтруем все файлы в папке и отбираем только с расширением jpg / jpeg / png и помещаем эти файлы в массив img[]
				foreach ($scandir as $file) {

					if ( is_file(IMG_DIR . $file)) {

						//strtolower — Преобразует строку в нижний регистр
						$file = strtolower($file);

						if ((pathinfo($file, PATHINFO_EXTENSION) == 'jpg')  || 
							(pathinfo($file, PATHINFO_EXTENSION) == 'jpeg') || 
							(pathinfo($file, PATHINFO_EXTENSION) == 'png'))  {

							$img[] = [

								'name_img'  =>  pathinfo($file, PATHINFO_BASENAME)
							];

						}

					}

				}
				//Возвращает ряд результата запроса в качестве ассоциативного массива
				$row = mysqli_fetch_assoc($old_name_img);

				//если в папке images есть картинка с названием картинки которая была в таблице до обновления то мы ее удаляем
				foreach ($img as $value) {
					//strtolower — Преобразует строку в нижний регистр
					$row['name_img'] = strtolower($row['name_img']);
					$value['name_img'] = strtolower($value['name_img']);
					if ($value['name_img'] == $row['name_img']) {
						//удаляем cтарую картинку т.к запись в бд  удалась 
						unlink(IMG_DIR . $row['name_img'] );
					}
				}



			}else{
				$rezult_delete_card =  mysqli_error($products_lesson_6);
				echo json_encode([ 

		   		 					'delete'               => 'error'                , 
		   		 					'mysql_rezult'         =>  $rezult_delete_card    , 

		   		 					
		   						]);
			}

			mysqli_close($products_lesson_6);
			exit;

			
		}
	}









    //______________________ПРОВЕРЯЕМ БРЭНД______________________
    if (isset($value_brand)) {

		if(mb_strlen($value_brand) >= 30 ){
			$brand_Err = "Недопусимая длина строки (до 30 символов)";

		}elseif(mb_strlen($value_brand) <= 0 ){
			$brand_Err = "Это поле обязательно к заполнению";

		}else{
			$value_brand_valid = valid_DATA($value_brand);
		}

    }else{
    	$brand_Err = "Это поле обязательно к заполнению";
    }



    //______________________ПРОВЕРЯЕМ ОПИСАНИЕ ТОВАРА______________________
    if (isset($value_discription)) {

		if(mb_strlen($value_discription) >= 10000 ){
			$discription_Err = "Недопусимая длина строки (до 10000 символов)";

		}elseif(mb_strlen($value_discription) <= 0 ){
			$discription_Err = "Это поле обязательно к заполнению";

		}else{
			$value_discription_valid = valid_DATA($value_discription);
		}

    }else{
    	$discription_Err = "Это поле обязательно к заполнению";
    }


   

    //______________________ПРОВЕРЯЕМ МОДЕЛЬ______________________
    if (isset($value_model)) {

		if(mb_strlen($value_model) >= 100 ){
			$model_Err = "Недопусимая длина строки (до 100 символов)";

		}elseif(mb_strlen($value_model) <= 0 ){
			$model_Err = "Это поле обязательно к заполнению";

		}else{
			$value_model_valid = valid_DATA($value_model);
		}

    }else{
    	$model_Err = "Это поле обязательно к заполнению";
    }



    //______________________ПРОВЕРЯЕМ ЦВЕТ______________________
    if (isset($value_color)) {

		if(mb_strlen($value_color) >= 100 ){
			$color_Err = "Недопусимая длина строки (до 100 символов)";

		}elseif(mb_strlen($value_color) <= 0 ){
			$color_Err = "Это поле обязательно к заполнению";

		}else{
			$value_color_valid = valid_DATA($value_color);
		}

    }else{
    	$color_Err = "Это поле обязательно к заполнению";
    }



    //______________________ПРОВЕРЯЕМ ЦЕНУ______________________
    if (isset($value_price)) {
    	$value_price = str_replace(",",".",$value_price); //заменяем запятую на точку
    	

		if(mb_strlen($value_price) > 8 ){
			$price_Err = "Недопусимая длина цены товара (до 8 символов)";

		//[+-]? один из + или же -
		//^ - начало строки
		//$ - конец строки
		//+  ищем один или более раз (в данном случае цифру с запятой)
		//проверяем, содержит ли число только один знак точка , один знак плюс или мину , и только числа без пробелов если нет то {}
		}elseif(!preg_match("/^[0-9]*[.]?[0-9]+$/",$value_price)){
			$price_Err = 'введите только цифры без пробелов и символов кроме . и ,';

		}elseif($value_price > 99999.99 ){
			$price_Err = "Недопусимая сумма - введите не больше 100000.00";

		}elseif($value_price <= 0 ){
			$price_Err = "Недопусимая сумма - введите больше 0";


		}elseif(!preg_match("/^\d{0,10}(\d{1,10}[.]\d{0,2})?$/", $value_price)){
			$price_Err = 'введите корректное число';


		}else{
			
			$value_price = (float)$value_price;
			$value_price_valid = valid_DATA($value_price);
		}
    }else{
    	$price_Err = "Это поле обязательно к заполнению";
    }





    

    

    //если выполнился запрос ajax и мы не выбирали картинку результат все равно будет true
	if(isset($_FILES['input_zamena_img'])){

		//is_uploaded_file — Определяет, был ли файл загружен при помощи HTTP POST
		if(is_uploaded_file($_FILES['input_zamena_img']['tmp_name'])) {


			//функция для загрузки картинок
			function uploadImage($atr_name){

				//устанавливаем в переменную случайное число и далее конкотенируем его с именем файла чтобы придать уникальное имя
				$count_id = random_int(10000, 10000000);
				

				if (!isset($_FILES[$atr_name])) {
					$error = [ 'error' => ("файл не выбран")];
					return $error;
				}

				if($_FILES[$atr_name]['error'] !== 0) {
					$error = [ 'error' => ("При загрузке картинки возникла ошибка № " . $_FILES[$atr_name]['error'])];
					return $error;
				}

				if(!(($_FILES[$atr_name]['type'] == 'image/jpeg') || ($_FILES[$atr_name]['type'] == 'image/png')))  {
					$error = [ 'error' => ("файл \"" .  $_FILES[$atr_name]['name'] . "\" не картинка !!!")];
					return $error;
				}

				//Максимальный размер файла 7 Мб
				if(($_FILES[$atr_name]['size'] >= (7 * 1024 * 1024))) { 
					$error = [ 'error' => ("файл слишком велик ".$_FILES[$atr_name]['size'])];
					return $error;
				}

				// Минимальный размер файла 
				if(($_FILES[$atr_name]['size'] <= (1000))) { 
					$error = [ 'error' => ("файл слишком мал ".$_FILES[$atr_name]['size'])];
					return $error;
				}

				if( (isset($_FILES[$atr_name]))               && 
						  ($_FILES[$atr_name]['error'] === 0) && 
						 (($_FILES[$atr_name]['type']   == 'image/jpeg') || ($_FILES[$atr_name]['type'] == 'image/png')) &&
						 (!(($_FILES[$atr_name]['size']   > (7 * 1024 * 1024))) ||
						 (!($_FILES[$atr_name]['size']    < (1000))))   ) {

					
					$_FILES[$atr_name]['name'] = trim($_FILES[$atr_name]['name']);          
					$_FILES[$atr_name]['name'] = strip_tags($_FILES[$atr_name]['name']);         
					$_FILES[$atr_name]['name'] = htmlspecialchars($_FILES[$atr_name]['name']);     
					$_FILES[$atr_name]['name'] = str_replace(' ', '', $_FILES[$atr_name]['name']);
					
				
					//берем из названия файла только его расширение
					$PATHINFO_EXTENSION = pathinfo($_FILES[$atr_name]['name'], PATHINFO_EXTENSION);
					
					//производим загрузку файла в папку и меняем его имя на рандомное число + точка + расширение
					move_uploaded_file($_FILES[$atr_name]['tmp_name'], IMG_DIR . ($_FILES[$atr_name]['name'] = $count_id.'.'.$PATHINFO_EXTENSION)); 
					
					
				}else{
					$error = [ 'error' => ("ошибка при загрузке файла" . $_FILES[$atr_name]['name'])];
					return $error;
				}
			
				$succes = [ 'succes' => ("запись файла " . $_FILES[$atr_name]['name'] . " в папку " . IMG_DIR . " произведена успешно") ];
				return $succes;
			
			}

			$rezult = uploadImage('input_zamena_img');

			//чтобы не возникало ошибок если пользователь не выбрал картинку и обновил карточку
			if ($rezult['error'] == "При загрузке картинки возникла ошибка № 4") {
				$rezult['error']  = null;
			}


		
		}


	
	}
	
    
    		
    	

		



	



	

	
	
	
	//проверяем на инициализацию ошибок
	if(  isset($rezult['error'])  ||
	   (!empty($brand_Err))       ||
	   (!empty($discription_Err)) ||   
	   (!empty($model_Err))       ||
	   (!empty($color_Err))       ||
	   (!empty($price_Err)))       {    
	           
		
	   		echo json_encode([ 
	   		 					'error'           => 'error'            , 
	   							'brand_Err'       =>  $brand_Err        ,
	   							'result_add_img'  =>  $rezult           ,       
	   							'discription_Err' =>  $discription_Err  ,
	   							'model_Err'       =>  $model_Err        ,
	   							'color_Err'       =>  $color_Err        ,
	   							'price_Err'       =>  $price_Err        ,

	   						]);
	   	

	//если все переменные с ошибками пусты то
   	}elseif(!isset($rezult['error'])  &&
			(empty($brand_Err))       &&
			(empty($discription_Err)) &&   
			(empty($model_Err))       &&
			(empty($color_Err))       &&
			(empty($price_Err)))       {   





			//если инициализировано хоть одно значение для обновления данных в карточке то
			if( isset($rezult['succes'])          ||
			   (!empty($value_brand_valid))       || 
			   (!empty($value_discription_valid)) ||
			   (!empty($value_model_valid))       ||   
			   (!empty($value_color_valid))       ||
			   (!empty($value_price_valid)))       { 
			           


					//подключаемся к бд
					require('../db/link_db.php');

					//массив который мы будем наполнять результатами обновления колонок бд
					$array_rezult_update_db = [];



					//______________________________________________ОБНОВЛЯЕМ ТАБЛИЦУ В БД
						
					//защищаем бд от иньекций
					$value_id_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($id_card)));
					$value_brand_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($value_brand_valid)));
					$value_discription_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($value_discription_valid)));
					$value_model_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($value_model_valid)));
					$value_color_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($value_color_valid)));
					$value_price_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($value_price_valid)));
					$name_img_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($_FILES['input_zamena_img']['name'])));



					

					
					//если изображение загружено то
					if (isset($rezult['succes'])) {

						//БЕРЕМ СТАРОЕ ИМЯ КАРТИНКИ ДО ЕГО ОБНОВЛЕНИЯ ЧТОБЫ УДАЛИТЬ СТАРУЮ КАРТИНКУ ЕСЛИ МЫ ЗАГРУЗИЛИ НОВУЮ
						$old_name_img = mysqli_query($products_lesson_6, " SELECT `name_img` FROM `products` WHERE `id` IN ({$value_id_db}) ");

						//записываем в бд данные
						if (mysqli_query($products_lesson_6, " UPDATE `products` SET `brand`       = '{$value_brand_valid_db}'        ,
																				   `description` = '{$value_discription_valid_db}'  ,
																				   `model`       = '{$value_model_valid_db}'		,
																				   `color`       = '{$value_color_valid_db}'		,
																				   `price`       = '{$value_price_valid_db}'		,
																				   `name_img`    = '{$name_img_db}'		            ,
																				   `date_update` = '{$date_time_valid}'             
						 									 WHERE `id` IN  ('{$value_id_db}') ")){


						
							$rezult_update =  mysqli_insert_id($products_lesson_6);

							$array_rezult_update_db[] = [
															'update_brand'       => $rezult_update                       ,
															'update_discription' => $rezult_update                       ,
															'update_model'       => $rezult_update                       ,
															'update_color'       => $rezult_update                       ,
															'update_price'       => $rezult_update                       ,
															'update_img'         => $rezult_update                       ,
														 	'name_img'           => "добавлено изображение $name_img_db" 
														];

							//переформатируем значение переменной
							if ($array_rezult_update_db[0]['update_brand'] == 0) {
								$array_rezult_update_db[0]['update_brand'] = 'обновление brand произведено успешно';
							}
							if ($array_rezult_update_db[0]['update_discription'] == 0) {
								$array_rezult_update_db[0]['update_discription'] = 'обновление discription произведено успешно';
							}
							if ($array_rezult_update_db[0]['update_model'] == 0) {
								$array_rezult_update_db[0]['update_model'] = 'обновление mode произведено успешно';
							}
							if ($array_rezult_update_db[0]['update_color'] == 0) {
								$array_rezult_update_db[0]['update_color'] = 'обновление color произведено успешно';
							}
							if ($array_rezult_update_db[0]['update_price'] == 0) {
								$array_rezult_update_db[0]['update_price'] = 'обновление price произведено успешно';
							}
							if ($array_rezult_update_db[0]['update_img'] == 0) {
								$array_rezult_update_db[0]['update_img'] = 'обновление name_img произведено успешно';
							}
							
							
							echo json_encode([ 

		   		 					'succes'               => 'succes_update_img'         , 
		   		 					'mysql_rezult'         =>  $array_rezult_update_db    , 
		   		 					
		   						]);
							

						


							//____________________________код для удаления старой картинки__________________________

							$scandir = scandir(IMG_DIR);
							$img = [];
							//фильтруем все файлы в папке и отбираем только с расширением jpg / jpeg / png и помещаем эти файлы в массив img[]
							foreach ($scandir as $file) {

								if ( is_file(IMG_DIR . $file)) {

									//strtolower — Преобразует строку в нижний регистр
									$file = strtolower($file);

									if ((pathinfo($file, PATHINFO_EXTENSION) == 'jpg')  || 
										(pathinfo($file, PATHINFO_EXTENSION) == 'jpeg') || 
										(pathinfo($file, PATHINFO_EXTENSION) == 'png'))  {

										$img[] = [

											'name_img'  =>  pathinfo($file, PATHINFO_BASENAME)
										];

									}

								}

							}
							
							//Возвращает ряд результата запроса в качестве ассоциативного массива
							$row = mysqli_fetch_assoc($old_name_img);

							//если в папке images есть картинка с названием картинки которая была в таблице до обновления то мы ее удаляем
							foreach ($img as $value) {

								//strtolower — Преобразует строку в нижний регистр
								$row['name_img'] = strtolower($row['name_img']);
								$value['name_img'] = strtolower($value['name_img']);

								if ($value['name_img'] == $row['name_img']) {
									//удаляем cтарую картинку т.к запись в бд  удалась 
									unlink(IMG_DIR . $row['name_img'] );
								}
							}

							
							












	   					//если запись в дб возратила false то		
						}else{

							//удаляем картинку т.к запись в бд не удалась а картинку уже сохранилась на сервере
							unlink(IMG_DIR . $_FILES['input_zamena_img']['name'] );

							$rezult_update =  mysqli_error($products_lesson_6);

							$array_rezult_update_db[] = [
															'mysqli_error'       => $rezult_update                       
														];

							echo json_encode([ 

			   		 					'succes'               => 'error_update_img'         , 
			   		 					'mysql_rezult'         =>  $array_rezult_update_db    , 

			   		 					
			   						]);
						}















							
					//если картинка не загружена то обновляем cтарое имя на старое имя картинки
					}else{

						//берем имя старой картинки и помещаем результат запроса в переменную
						$old_name_img = mysqli_query($products_lesson_6, " SELECT `name_img` FROM `products` WHERE `id` IN ({$value_id_db}) ");
						//mysql_fetch_assoc — Возвращает ряд результата запроса в качестве ассоциативного массива
						$old_name_img_assoc = mysqli_fetch_assoc($old_name_img);

						//записываем в бд данные
						if (mysqli_query($products_lesson_6, " UPDATE `products` SET `brand`       = '{$value_brand_valid_db}'            ,
																				   `description` = '{$value_discription_valid_db}'      ,
																				   `model`       = '{$value_model_valid_db}'		    ,
																				   `color`       = '{$value_color_valid_db}'		    ,
																				   `price`       = '{$value_price_valid_db}'		    ,
																				   `name_img`    = '{$old_name_img_assoc["name_img"]}' ,
																				   `date_update` = '{$date_time_valid}'             
						 									 WHERE `id` IN  ('{$value_id_db}') ")){


						
							$rezult_update =  mysqli_insert_id($products_lesson_6);

							$array_rezult_update_db[] = [
															'update_brand'       => $rezult_update                       ,
															'update_discription' => $rezult_update                       ,
															'update_model'       => $rezult_update                       ,
															'update_color'       => $rezult_update                       ,
															'update_price'       => $rezult_update                       ,
															'update_img'         => $rezult_update                       ,
														];


							//переформатируем значение переменной
							if ($array_rezult_update_db[0]['update_brand'] == 0) {
								$array_rezult_update_db[0]['update_brand'] = 'обновление brand произведено успешно';
							}
							if ($array_rezult_update_db[0]['update_discription'] == 0) {
								$array_rezult_update_db[0]['update_discription'] = 'обновление discription произведено успешно';
							}
							if ($array_rezult_update_db[0]['update_model'] == 0) {
								$array_rezult_update_db[0]['update_model'] = 'обновление mode произведено успешно';
							}
							if ($array_rezult_update_db[0]['update_color'] == 0) {
								$array_rezult_update_db[0]['update_color'] = 'обновление color произведено успешно';
							}
							if ($array_rezult_update_db[0]['update_price'] == 0) {
								$array_rezult_update_db[0]['update_price'] = 'обновление price произведено успешно';
							}
							if ($array_rezult_update_db[0]['update_img'] == 0) {
								$array_rezult_update_db[0]['update_img'] = 'обновление name_img произведено успешно';
							}



							echo json_encode([ 

					   		 					'succes'               => 'succes_no_update_img'      , 
					   		 					'mysql_rezult'         =>  $array_rezult_update_db    , 
					   		 					
					   						]);

							

							
							




	   					//если запись в дб возратила false то		
						}else{


							$rezult_update =  mysqli_error($products_lesson_6);

							$array_rezult_update_db[] = [
															'mysqli_error'       => $rezult_update                       
														];

							echo json_encode([ 

			   		 					'succes'               => 'error_no_update_img'         , 
			   		 					'mysql_rezult'         =>  $array_rezult_update_db    , 
			   		 					
			   						]);


						}



					}

					mysqli_close($products_lesson_6);

					
					





			}
	

	}




/*САМОЕ ВАЖНОЕ ПРАВИЛО НЕ ПИСАТЬ КОМЕНТАРИИ ЗА ПРЕДЕЛАМИ СКОБКИ PHP*/

?>




























