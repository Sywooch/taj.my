<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Sinc</title>
</head>
<?php 
if($_GET['key']!='mavpa02h') die();
$reload=true;
$limit=$_GET['limit'];
if($limit<1) $limit=30;
$timeout=$_GET['timeout'];
if($timeout<1) $timeout=30;

 $db_connt = mysqli_connect('localhost', 'mpciwxad_tdbs', 'TBdh{3LaWG%v', 'mpciwxad_td');

 if (!mysqli_set_charset($db_connt, "utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", mysqli_error($db_connt));
}

if (mysqli_connect_errno()) {
    printf("Не удалось подключиться: %s\n", mysqli_connect_error());
    exit();
}
$postdata = http_build_query(
    array(
        'getcategorynames' => '1'
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
for($i=1;$i<=$limit;$i++)
if(!$reload) {break; } else
if ($result = mysqli_query($db_connt, "SELECT `BKEY`,`AKEY` FROM `TDM_PRICES`  WHERE `category_id` LIKE 0 AND `BKEY`!='' AND `AKEY`!='' LIMIT 1")) {
	$count=0;
	while ($row = $result->fetch_assoc()) {
		$doc="https://ibexshop.com.ua/autoparts/products/".$row["BKEY"]."/".$row["AKEY"];	
		$file = file_get_contents($doc, false, $context);
		$arrs=json_decode($file);
			/*ПЕРЕМЕСТИТЬ "БЕЗ КАТЕГОРИИ*/
		if(!is_array($arrs)) {
			if($result2 = mysqli_query($db_connt, "UPDATE `TDM_PRICES` SET `category_id` = 1 WHERE `BKEY`='".$row['BKEY']."' AND `AKEY`='".$row['AKEY']."'")) {
				echo '<p><a style="color:#ca6f06;" href="',$doc,'">',$row["BKEY"]." - ".$row["AKEY"],': товар без категории</p>';
				$rows++;
			}
			else {
				echo '<p><a  style="color:#bf0202" href="',$doc,'">',$row["BKEY"]." - ".$row["AKEY"],': ошибка обновления</p>';
				$rows++;
			}
			/*ПЕРЕМЕСТИТЬ "БЕЗ КАТЕГОРИИ*/
		} else
		foreach($arrs as $item ) if($item->CATEGORY!='') {
			if ($result2 = mysqli_query($db_connt, "SELECT `id` FROM `TDM_CATEGORYS` WHERE `name` LIKE '$item->CATEGORY'")) {
			while( $res=$result2->fetch_assoc() ) $id=$res['id'];
				if($result2->num_rows>0&&$id>0) {
					if(
						$result2 = mysqli_query($db_connt, "UPDATE `TDM_PRICES` SET `category_id` = 2 WHERE `BKEY` LIKE '".$item->BKEY."' AND `AKEY` LIKE '".$item->AKEY."'" )
						&&
						$result2 = mysqli_query($db_connt, "	INSERT INTO `TDM_CATEGORYS_PRODUCTS` (`AKEY`, `BKEY`, `category_id`) 
								VALUES ('".$item->AKEY."' , '".$item->BKEY."', $id )")
					) {
						echo '<p><a style="color:#ca6f06;" href="',$doc,'">',$item->BKEY." - ".$item->AKEY,'</a>: товар перемещен в категорию ',$item->CATEGORY,' </p>';
						$rows++;
					} else {
						$reload=false; echo '<script>console.log("1")</script>';echo mysqli_error($db_connt);
					} 
				} else {
					if($result2 = mysqli_query($db_connt, "	INSERT INTO `TDM_CATEGORYS` (`name`) 
													VALUES ('$item->CATEGORY')")) {
						$id=$db_connt->insert_id;
						echo '<p style="color:green;">',$item->CATEGORY,': добавлена</p>';
						echo '<script>console.log("',$item->CATEGORY,' добавлена. ID:',$db_connt->insert_id,'")</script>';
						
						
						if(
							$id>0
							&&
							$result2 = mysqli_query($db_connt, "UPDATE `TDM_PRICES` SET `category_id` = 2 WHERE `BKEY` LIKE '".$item->BKEY."' AND `AKEY` LIKE '".$item->AKEY."'" )
							&&
							$result2 = mysqli_query($db_connt, "	INSERT INTO `TDM_CATEGORYS_PRODUCTS` (`AKEY`, `BKEY`, `category_id`) 
								VALUES ('".$item->AKEY."' , '".$item->BKEY."', $id )")
						) {
							echo '<p><a style="color:#ca6f06;" href="',$doc,'">',$item->BKEY." - ".$item->AKEY,'</a>: товар перемещен в <b>созданную</b> категорию ',$item->CATEGORY,' </p>';
							$rows++;
						} else {
							$reload=false; echo '<script>console.log("2")</script>'; echo mysqli_error($db_connt);
						}
					} else {
						$reload=false;
						echo '<script>console.log("3")</script>';
						echo mysqli_error($db_connt);
					}
				}
				
			} else {
				$reload=false;
				echo mysqli_error($db_connt);
			}
			
		} else {
				$reload=false;
				echo 'Category name failed';
		}
    }
}
	
mysqli_free_result($result);
	

mysqli_close($db_connt);
echo '<br>Кол-во:',$rows;
?>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script>
		jQuery('document').ready(function() {
			var d = new Date();
			var h = d.getHours();
			var m = d.getMinutes();
			var s = d.getSeconds();
			console.log(h+':'+m+':'+s+'   -    <?php echo $rows; ?>');
			<?php if($reload) { ?>
				 window.setTimeout(reload(),<?php echo $timeout; ?> );
				 function reload() {
						document.location.reload();
				 }
			<?php } else { ?>
				alert('error');
			<?php } ?>
		});
	</script>
<div>
	<a id="reload" href="/prd.php?key=mavpa02h" target="_blank">NEXT</a>

</div>