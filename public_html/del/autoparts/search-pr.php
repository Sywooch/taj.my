<?php
	include('config.php');
	include('tdmcore/custom_functions.php');
	
	if($_GET['q']=='KsEek3ztSpgMjrZsE2HfRprbJVYDgBrQRsCE2pfZ') {
		$_POST['AKEY']=$_GET['a'];
		$_POST['BKEY']=$_GET['b'];
	}
	if($_POST['AKEY']==''&&$_POST['BKEY']=='') die('closed');
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

if(count($AKEYs)>1&&count($BKEYs)>1) {
	for($i=0;$i<count($AKEYs);$i++)
		$cond.=' (AKEY LIKE "'.$AKEYs[$i].'" AND BKEY LIKE "'.$BKEYs[$i].'") OR';
	$cond.=' 1 = 0';
} else {

	if(isset($_POST['AKEY'])&&$_POST['AKEY']!='') 
		$cond.='AKEY '.$where.$_POST['AKEY'].$where_end;

	if(isset($_POST['BKEY'])&&$_POST['BKEY']!='') {
		if ($cond!='') $cond.=' AND ';
		$cond.='BKEY '.$where.$_POST['BKEY'].$where_end;
	}
/*
if(isset($_POST['name'])&&$_POST['name']!='') {
	if ($cond!='') $cond.=' AND ';
	$cond.='ALT_NAME` LIKE "%'.$_POST['name'].'%"';
}*/
}
if(isset($_POST['limit'])&&$_POST['limit']>0&&$_POST['limit']<200) 
	$limit=$_POST['limit']+10;
else
	$limit=20;
$limit_max="LIMIT 0 , ".$limit;

if($cond!='') $cond='WHERE '.$cond;
$q="	SELECT 
			`BKEY`,
			`AKEY`,
			`ALT_NAME`,
			`CODE`,
			`PRICE`,
			`AVAILABLE`,
			`SUPPLIER`,
			`DATE`
		FROM `TDM_PRICES` 
		".$cond."
		ORDER BY `BKEY` ASC, `AKEY` ASC, `PRICE` ASC
		".$limit_max;
if($_GET['q']==1) echo $q;
$json=[];
$n=0;
$prices=[];
if ($result = $db->query($q))
	while ($row =$result->fetch_assoc()) {
		if($row['AVAILABLE']>0)
		$prices[$row['AKEY'].$row['BKEY']][]=$row['PRICE'];
		
		$row['SITE_PRICE']=getPrice(Array($row['PRICE']));
		if($limit-10<=$n) {
			if($row['BKEY']==$AKEY&&$row['BKEY']==$BKEY) {
				$json[]=$row;
				$AKEY=$row['AKEY'];
				$BKEY=$row['BKEY'];
				$CODE=$row['CODE'];
			} 
		} else {
			$AKEY=$row['AKEY'];
			$BKEY=$row['BKEY'];
			$CODE=$row['CODE'];
			$json[]=$row;
			$n++;
		}
	}
	foreach($json as $index=>$site_price) {
		$key=$site_price['AKEY'].$site_price['BKEY'];
		if(isset($prices[$key])&&is_array($prices[$key])) {
			$json[$index]['SITE_PRICE']=getPrice($prices[$key]);
		}
	}
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