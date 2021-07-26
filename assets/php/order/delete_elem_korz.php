<?php
	session_start();  
	
	

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$items_products_id_name = $_POST['items_products_id_name'] ?? null;

		//ЕСЛИ КНОПКА --УДАЛИТЬ ЭЛЕМЕНТ ИЗ КОРЗИНЫ-- НАЖАТА
		if (isset($items_products_id_name)) {

			

			//удаляем элемент из сессии 
			$_SESSION['product_id'] = mb_eregi_replace("$items_products_id_name;", '', $_SESSION['product_id']);
				echo json_encode(['succes' => 'succes', 'id' => $items_products_id_name ]);
			

			
			

				
		}
	}

?>