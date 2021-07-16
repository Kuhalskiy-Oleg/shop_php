<?php 
	session_start();
	unset($_SESSION['loginn']);
	unset($_SESSION['id']);
	session_destroy();

	//чтобы нас сразу перекинуло на страницу admin.php
	header('Location: ../../../index.php?page=admin');
?>