<?php 
	$to  = 'ibexshop1@yandex.ru'; // обратите внимание на запятую
	$to1 = 'agfarcom@gmail.com';
	
if(isset($_POST['page'])) { 
	$mesg= "<p>Телефон: ".trim($_POST['phone']). "</p>";
	$mesg.= "<p>Товар: ".trim($_POST['productName']). "</p>";
	$mesg.= "<p>Ссылка: ".trim($_POST['page']). "</p>";



	// тема письма
	$subject = 'Быстрый заказ';

	// текст письма
	$message = '
	<html>
	<head>
	  <title>Быстрый заказ</title>
	</head>
	<body>'
	.$mesg. '
	</body>
	</html>
	';

	// Для отправки HTML-письма должен быть установлен заголовок Content-type
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF8' . "\r\n";

	// Дополнительные заголовки
	$headers .= 'To: IBEXshop <agfarcom@gmail.com>'. "\r\n";
	$headers .= 'IbexShop Admin <admin@ibexshop.com.ua>' . "\r\n";

	// Отправляем
	mail($to, $subject, $message, $headers);
	mail($to1, $subject, $message, $headers);

} else {
	mail($to, $subject, 'error', $headers);
	mail($to1, $subject, 'error', $headers);
}
?>