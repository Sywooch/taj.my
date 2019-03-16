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
		`category`.`id`		AS category_id,
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
if($query = $con->query($q)) {
    while ($row = $query->fetch_assoc()) {
        $model = [
			'id'				=>	$row['id'],
            'name'	            =>	$row['name'],
            'brand'	            =>	$row['brand'],
            'category_name'	    =>	$row['category_name'],
            'category_id'	    =>	$row['category_id'],
            'category_url'	    =>	$row['category_url'],
            'image'	            =>	$row['image'],
			'price_copy'		=>	$row['price_copy'],
			'price_original1'	=>	$row['price_original1'],
			'price_original2'	=>	$row['price_original2'],
			'price_express'		=>	$row['price_express'],
        ];
    }
	if(count($model)<1) {
		header('Location: /remont/');	
	}
} else { 
	$model = ['error' => 'Помилка завантаження данних. Стробуйте пізніше.'];
	header('Location: /remont/');
}

$q = "SELECT 
			p_l.`id` 					AS id,
			p.`price` 					AS price,
			p_l.`name` 					AS label,
			p.`data-has-part` 			AS datapart,
            c.`url`						AS url 
	FROM 
    	`price_labels` p_l , `prices` p
		LEFT JOIN `sub_text` c 
        	ON  p.`sub_text_id`  = c.`id`
    
	WHERE 
				p.`model_id`= ".(int)$model['id']. "
		AND 	p_l.`id` = p.`price_id`
	GROUP BY p_l.`id`
	LIMIT 999";
if($query = $con->query($q)) {
    while ($row = $query->fetch_assoc()) {
        $serv[] = $row;
		$ids[] = "(`filter_links`.`price_id` = ".$row['id'].")";
	}
}
$q = "SELECT 
		`filters`.`name` 				AS name,
		`filters`.`tag` 				AS tag,
		`filters`.`id` 					AS id,
		`filters`.`img` 				AS img,
		`filter_links`.`price_id`		AS link
	FROM 
    	`filters`,
		`filter_links`
	WHERE 
		`filters`.`category_id`= ".(int)$model['category_id']. "
		AND `filter_links`.`filter_id`= `filters`.`id`
		AND (
			".implode(" OR ", $ids)."
		)
	LIMIT 50";
if($query = $con->query($q)) {
    while ($row = $query->fetch_assoc()) {
        if(!isset($filters[$row['id']])) {
			$filters[$row['id']] = $row;
		}
		$filters[$row['id']]['links'][] = $row['link'];
	}
}
?>