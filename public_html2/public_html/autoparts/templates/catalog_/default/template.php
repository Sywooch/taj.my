<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();
$db_config=$TDMCore->arConfig;
$mysqli = mysqli_connect( 
            $db_config['MODULE_DB_SERVER'],	 	 // Хост, к которому мы подключаемся 
            $db_config['MODULE_DB_LOGIN'],   	   	 // Имя пользователя  
            $db_config['MODULE_DB_PASS'],  		 // Используемый пароль  
            $db_config['MODULE_DB_NAME']);  		 // База данных для запросов по умолчанию 
$mysqli->set_charset("utf8");

switch ( $_GET['type'] ) {
	case "all": include($_SERVER['DOCUMENT_ROOT'] . '/autoparts/templates/catalog/default/all.php');
		break;
	case "category_list": include($_SERVER['DOCUMENT_ROOT'] . '/autoparts/templates/catalog/default/category_list.php');
		break;
	case "category_product": include($_SERVER['DOCUMENT_ROOT'] . '/autoparts/templates/catalog/default/category_product.php');
		break;
	default: "<script>location='/'</script>";
} 
?>
<?php 

/*
if(TDM_ISADMIN) { 
	
	$TDSQL = new TDSQL;
	
	echo ($TDSQL::GetSectionData("Ru"));

	echo '<br>';
	//print_r($a);
	$a=get_class_methods($TDSQL);
	foreach($a as $b){
		print_r($b);
		echo "<br>";
	}
}


///////////////////////////////////////////////////////////////////////////


$postdata = http_build_query(
    array(
        'getcategorynames' => '1',
		'getfullinfo' => '1'
    )
);
$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);
$context  = stream_context_create($opts);
require_once("tdmcore/defines.php");
require_once("tdmcore/init.php");
$db_config=$TDMCore->arConfig;
$mysqli = mysqli_connect( 
            $db_config['MODULE_DB_SERVER'],	 	 // Хост, к которому мы подключаемся 
            $db_config['MODULE_DB_LOGIN'],   	   	 // Имя пользователя  
            $db_config['MODULE_DB_PASS'],  		 // Используемый пароль  
            $db_config['MODULE_DB_NAME']);  		 // База данных для запросов по умолчанию 
$mysqli->set_charset("utf8");
$categorys=[];
$p_categorys=[];
$q='SELECT `ibex_id`,`name`,`parent_id` FROM `TDM_CATEGORYS_TECDOC` WHERE `url` LIKE "'.$_GET['article'].'" LIMIT 0 , 100';

if ($result = $mysqli->query($q)) {
     while ($row = $result->fetch_assoc()) {
       $h = $row["name"];
	   $p_categorys[]=$row['parent_id'];
	   $categorys[]=$row['ibex_id'];
    }
    // очищаем результирующий набор 
    $result->close();
}
$cond='';
$categorys=array_unique($categorys);
foreach($categorys as $cat_id) {
	if($cond=='') $cond='`category_id` = "'.$cat_id.'"';
	else $cond.=' OR `category_id` ="'.$cat_id.'"';
}
$q='SELECT * FROM `TDM_CATEGORYS_PRODUCTS` WHERE '.$cond.' LIMIT 0 , 1';
if ($result = $mysqli->query($q)) {
     while ($row = $result->fetch_assoc()) {
		$doc="http://ibexshop.com.ua/autoparts/products/".$row["BKEY"]."/".$row["AKEY"];	
		$file = file_get_contents($doc, false, $context);
		$arrs=json_decode($file);
        echo '<div>',$file, '</div>';
    }
    //очищаем результирующий набор 
    $result->close();
}

$mysqli->close(); ?>
*/
 ?>

<div class="tclear"></div>

<?=TDMShowSEOText("TOP")?>
<?php 
