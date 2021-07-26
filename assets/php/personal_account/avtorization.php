<?php  
	session_start();

	//форма регистрации

	$form_registration_login        = $_POST['form_avtorization_login'];
	$form_registration_password     = $_POST['form_avtorization_password'];


	$loginErr = $passwordErr = '';




	//_____________ПОДКЛЮЧАЕМ ФУНКЦИИ ВАЛИДАЦИИ ДАННЫХ___________
	require('function_valid.php');








    //проверяем логин
    if (isset($form_registration_login)) {
    	
    	if (empty($form_registration_login)) {
		$loginErr = "Введите логин";

		}elseif(mb_strlen($form_registration_login) < 3 || mb_strlen($form_registration_login) > 30 ){
			$loginErr = "Недопусимая длина логина (от 3 до 30 символов)";

		// проверяем, содержит ли имя только буквы и пробелы
		}elseif(preg_match("/[ }{\]\[№;:#$?<+=>!%^&*\/\\\`\"\']/",$form_registration_login)) {
			
			$loginErr = "логин должен содержать буквы , числа и некоторые символы ( ~@()-_| )";
						
		}else {
			$form_registration_login_valid = valid_login_password($form_registration_login);
		}
    }





	
	//проверяем пароль
    if (isset($form_registration_password)) {
    	
    	if (empty($form_registration_password)) {
		$passwordErr = "Введите пароль";

		}elseif(mb_strlen($form_registration_password) < 5 || mb_strlen($form_registration_password) > 15 ){
			$passwordErr = "Недопусимая длина пароля (от 5 до 15 символов)";

		}elseif(preg_match("/[ }{\]\[№;:#$?<+=>!%^&*\/\\\`\"\']/",$form_registration_password)) {
			
			$passwordErr = "пароль должен содержать буквы , числа и некоторые символы ( ~@()-_| )";
		}else{

			$form_registration_password_valid = valid_login_password($form_registration_password);
		
		}
			

    }







		

	








	if ((!empty($loginErr))  || (!empty($passwordErr)))   {

		echo json_encode([ 
	 					'error'                        => 'error'                        , 
	 					'loginErr'                     => $loginErr                      ,
	 					'passwordErr'                  => $passwordErr                   ,
	 					'login'                        => $form_registration_login_valid ,
       

					]);





	}elseif((empty($loginErr))  && (empty($passwordErr))) {


			//подключаемся к бд
			require('../db/link_db.php');

				
			//защищаем бд от иньекций
			$value_login_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($form_registration_login_valid)));
			$value_password_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($form_registration_password_valid)));

			//получаем хеш пароля по логину пользователя из бд
			$tabl_users  = mysqli_query($products_lesson_6, "SELECT * FROM `users` WHERE  `login` = '{$value_login_valid_db}'  ");
			//mysqli_fetch_assoc - забирает последний ряд из таблицы а у нас там как раз может быть только одна строкатак login уникален
			$tabl_users_items = mysqli_fetch_assoc($tabl_users);

			//mysqli_num_rows — Возвращает количество рядов результата запроса
			//проверка на наличае пользователя
			if (!mysqli_num_rows($tabl_users)) {
				echo json_encode([ 
			 					'error'           => 'error_login'                 , 
			 					'rezult'          => 'такой пользователь не найден !',
							]);
				
			//проверяем функцией password_verify на совпадение введенного пароля с паролев в бд
			}elseif(password_verify($value_password_valid_db, $tabl_users_items['password'] )){

				$_SESSION['loginn']   = $tabl_users_items['login'];
				$_SESSION['id']       = $tabl_users_items['id'];
				// $_SESSION['name']     = $tabl_users_items['name'];
				// $_SESSION['family']   = $tabl_users_items['family'];
				// $_SESSION['email']    = $tabl_users_items['email'];



				echo json_encode([ 
			 					'succes'           => 'succes'                        , 
			 					'tabl_users'       => $tabl_users_items['password']   ,
			 					'user_name'        => $tabl_users_items['name']       ,
			 					'user_family'      => $tabl_users_items['family']     ,
			 					'user_login'       => $tabl_users_items['login']      ,
			 					'sss'              => $aaa

							]);

			}else{
				echo json_encode([ 
			 					'error'           => 'error_password'                 , 
			 					'rezult'          => 'неверный пароль !',
							]);
			}













			mysqli_close($products_lesson_6);
			





			


	}












?>