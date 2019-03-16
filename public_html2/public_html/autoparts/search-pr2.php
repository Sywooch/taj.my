<?php

	require_once($_SERVER['DOCUMENT_ROOT']."/admin/config_td.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/autoparts/config.php");
	
	$brands=[];
	$articles=[];
	
	$TDMCore->DBSelect("TECDOC");
	$S_ARTICLE = TDMSingleKey($_POST["AKEY"]);
	$S_BRAND = BrandNameDecode($_POST["BKEY"]);
	//$rsArts = TDSQL::GetPartByPKEY($S_BRAND, $S_ARTICLE);
	$rsArtsAnalog = TDSQL::LookupByBrandNumber($S_BRAND, $S_ARTICLE);
	if($rsArtsAnalog) {
		$last='';
		while ($store = $rsArtsAnalog->Fetch()) {
			if($store['ARTICLE'].$store['BRAND']!=$last) {
				$result_analogs['ARTICLE'][] 	=	$store['ARTICLE'];
				$result_analogs['BRAND'][]		=	$store['BRAND'];
				$result_analogs['INFO'][]		=	$store;
				$last							=	$store['ARTICLE'].$store['BRAND'];
			}
		}
		$_POST['AKEY']=implode(',',$result_analogs['ARTICLE']);
		$_POST['BKEY']=implode(',',$result_analogs['BRAND']);
	} else die('[1]'); 
	
	$db = mysqli_connect(
				$TDMCore->arConfig['MODULE_DB_SERVER'],
				$TDMCore->arConfig['MODULE_DB_LOGIN'],
				$TDMCore->arConfig['MODULE_DB_PASS'],
				$TDMCore->arConfig['MODULE_DB_NAME']
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
	$a=[];
	foreach($AKEYs as $A) {
		$a[]=TDMSingleKey($A);
	}
	foreach($BKEYs as $B) {
		$b[]=BrandNameDecode($B);
	}
	$AKEYs=$a;
	$BKEYs=$b;

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
		$n=0;
		if($n=array_search($row['AKEY'],$result_analogs['ARTICLE'])) {
			if($n>0&&$result_analogs['BRAND'][$n]==$row['BKEY']) {
				unset($result_analogs['BRAND'][$n]);
				unset($result_analogs['ARTICLE'][$n]);
				unset($result_analogs['INFO'][$n]);
			}
		}
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
	$count = count($result_analogs['ARTICLE']);
	for($s=0;$s<=$count;$s++) {
		if(isset($result_analogs['ARTICLE'][$s])&&isset($result_analogs['BRAND'][$s])) {
			$json[]=array(
				'AKEY' 		=> 	$result_analogs['ARTICLE'][$s],
				'BKEY' 		=> 	$result_analogs['BRAND'][$s],
				"ALT_NAME"	=> 	$result_analogs['INFO'][$s]['TD_NAME'],
				"CODE"		=> 	0,
				"PRICE"		=> 	0,
				"AVAILABLE"	=> 	0,
				"SUPPLIER"	=> 	'Нет в наличии',
				"DATE"		=>	0,
				"SITE_PRICE"=>	0
			);
		} else {
			//$json[]='!';
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