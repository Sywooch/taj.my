<?php
if($_GET['cat_id']<1) die('NO CATEGORY');
$cat=explode(',',$_GET['cat_id']);
$currCat=$cat[0];
$history=$_GET['HISTORY'];
if($_GET['LIMIT']<1) $limit=5000;
	else $limit=$_GET['LIMIT'];
$keytdc=='jPHY=em7d+pf?W2r3+xwNxWf_B+%Ad';

require_once($_SERVER['DOCUMENT_ROOT'] . '/autoparts/config.php');

$mysqli = mysqli_connect( 
            $arTDMConfig['MODULE_DB_SERVER'],	 	 // ’ост, к которому мы подключаемс¤ 
            $arTDMConfig['MODULE_DB_LOGIN'],   	   	 // »м¤ пользовател¤  
            $arTDMConfig['MODULE_DB_PASS'],  		 // »спользуемый пароль  
            $arTDMConfig['MODULE_DB_NAME']);  		 // Ѕаза данных дл¤ запросов по умолчанию 
$mysqli->set_charset("utf8");

$mysqliR = mysqli_connect( 
            "178.32.148.174",	// ’ост, к которому мы подключаемс¤ 
            "ibexshop.com.ua",  // »м¤ пользовател¤  
            "ibexshop.com.ua",  // »спользуемый пароль  
            "TD"	// Ѕаза данных дл¤ запросов по умолчанию 
);  	
$mysqliR->set_charset("utf8");

$SQL="
SELECT DISTINCT
      ARTICLES.ART_ID AS PID
    , BRANDS.BRA_MFC_CODE AS BKEY
	, ART_LOOKUP.ARL_SEARCH_NUMBER AS AKEY
	, BRANDS.BRA_BRAND AS BRAND
    , ARTICLES.ART_ARTICLE_NR AS ARTICLE
	, ".$currCat." AS CATEGORY
FROM ARTICLES 

INNER JOIN BRANDS
    ON ARTICLES.ART_SUP_ID = BRANDS.BRA_ID

INNER JOIN ART_LOOKUP
    ON (
			ARTICLES.ART_ID = ART_LOOKUP.ARL_ART_ID 
		AND	ART_LOOKUP.ARL_KIND = 1
		AND	ART_LOOKUP.ARL_BRA_ID=0
	)

WHERE EXISTS(
    SELECT * 
    FROM LINK_ART 
    INNER JOIN LINK_GA_STR 
        ON LINK_GA_STR.LGS_STR_ID	 = ".$currCat."
       AND LINK_ART.LA_GA_ID		 = LINK_GA_STR.LGS_GA_ID
    WHERE ARTICLES.ART_ID = LINK_ART.LA_ART_ID
)
ORDER BY ARTICLES.ART_ARTICLE_NR
LIMIT ".$_GET['START'].", " . $limit . " ";
echo "<code>",$SQL, '</code><br><br>';
if ($result = $mysqliR->query($SQL)) {
	$num=0;
	$SQL="
			INSERT 
				INTO TDM_PRODUCT_CATEGORY (
					  `PID`
					, `BKEY`
					, `AKEY`
					, `BRAND`
					, `ARTICLE`
					, `CATEGORY`
				) 
				VALUES ";
	while ($row = $result->fetch_assoc()) {
		if($row['BKEY']!=''&&$row['AKEY']!='') {
			$SQL.=" (
					  '".$row['PID']."'
					, '".$row['BKEY']."'
					, '".$row['AKEY']."'
					, '".$row['BRAND']."'
					, '".$row['ARTICLE']."'
					, '".$currCat."'
				), ";
			
				$msg.= '<a style="color:green" href="http://ibexshop.com.ua/autoparts/products/'.$row['BKEY'].'/'.$row['AKEY'].'/">'.$row['BRAND'].' '.$row['ARTICLE'].'</a><br>';
			$num++;
		}
	}
	$SQL.="(NULL,NULL,NULL,NULL,NULL,0)";
	if ($result2 = $mysqli->query($SQL))
		echo "<h1>Импортированно ".$num." строк.</h1><h2> Всего импортировано в данной категории ".($num+$_GET['START'])." </h2>";
	else echo "<h1>Произошла ошибка.</h1><br>",$SQL;
}
?>
<?php 
$stop=false;
if($num == $limit ) { 
	$step=(int)$_GET['START']+$limit;
?>
	<h2 style="text-align:center; padding:50px 0">Продолжаем импорт...</h2>

<?php } else { 
	if($history!='')
		$history.=','.$cat[0];
	else
		$history=''.$cat[0];
	if(count($cat)<2) $stop=true;
	$cat[0]='';
	$step=0;
?>
	<h2>Импорт завершен...</h2>
<?php } 
$cats='';
	foreach($cat as $oneCat) 
	if($oneCat!='') {
		if($cats!='')	$cats.=','.$oneCat;
		else 			$cats.=$oneCat;
	}
if($cats=='') $stop=true;
?>
<br><br><br>
	<script>
<?if(!$stop) { ?>
		console.log(new Date);
		window.setTimeout(function(){
			window.location.href = "<?php echo "http://ibexshop.com.ua/category_export.php?cat_id=",$cats,'&START=',$step,'&HISTORY=',$history; ?>";},1000);
<?php } else {?>
	alert('Импорт завершен.')
<?php } ?>
	</script>
	
<?php echo $msg;?>