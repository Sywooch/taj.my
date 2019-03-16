<?php
if(!(isset($config)&&is_array($config)&&$config['status'])) die('no direct open');
$con=mysqli_connect(
    $config['db_host'],
    $config['db_user'],
    $config['db_pass'],
    $config['db_name']
);

$con->set_charset("utf8");

$result = [];
if(mysqli_connect_errno()) die(mysqli_connect_error());

$q="SELECT 
		`models`.`name` 	AS name,
		`models`.`id` 		AS id,
		`models`.`image` 	AS image,
		
		`models`.`price_copy` 		AS price_copy,
		`models`.`price_original1` 	AS price_original1,
		`models`.`price_original2` 	AS price_original2,
		`models`.`price_express` 	AS price_express,
		
		`brands`.`name` 	AS brand,
		`brands`.`id`		AS brand_id,
		`category`.`name`	AS category_name,
		`category`.`url`	AS category_url
	FROM 	`models`, `brands`, `category`, `brands_to_category`
	WHERE 	
		`models`.`name` 					LIKE 	'".urldecode(str_ireplace('-',' ',$_GET['sp']))."'  		AND
		`brands_to_category`.`category_id`	=		`category`.`id`						AND
		`category`.`url`					LIKE	'".($_GET['c'])."' 					AND
		`models`.`brand_id` 				= 		`brands`.`id`						AND
		`brands`.`name` 					LIKE 	'".urldecode(str_ireplace('-',' ',$_GET['p']))."' 		AND
		`models`.`brand_id`					=		`brands_to_category`.`brand_id`		
	LIMIT 1";
	
$q = "
SELECT 
	`sub_text`.`content`	AS content,
	`sub_text`.`title`		AS title,
	`category`.`url` 		AS bread_category,
	`category`.`name` 		AS bread_category_n,
	`models`.`name` 		AS bread_model,
	`brands`.`name`			AS bread_brand

 FROM `sub_text`, `prices`,`models`,`category`,`brands`
 WHERE 
		`sub_text`.`url` LIKE '".urldecode($_GET['c'])."' 
	AND	`sub_text`.`id` 	= 	`prices`.`sub_text_id`
	AND	`prices`.`model_id`		=	`models`.`id`
	AND	`models`.`category_id`	=	`category`.`id`
	AND	`models`.`brand_id`		=	`brands`.`id`		
	
  LIMIT 1";
if($query = $con->query($q)) {
    while ($row = $query->fetch_assoc()) {
        $content = $row;
    }
	if(count($content)<1) {
		header('Location: /remont/');	
	}
} else { 
	$content = ['error' => 'Помилка завантаження данних. Стробуйте пізніше.'];
	header('Location: /remont/');
}

?>