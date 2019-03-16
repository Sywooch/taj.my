<?php
require_once($_SERVER['DOCUMENT_ROOT']."/autoparts/tdmcore/custom_functions.php");

$fn=$_GET['fn'];

switch ($fn) {
	case 'getPrice': 
		$prices=explode(';',$_GET['prices']);
		echo getPrice($prices);
		break;	
}
?>