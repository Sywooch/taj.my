<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();

require_once("tdmcore/defines.php");
require_once("tdmcore/init.php");
require_once("tdmcore/custom_functions.php");

include($_SERVER['DOCUMENT_ROOT'] . '/autoparts/tdmcore/components/subsections/settings.php');
$CurrCategory = array_search($_GET['category_gr'],$arComSets["CODE"]); 


$SQLMysqliR= "
	SELECT *
	FROM TDM_SETTINGS
";
if ($result = $mysqli->query($SQLMysqliR)) { 
while ($data = $result->fetch_assoc()) {
	$mysqliRConf[$data['FIELD']] = $data['VALUE'];
}
$result->close();
$mysqliR = mysqli_connect( 
            $mysqliRConf['TECDOC_DB_SERVER'],	 	// Хост, к которому мы подключаемся 
            $mysqliRConf['TECDOC_DB_LOGIN'],   	// Имя пользователя  
            $mysqliRConf['TECDOC_DB_PASS'],  		// Используемый пароль  
            $mysqliRConf['TECDOC_DB_NAME']		// База данных для запросов по умолчанию 
);  		 

} else die;
$SQL="
	SELECT COUNT(*) as COUNT FROM
		TDM_PRICES
	INNER JOIN 
		TDM_PRODUCT_CATEGORY 
	ON 
		TDM_PRODUCT_CATEGORY.CATEGORY =".$CurrCategory."
	WHERE 
			TDM_PRICES.AKEY = TDM_PRODUCT_CATEGORY.AKEY
		AND TDM_PRICES.BKEY = TDM_PRODUCT_CATEGORY.BKEY
		AND TDM_PRICES.PRICE >0
	GROUP BY 
		TDM_PRICES.AKEY, TDM_PRICES.BKEY
"; 
if ($result = $mysqli->query($SQL)) { 
	$num_rows = $result->num_rows;
	$result->close();
} else die;
$SQL="SELECT name FROM  TDM_CATEGORYS_TECDOC WHERE id=".$CurrCategory;
if ($result = $mysqli->query($SQL)) { 
	while ($row = $result->fetch_assoc()) {
		$CurrCategoryName=$row['name'];
	}
} else $CurrCategoryName="Категория Товаров";
//$result->close();

$page=$_GET['page'];
if($page<2) $page=1;
$SQL="
	SELECT 
		  TDM_PRICES.AKEY
		, TDM_PRICES.BKEY
		, TDM_PRODUCT_CATEGORY.PID AS PKEY
		, TDM_PRODUCT_CATEGORY.ARTICLE
		, TDM_PRODUCT_CATEGORY.BRAND
		, SUM( AVAILABLE ) AS NUM
		, GROUP_CONCAT(TDM_PRICES.PRICE) AS PRICES
		, GROUP_CONCAT(TDM_PRICES.AVAILABLE) AS AVAILABLES
	FROM TDM_PRICES
	INNER JOIN 
		TDM_PRODUCT_CATEGORY 
	ON 
		TDM_PRODUCT_CATEGORY.CATEGORY =".$CurrCategory."
	WHERE 
			TDM_PRICES.AKEY = TDM_PRODUCT_CATEGORY.AKEY
		AND TDM_PRICES.BKEY = TDM_PRODUCT_CATEGORY.BKEY
		AND TDM_PRICES.PRICE >0
	GROUP BY 
		TDM_PRICES.AKEY, TDM_PRICES.BKEY
	ORDER BY 
		CASE WHEN SUM( AVAILABLE ) =0
			THEN 1
			ELSE 0 
		END ASC , 
		CASE WHEN SUM( AVAILABLE ) <>0
			THEN TDM_PRICES.PRICE
			ELSE TDM_PRICES.AVAILABLE
		END DESC 
LIMIT " . ($page-1)*24 . ", " . 24 ."
";
if ($num_rows>0&&$result = $mysqli->query($SQL)) {
	$arrProduct=[];
	   
    while ($row = $result->fetch_assoc()) {
		$PriceArr=explode(',',$row['PRICES']);
		$AvailableArr=explode(',',$row['AVAILABLES']);
		$price=[];
		$i=0;
		while($i<count($PriceArr)) {
			$price[$i]["PRICE"]=round($PriceArr[$i]);
			$price[$i]["AVAILABLE"]=$AvailableArr[$i];
			$i++;
		}
		
		$arrProduct[$row['PKEY']] = array(
			"AKEY"		=> $row['AKEY'],
			"BKEY" 		=> $row['BKEY'],
			"PKEY" 		=> $row['PKEY'],
			"ARTICLE"	=> $row['ARTICLE'],
			"BRAND"		=> $row['BRAND'],
			"PRICES"	=> $price
		);
    }
    // очищаем результирующий набор 
    $result->close();
	
	//GET IMAGES
	$COND='';
	foreach ($arrProduct as $PrTemp) {
		if($COND!='') $COND.=" OR";
		$COND.=" LINK_GRA_ART.LGA_ART_ID = ".$PrTemp['PKEY'];
	}
	$SQL="
		SELECT 
			  LINK_GRA_ART.LGA_ART_ID 	AS PKEY
			, GRAPHICS.GRA_TAB_NR		AS FOLDER
			, GRAPHICS.GRA_GRD_ID		AS NAME
			, DOC_TYPES.DOC_EXTENSION 	AS FORMAT
		FROM GRAPHICS
		INNER JOIN LINK_GRA_ART ON 
			( ".$COND." )
		INNER JOIN DOC_TYPES ON 
			GRAPHICS.GRA_DOC_TYPE = DOC_TYPES.DOC_TYPE
		WHERE 
				GRAPHICS.GRA_ID = LINK_GRA_ART.LGA_GRA_ID
			AND GRAPHICS.GRA_TAB_NR > 0
			AND GRAPHICS.GRA_GRD_ID > 0
				
		GROUP BY LINK_GRA_ART.LGA_ART_ID
		LIMIT 0, 100
	";
	if ($result = $mysqliR->query($SQL)) {
		while ($row = $result->fetch_assoc()) {
			$arrProduct[$row['PKEY']]["IMAGE"] = 'https://'.$mysqliRConf["TECDOC_FILES_PREFIX"].'images/'.$row["FOLDER"].'/'.$row["NAME"].'.'.'jpg';
		}
		$result->close(); 
	} 
	?>
	<link rel="stylesheet" href="/autoparts/templates/partslist/asd/style.css" type="text/css">
	<script src="/autoparts/templates/partslist/asd/funcs.js"></script>
	<?php 
			$stages = 5;
			$start = 0;
			$targetpage="http://ibexshop.com.ua/autoparts/catalog/".$_GET['category_gr']."/".$_GET['category_gr'];
			// Initial page num setup
			if ($page == 0){$page = 1;}
			$prev = $page - 1;
			$next = $page + 1;
			$lastpage = ceil($num_rows/24)-1;
			if($num_rows%24!=0) $lastpage++;
				
			$LastPagem1 = $lastpage - 1;

			$paginate = '<div class="paginationPr">';
			if($lastpage > 1)
			{

			$paginate .= "<div class='pagination'>";
			// Previous
			if ($page > 1){
			$paginate.= "<a href='$targetpage/$prev/' class='prev'>Предыдущая</a>";
			}else{
			$paginate.= "<a class='notactive'>Предыдущая</a>"; }

			// Pages
			if ($lastpage < 7 + ($stages * 2)) // Not enough pages to breaking it up
			{
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
			if ($counter == $page){
			$paginate.= "<a class='current'>$counter</a>";
			}else{
			$paginate.= "<a href='$targetpage/$counter/'>$counter</a>";}
			}
			}
			elseif($lastpage > 5 + ($stages * 2)) // Enough pages to hide a few?
			{
			// Beginning only hide later pages
			if($page < 1 + ($stages * 2))
			{
			for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
			{
				if ($counter == $page){
					$paginate.= "<a class='current'>$counter</a>";
				}else{
					if($counter!=1)
						$paginate.= "<a href='$targetpage/$counter/'>$counter</a>";
					else
						$paginate.= "<a href='$targetpage/'>$counter</a>";
				}
					
			}
			$paginate.= "<a class='outer'>...</a>";
			$paginate.= "<a href='$targetpage/$LastPagem1/'>$LastPagem1</a>";
			$paginate.= "<a href='$targetpage/$lastpage/'>$lastpage</a>";
			}
			// Middle hide some front and some back
			elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
			{
			$paginate.= "<a href='$targetpage/'>1</a>";
			$paginate.= "<a href='$targetpage/2/'>2</a>";
			$paginate.= "<a class='outer'>...</a>";
			for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
			{
			if ($counter == $page){
			$paginate.= "<a class='current'>$counter</a>";
			}else{
			$paginate.= "<a href='$targetpage/$counter/'>$counter</a>";}
			}
			$paginate.= "<a class='outer'>...</a>";
			$paginate.= "<a href='$targetpage/$LastPagem1/'>$LastPagem1</a>";
			$paginate.= "<a href='$targetpage/$lastpage/'>$lastpage</a>";
			}
			// End only hide early pages
			else
			{
			$paginate.= "<a href='$targetpage/'>1</a>";
			$paginate.= "<a href='$targetpage/2/'>2</a>";
			$paginate.= "<a class='outer'>...</a>";
			for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
			{
			if ($counter == $page){
			$paginate.= "<a class='current'>$counter</a>";
			}else{
			$paginate.= "<a href='$targetpage/$counter/'>$counter</a>";}
			}
			}
			}

			// Next
			if ($page < $counter - 1){
			$paginate.= "<a href='$targetpage/$next/' class='next'>Следующая</a>";
			}else{
			$paginate.= "<a class='notactive'>Следующая</a>";
			}

			$paginate.= "</div></div>";

			}
	?>
	<h1 class="entry-title"><?php echo $CurrCategoryName?></h1>
	<?php echo $paginate; ?>
	<div class="product-grid box-product">
	
	
	<?php foreach($arrProduct as $product) { ?>
		<?php 
		$stock_all_price=[];
		$stock_status=false;
		foreach($product["PRICES"] as $arPriceKey){ 
			if ($arPriceKey['AVAILABLE']>0) {
				$stock_all_price[]=$arPriceKey['PRICE'];
				$stock_status=true;
			}
		} 
		?>
		<div class="tditem it" id="item<?php echo $product['BKEY'],$product['AKEY']; ?>">
				<div class="name" style="height: 28px;">
					<a href="/autoparts/products/<?php echo $product['BKEY'];?>/<?php echo $product['AKEY'];?>/" title="<?php echo $product['BRAND'],' ',$product['ARTICLE'];?>"><?php echo $product['BRAND'],' ',$product['ARTICLE'];?></a><span class="criteria"></span>
				</div>
				<div class="image">
					<div class="stock-label"><?php if($stock_status) { ?> есть в наличии <?php } else { echo 'под заказ'; } ?></div>
					<a href="/autoparts/products/<?php echo $product['BKEY'];?>/<?php echo $product['AKEY'];?>/" title="<?php echo $product['BRAND'],' ',$product['ARTICLE'];?>">
						<img src="<?php if($product['IMAGE']) echo $product['IMAGE']; else echo 'http://ibexshop.com.ua/autoparts/media/images/nopic.jpg';?>" class="photobox productImage">
					</a>
				</div>
				<div class="manufacturer-pr"></div>
				<div class="price">
					<div class="prices">
						<?php if($stock_status) { ?>
							<div class="pricetab">
								<div class="priceVal"><?php echo getPrice($stock_all_price); ?> <span class="curr">грн.</span>	
								</div>
								<div>
									<a href="javascript:void(0)" class="addtocart" onclick="TDAddToCart('<?php echo $product['BKEY'],'/',$product['AKEY'] ?>')" title="Добавить в корзину">В корзину</a>
								</div>
							</div>
						<?php } else { ?>
							<div class="pricetab"><a class="preorder">Уточнить наличие</a>							</div>
						<?php } ?>
					</div>
				</div>
		</div>
	
	<?php } ?>
	</div>
	<?php echo $paginate; ?>
	
	
	
	
	<?php
} else include($_SERVER['DOCUMENT_ROOT'].'/autoparts/templates/category_noproduct/temptation.php');
?>
<style>
.paginationPr .pagination a.notactive { background:#fff; color:#777!important;cursor:default; }
.paginationPr .pagination a.outer { cursor: default; margin: 5px 15px;}
.paginationPr .pagination a.current { border-color: #01487e; cursor: pointer; }
.paginationPr .pagination a.outer:hover,.pagination a.current:hover { cursor: default; background: -webkit-gradient(linear, center top, center bottom, from(#fff), to(#c8c8c8)); background-image: linear-gradient(#fff, #c8c8c8); color: #000!important; }
.paginationPr {text-align:center; }
.paginationPr .pagination {margin: 0 auto; width: auto; display: inline-block;}
</style>
