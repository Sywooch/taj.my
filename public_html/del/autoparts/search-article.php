<?
include('config.php');
include('tdmcore/custom_functions.php');

if($_GET['q']=='KsEek3ztSpgMjrZsE2HfRprbJVYDgBrQRsCE2pfZ') {
	$_POST['AKEY']=$_GET['a'];
}
if($_POST['AKEY']=='') die('[]');

$db = mysqli_connect(
			$arTDMConfig['MODULE_DB_SERVER'],
			$arTDMConfig['MODULE_DB_LOGIN'],
			$arTDMConfig['MODULE_DB_PASS'],
			$arTDMConfig['MODULE_DB_NAME']
		);
if (!$db) {
    exit('error');
}
$db->set_charset("utf8");
$cond='';
if($_POST['status']=='full') {
	$where='LIKE "';
	$where_end='"';
} else {
	$where='LIKE "%';
	$where_end='%"';
}
$AKEYs=explode(',' , $_POST['AKEY']);
$BKEYs=explode(',', $_POST['BKEY']);

$cond.='AKEY '.$where.$_POST['AKEY'].$where_end;

$limit=5;

$limit_max="LIMIT 0 , ".$limit;

if($cond!='') $cond='WHERE '.$cond;
$q="	SELECT 
			`BKEY`,
			`AKEY`,
		FROM `TDM_PRICES` 
		".$cond."
		GROUP BY `BKEY`, `AKEY`
		ORDER BY `AVAILABLE` ASC, `BKEY` ASC, `AKEY` ASC, `PRICE` ASC
		".$limit_max;
if($_GET['q']==1) echo $q;
$json=[];
$n=0;
if ($result = $db->query($q))
	while ($row =$result->fetch_assoc()) {
		$row['SITE_PRICE']=getPrice(Array($row[PRICE]));
		if($limit-10<=$n) {
			if($row['BKEY']==$AKEY&&$row['BKEY']==$BKEY) {
				$json[]=$row;
				$AKEY=$row['AKEY'];
				$BKEY=$row['BKEY'];
			} 
		} else {
			$AKEY=$row['AKEY'];
			$BKEY=$row['BKEY'];
			$json[]=$row;
			$n++;
		}
	}
	echo $q;
	if($_GET['t']!=1)
		echo json_encode($json);
	else {
		echo '<table width="100%"><thead style="border-bottom:1px solid #ccc"><td>AKEY</td><td>BKEY</td><td>PRICE</td><td>SITE PRICE</td><td>VALUE</td><td>SUPL</td><td>DATE</td></thead>';
		foreach($json as $obj) {
			echo '<tr><td>',$obj['AKEY'],'</td><td>',$obj['BKEY'],'</td><td>',$obj['PRICE'],'</td><td>',$obj['SITE_PRICE'],'</td><td>',$obj['AVAILABLE'],'</td><td>',$obj['SUPPLIER'],'</td><td>', date('d.m.Y', $obj['DATE']),'</td><tr>';
		}
		echo '<table>';
	}
mysqli_close($db);
?>