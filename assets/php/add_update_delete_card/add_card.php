<?php  
	
	const IMG_DIR = '../../../assets/images/';

	$value_brand       = $_POST['value_brand'];
	$value_discription = $_POST['value_discription'];
	$value_model       = $_POST['value_model'];
	$value_color       = $_POST['value_color'];
	$value_price       = $_POST['value_price'];


	$rezult =  [];
	$brand_Err = $discription_Err = $model_Err = $color_Err = $price_Err  = $file_Err  =  '';

	function valid_DATA($data) {
		$data = trim($data);             //trim - функция  удаляет пробелы до и после слова но в самом слове пробелы не удаляет
		$data = stripslashes($data);     //stripslashes — Удаляет экранирование символов
		$data = strip_tags($data);       //strip_tags — Удаляет теги HTML и PHP из строки
		$data = htmlspecialchars($data); //htmlspecialchars — Преобразует специальные символы в HTML-сущности
		return $data;
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






	if(isset($_FILES['add_file'])){

		//is_uploaded_file — Определяет, был ли файл загружен при помощи HTTP POST
		if(is_uploaded_file($_FILES['add_file']['tmp_name'])) {


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

			$rezult = uploadImage('add_file');


		}else{

			$rezult = [ 'error' => "ошибка при загрузке файла"];
		}
	
 	
    }
		









	
	
	
	//проверяем на инициализацию ошибок

	if(($rezult['error'])         ||
	   (!empty($brand_Err))       ||
	   (!empty($discription_Err)) ||   
	   (!empty($model_Err))       ||
	   (!empty($color_Err))       ||
	   (!empty($price_Err)))       {    
	           

			if ($rezult['error'] == "При загрузке картинки возникла ошибка № 4") {
				$rezult['error']  = "Это поле обязательно к заполнению";
			}
	   		echo json_encode([ 
	   		 					'error'           => 'error'            , 
	   							'brand_Err'       =>  $brand_Err        ,
	   							'result_add_img'  =>  $rezult           ,       
	   							'discription_Err' =>  $discription_Err  ,
	   							'model_Err'       =>  $model_Err        ,
	   							'color_Err'       =>  $color_Err        ,
	   							'price_Err'       =>  $price_Err        ,

	   						]);
		
	
	}else{

			//проверяем на инициализацию всех данных передаваемых в бд 
			if(($rezult['succes'])                &&
			   (!empty($value_brand_valid))       && 
			   (!empty($value_discription_valid)) &&
			   (!empty($value_model_valid))       &&   
			   (!empty($value_color_valid))       &&
			   (!empty($value_price_valid)))       { 
			           


					//подключаемся к бд
					$db_lesson_6_php = mysqli_connect("127.0.0.1", "root", "root", "products_lesson_6" , 3307) or die ("НЕ УДАЛОСЬ ПОДКЛЮЧИТСЯ К БАЗЕ ДАННЫХ");


					//защищаем бд от иньекций
					$value_brand_valid_db = mysqli_real_escape_string($db_lesson_6_php, (string)htmlspecialchars(strip_tags($value_brand_valid)));

					$value_discription_valid_db = mysqli_real_escape_string($db_lesson_6_php, (string)htmlspecialchars(strip_tags($value_discription_valid)));

					$value_model_valid_db = mysqli_real_escape_string($db_lesson_6_php, (string)htmlspecialchars(strip_tags($value_model_valid)));

					$value_color_valid_db = mysqli_real_escape_string($db_lesson_6_php, (string)htmlspecialchars(strip_tags($value_color_valid)));

					$value_price_valid_db = mysqli_real_escape_string($db_lesson_6_php, (string)htmlspecialchars(strip_tags($value_price_valid)));

					$name_img_db = mysqli_real_escape_string($db_lesson_6_php, (string)htmlspecialchars(strip_tags($_FILES['add_file']['name'])));
					

					//записываем в бд данные
					if (mysqli_query($db_lesson_6_php, " INSERT INTO `products` ( `brand`      ,
														 						  `description`,
														 						  `model`      ,
														 						  `color`      ,
														 						  `price`      ,  
														 						  `name_img`   )
														 						   

							                             VALUES ( '{$value_brand_valid_db}'        ,
							                            		  '{$value_discription_valid_db}'  ,
							                            		  '{$value_model_valid_db}'        ,
							                              		  '{$value_color_valid_db}'        ,
							                            		  '{$value_price_valid_db}'        ,
							                            		  '{$name_img_db}'                 ) ")  ){ 
							                            		 
							//если запись в дб возратила true то
							$rezult_add_data_db =  mysqli_insert_id($db_lesson_6_php);
								                                                           
							
							echo json_encode([ 
								
	   		 					'succes'               => 'succes'             , 
	   		 					'mysqli_insert_id'     => 'succes'             , 
	   		 					'rezult_add_data_db'   =>  $rezult_add_data_db , 
	   							'result_add_img'       =>  $rezult             , 
	   							
	   						]);

							
					//если запись в дб возратила false то		
					}else{

						//удаляем картинку т.к запись в бд не удалась а картинку уже сохранилась на сервере
						unlink(IMG_DIR . $_FILES['add_file']['name'] );

						$rezult_add_data_db =  mysqli_error($db_lesson_6_php);
						echo json_encode([ 

	   		 					'succes'               => 'succes'             , 
	   		 					'mysqli_error'         => 'error'              , 
	   		 					'rezult_add_data_db'   =>  $rezult_add_data_db , 
	   							'result_add_img'       =>  $rezult             , 

	   						]);



					}

					mysqli_close($db_lesson_6_php);

			}



			

	}






?>