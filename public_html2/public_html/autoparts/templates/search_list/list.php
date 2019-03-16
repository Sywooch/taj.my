<?
$AKEY = mysql_escape_string($_GET['article']);

$db = new TDMQuery;

$cond='';

if($_POST['status']=='full') {
	$where='LIKE "';
	$where_end='"';
} else {
	$where='LIKE "';
	$where_end='%"';
}
$AKEYs=explode(',' , $AKEY);

$cond.='AKEY '.$where.$AKEY.$where_end;

$limit=10;

$limit_max="LIMIT 0 , ".$limit;

if($cond!='') $cond='WHERE '.$cond;
$q="	SELECT 
			`BKEY`,
			`AKEY`
		FROM `TDM_PRICES` 
		".$cond."
		GROUP BY `BKEY`, `AKEY`
		ORDER BY `AVAILABLE` ASC, `BKEY` ASC, `AKEY` ASC, `PRICE` ASC
		".$limit_max;
$json=[];
/*
if($result = $db->query($q)) {
	while($row =$result->fetch_assoc()) {
		$search_list++;
		print_r($row);
	}
} echo $db->error;
	
mysqli_close($db);*/
$db->Select('TDM_PRICES',Array(),Array("AKEY"=>$AKEY."%"));
if(!$arCol = $db->Fetch()) {
	$search_list=-1;
} else print_r($arCol);
?>