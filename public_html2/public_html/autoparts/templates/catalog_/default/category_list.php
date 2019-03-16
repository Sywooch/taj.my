<?php 
include($_SERVER['DOCUMENT_ROOT'] . '/autoparts/tdmcore/components/sections/settings.php');
$CurrCategoryUrl = $_GET['category'];
$CurrCategory = array_search($CurrCategoryUrl,$arComSets["CODE"]); 
if(!$CurrCategory) die;
include($_SERVER['DOCUMENT_ROOT'] . '/autoparts/tdmcore/components/subsections/settings.php');
$SQL='SELECT 
  A.td_id
, A.name
, A.url
, A.p_id

FROM TDM_CATEGORYS as A

INNER JOIN TDM_CATEGORYS as A2 
	ON A2.p_id = '.$CurrCategory.'

INNER JOIN TDM_CATEGORYS as A3 
	ON A3.p_id = A2.td_id

GROUP BY (A.td_id)
ORDER BY  `A`.url DESC 
';
$catgs=[];
if($result = $mysqli->query($SQL)) { 
	while ($row = $result->fetch_assoc()) {
		$catgs[$row['p_id']][]=$row;
	}?>
	
				<link rel="stylesheet" href="/autoparts/templates/subsections/asd/style.css" type="text/css">
	<table class="TecDocSubCat"><tbody><tr><td style="vertical-align:top;">
		<div class="rsecs" style="background-image:url(/autoparts/media/sections/<?php echo $CurrCategory;?>.jpg);">
			<div class="rseclinks">
									<a href="http://ibexshop.com.ua/autoparts/catalog/engine/" <?php if($CurrCategoryUrl=='engine') echo 'class="rsactive"';?>>Двигатель</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/transmission/" <?php if($CurrCategoryUrl=='transmission') echo 'class="rsactive"';?>>Коробка передач</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/filters/">Фильтр</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/electrics/">Электрика</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/brake/">Тормозная система</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/clutch/">Сцепление</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/steering/">Рулевое управление</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/belt-drive/">Ременный привод</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/wheel-drive/">Привод колеса</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/body/">Кузов</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/axle-drive/">Главная передача</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/suspension/">Амортизация</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/conditioning/">Кондиционер</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/heater/">Отопление и вентиляция</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/axle-mounting/">Подвеска оси</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/fuel-mixture/">Подготовка топливной смеси</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/fuel-supply/">Система подачи топлива</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/glow-ignition/">Зажигание</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/cooling/">Охлаждение</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/exhaust/">Система выпуска</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/windscreen-cleaning/">Очистка окон</a>
									<a href="http://ibexshop.com.ua/autoparts/catalog/wheels-tires/">Колёса и шины</a>
							</div>
		</div>
	</td>
	<td width="90%" style="vertical-align:top;">
		<div id="subsections"><?php
			if($catgs[$CurrCategory]) 
			foreach($catgs[$CurrCategory] as $catgs2) {?>
						<?php
						if(count($catgs[$catgs2['td_id']])!=0) {
							echo '<div class="subCategoryBlock allCategory">';
							if($catgs2['url']=='') 
								echo '<div class="shead">',$catgs2['name'],'</div>';
							echo '<div class="sbody">';
							/*******************/
							foreach	($catgs[$catgs2['td_id']] as $catgs3) {
								if(count($catgs[$catgs3['td_id']])!=0) {
									echo '<div>';
									if($catgs3['url']=='') 
										echo '<div class="subtitle">',$catgs3['name'],'</div>';
									/*******************/
									foreach	($catgs[$catgs3['td_id']] as $catgs4) {
										if(count($catgs[$catgs4['td_id']])!=0) {
											if($catgs4['url']=='') 
												echo '<div class="subtitle">',$catgs4['name'],'</div>';
										} else
											echo '<div class="level3"><a href="http://ibexshop.com.ua/autoparts/catalog/',$CurrCategoryUrl,'/',$catgs4['url'],'/">',$catgs4['name'],'</a></div>';
									}
									echo '</div>';
								} 
								else 
									echo '<div class="level2"><a href="http://ibexshop.com.ua/autoparts/catalog/',$CurrCategoryUrl,'/',$catgs3['url'],'/">',$catgs3['name'],'</a></div>';
							}
							echo '</div>';
						}	
						else 
							echo '<div class="shead"><a href="http://ibexshop.com.ua/autoparts/catalog/',$CurrCategoryUrl,'/',$catgs2['url'],'/">',$catgs2['name'],'</a>';?>
				</div><?php 
			} ?>
		</div>
	</td></tr></tbody></table>
		
	<?php			
}
/*
foreach($ChildCategory as $CID) {
	echo '<a href="/autoparts/catalog/'.$CurrCategoryUrl.'/',$arComSets["CODE"][$CID],'/">(',$CID,') - ',$arComSets["CODE"][$CID], '</a><br>';
	
	if($ChildCategory2= array_keys($arComSets["PARENT"], $arComSets["CODE"][$CID]) ) {
		echo '<div class="sub">';
		foreach($ChildCategory2 as $CID2) 
		echo '<a href="/autoparts/catalog/'.$CurrCategoryUrl.'/',$arComSets["CODE"][$CID2],'/">(',$CID2,') - ',$arComSets["CODE"][$CID2], '</a><br></div>';
	}
}*/
?>
</div>

<style>
.level3 {padding: 0 0 0 20px;}
div#subsections>.shead { width: 45%; margin-top: 10px; margin-right: 5%; }
.subCategoryBlock.allCategory { margin-top: 20px; }
div#subsections>div:after { clear: both; }
</style>