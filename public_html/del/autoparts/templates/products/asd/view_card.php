<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true) die('err');

function priceOrderSortMin($a, $b) {
	if ($a['productPrice'] === $b['productPrice']) return 0;
	return $a['productPrice'] > $b['productPrice'] ? 1 : -1;
}
function priceOrderSortMax($a, $b) {
	if ($a['productPrice'] === $b['productPrice']) return 0;
	return $a['productPrice'] < $b['productPrice'] ? 1 : -1;
}
	$count_analogs=0;

	uasort($arResult['PARTS'], 'priceOrderSortMin');	
	
	foreach($arResult['PARTS'] as $NumKey=>$arPart) { 
	
		if(
			(
				($_GET['article']==$arPart['AKEY']||strnatcasecmp(html_entity_decode($_GET['article']),$arPart['ARTICLE'])==0)&&
				($_GET['brand']==$arPart['BKEY']  ||strnatcasecmp(html_entity_decode($_GET['brand']),  $arPart['BRAND'])==0)
			)||(
				(
					strnatcasecmp(
						preg_replace("/[^A-Za-zА-Яа-я0-9]/", "",html_entity_decode($_GET['brand'])),
						preg_replace("/[^A-Za-zА-Яа-я0-9]/", "",html_entity_decode($arPart['BRAND']))
					)==0
					&&
					strnatcasecmp(
						preg_replace("/[^A-Za-zА-Яа-я0-9]/", "",html_entity_decode($_GET['article'])),
						preg_replace("/[^A-Za-zА-Яа-я0-9]/", "",html_entity_decode($arPart['ARTICLE']))
					) ==0
				)
			) || (
				(
					strnatcasecmp(
						preg_replace("/[^A-Za-zА-Яа-я0-9]/", "",html_entity_decode($arPart['BKEY'])),
						preg_replace("/[^A-Za-zА-Яа-я0-9]/", "",html_entity_decode($_GET['brand']))
					)==0
					&&
					strnatcasecmp(
						preg_replace("/[^A-Za-zА-Яа-я0-9]/", "",html_entity_decode($_GET['article'])),
						preg_replace("/[^A-Za-zА-Яа-я0-9]/", "",html_entity_decode($arPart['AKEY']))
					) ==0
				)
			)
		) {
		$Cnt++; $PCnt=0; $cm=''; $AddF=0;
		
		require_once("tdmcore/defines.php");
		require_once("tdmcore/init.php");
		
		if(TDM_ISADMIN) { ?>
			<form action="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>" method="POST">
				<input name="getcategorynames" type="text" value="1">
				<input type="submit" value="Показать категории товара">
			</form><?php 
		}				
		//Criteria display method    - ???
		if(false&&$arPart['CRITERIAS_COUNT']>0){
			foreach($arPart['CRITERIAS'] as $Criteria=>$Value){ 
				if($Criteria!=''){
					$arPart['CRITERIA'].=$cm.$Criteria.' - '.$Value;
				} else {
					$arPart['CRITERIA'].=$cm.UWord($Value);} $cm='; ';
			}
		} 
		
		?>
		
	<div class="product-info">
		<h1 class="name">
			<?php 
				$categoryNames=[];
				if(!$categoryNames=preg_split('/;/',$arPart['TD_NAME'])) 
					$categoryNames[0]=$arPart['TD_NAME']; 
				echo $categoryNames[0],' ',$arPart['BRAND'],' ',$arPart['ARTICLE'], ' ',$arPart['CRITERIA'];
			
			if(TDM_ISADMIN) { echo '<br> PKEY:',$arPart['PKEY']; }
			?>
		</h1>
		<div class="tclear"></div>
		<?TDMShowBreadCumbs()?>
		<div class="left">
			<div class="productImages">
				<div class="image">
					<img class="mainProductImage" src="<?=imageLoader($arPart['IMG_SRC'],'http://77.120.224.229/')?>" attr-main="<?=imageLoader($arPart['IMG_SRC'],'http://77.120.224.229/')?>" alt="<?php echo $categoryNames[0],' ',$arPart['BRAND'],' ',$arPart['ARTICLE'], ' ',$arPart['CRITERIA']; ?>">
				</div><?
				
				if(is_array($arPart["IMG_ADDITIONAL"])){ ?>
					<div class="image-additional">
						<?php foreach($arPart["IMG_ADDITIONAL"] as $AddImgSrc){ ?>
							<img width="80" src="<?=imageLoader($AddImgSrc)?>" alt="<?=$arPart['BRAND']?> <?=$arPart['ARTICLE']?>"><?
						} ?>
					</div>
					<script>
						jQuery(document).ready(function() {
							jQuery('.productImages').hover(function() { 
								jQuery('.image-additional img').hover(function() { 
									jQuery('.productImages .image img').attr('src', jQuery(this).attr('src') );
								});
								jQuery('.productImages .image img').height(jQuery('.productImages .image img').height());
							}, function() {
								jQuery('.productImages .image img').attr('src', jQuery('.productImages .image img').attr('attr-main') );
							});
						});
					</script>
					<?php 
				} ?>
			</div>
			<div class="product_desc_1 clearfix">
				<div>
					<div id="tab-attribute"><?php 
						$AID=intval($arPart['AID']);
						
						$TDMCore->DBSelect("TECDOC");
						$rsProps = TDSQL::GetPropertys($AID);
						
						$arUnqs=Array();
						while($arProp = $rsProps->Fetch()){
							$Unq=$arProp['NAME'].$arProp['VALUE'];
							if(!in_array($Unq,$arUnqs)){
								$arUnqs[] = $Unq;
								$arProps[] = $arProp;
							}
						}
						$rsNums = TDSQL::LookupAnalog($AID,Array(2,3,5)); //2-Торговый, 3-Оригинальный, 4-Неоригинальный, 5-Штрих код
						while($arNum = $rsNums->Fetch()){
							$arNums[] = $arNum;
						}
						
						if(count($arNums)>0){?>
							<table class="attribute">
								<tr><td><?=Lng('Related_numbers',1,0)?>:</td><td><?=Lng('Number_type',1,0)?></td></tr>
							<?
							foreach($arNums as $arNum){$Srch='';
								if($arNum['ARTICLE']==""){continue;}
								if($arNum['TYPE']==2){$arNum['TYPE']='<span class="artkind_trade">'.Lng('Trade',1,0).'</span>'; $Srch='Y';}
								if($arNum['TYPE']==3){$arNum['TYPE']='<span class="artkind_original">'.Lng('Original',1,0).'</span>'; $Srch='Y';}
								if($arNum['TYPE']==4){$arNum['TYPE']='<span class="artkind_analog">'.Lng('Analog',1,0).'</span>'; $Srch='Y';}
								if($arNum['TYPE']==5){$arNum['TYPE']='<span class="artkind_barcode">'.Lng('Barcode',1,0).'</span>';}
								?>
								<tr>
									<td class="tarig">
										<?=$arNum['BRAND']?>
										<?if($Srch=="Y"){?><a href="/<?=TDM_ROOT_DIR?>/search/<?=TDMSingleKey($arNum['ARTICLE'])?>/"><?}?>
										<?=$arNum['ARTICLE']?></a>
									</td>
									<td><?=$arNum['TYPE']?></td>
								</tr>
								<?
							}
							?>
							</table><?
						}?>
					</div>
				</div>
			</div>
        </div>
        <div class="right">
			<div class="coll">
				<?php 
				$stockStatus=0;
				$Prices=[];
				
				if(isset($arResult['PRICES'][$arPart['PKEY']]))
					foreach($arResult['PRICES'][$arPart['PKEY']] as $arPriceKey){ 
						if(TDM_ISADMIN) { 
							echo '<h2>Цены:</h2>';
							echo $arPriceKey['PRICE_FORMATED'], ' <a href="',$arPriceKey['EDIT_LINK'],'">Edit ',$arPriceKey['CODE'],'</a>';
							echo '<br><hr>';
						}
						if ($arPriceKey['AKEY']==$arPart['AKEY']&&$arPriceKey['AVAILABLE_NUM']>0) {
								$Prices[]=$arPriceKey['PRICE'];
								$stockStatus++;
						}
						
					//if($_GET['t']==1) var_dump($arPriceKey);
				} 
				$productPrice = getPrice($Prices);
				if($productPrice>=100) $productPrice=number_format($productPrice, 0, ',', ' ');
							
				if($stockStatus<1) { ?>
						<div class="price notinstock">под заказ</div>
							<div class="cart">
							<input type="button" value="Запрос товара" id="button-cart" class="button notinstock">
						</div><?php 
				} else { ?>
					<div class="productPriceBlock">
						<div class="price">	
							<?php echo $productPrice; ?>
							<span class="curr"> грн</span>
						</div>
						<div class="cart">
						  <input type="hidden" name="product_id" value="<?php $AID; ?>">
						  <input type="button" value="Купить" id="button-cart" onclick="TDAddToCart('<?php echo $arPart['BKEY'],'/',$arPart['AKEY']; ?>')" class="button">
						</div>
					</div>	
					<div class="fast_order">
						<h5>Заказать в один клик</h5>
						<input type="text" name="fast_phone" placeholder="Номер телефона">
						<input type="submit" name="fast_button" value="Заказать">
					</div>
					
					<?php 
				} 
				if($arPart['AID']>0) { ?>
					<div class="apps">
						<a href="/autoparts/apps.php?of=<?=$arPart['AID']?>" target="_blank" title="">Посмотреть совместимости с другими авто.</a>
					</div>
				<?php } ?>
			</div>
			<div class="product_catalog_num">
				<h4>Номер в каталоге</h4>
				<p><?=$arPart['BKEY']?> <?=$arPart['AKEY']?></p>
			</div>
			<div class="product_desc_1">
				<div>
					<div id="tab-attribute" class="vars">
						<?php
						if(count($arProps)>0){?>
							<h4>Характеристики</h4>
							<table class="attribute">
							<? foreach($arProps as $arProp){
								$arProp['NAME'] = str_replace('/мм?','/мм²',$arProp['NAME']);
								$arProp['NAME'] = str_replace('? ','Ø ',$arProp['NAME']);
								if(strpos($arProp['NAME'],'[')>0){
									$Dim = substr($arProp['NAME'],strpos($arProp['NAME'],'['));
									$arProp['NAME'] = str_replace(' '.$Dim,'',$arProp['NAME']);
									$Dim = str_replace('[','',$Dim); $Dim = str_replace(']','',$Dim);
									$arProp['VALUE'] = $arProp["VALUE"].' '.$Dim;
								}
								?>
								<tr><td class="tarig"><?=UWord($arProp['NAME'])?>: </td><td><?=$arProp['VALUE']?></td></tr>
								<?
							} ?>
							</table>
							<?
						} ?>
					</div>
				</div>
			</div>
			<div class="delivery_info">
				<ul>
					<li class="pay_info">
						<h5>Оплата</h5>
						<ul>
							<li>Наличными при получении</li>
						</ul>
					</li>
					<li class="del_info">
						<h5>Доставка</h5>
						<ul>
							<li>Курьером по Киеву: сегодня</li>
							<li>Самовывоз в Киеве: сегодня.</li>
							<li>На склад "Новой Почты" по Украине: 1-2 дня.</li>
							<li>На ваш адрес, в любой населенный пункт Украины: 2-3 дня.</li>
						</ul>
					</li>
				</ul>
			</div>
			<?php if(count($categoryNames)>1) { ?>
				<div class="ProductCategories">
					Данный товар представлен в категориях: 
					<?php foreach($categoryNames as $arrPartName)
						echo '<a>', $arrPartName, '</a> ';
					?>
				</div>
			<?php } ?>
		</div>
	</div>
	<div id="tab-description">

	</div>

<? } 
		else 
	$count_analogs++;
}
	if($count_analogs>0) {
?>

	<div class="box related-box">
		<div class="box-heading">Аналоги</div>
		<div class="box-notice">Товары, которые являються заменителями товара <b><?=$productName?></b></div>
		<div class="box-content">
			<div class="bx-wrapper"><?php 
				$count_analogs=0;
				foreach($arResult['PARTS'] as $NumKey=>$arPart)
				if(
						$_GET['article']!=$arPart['AKEY']
					&&	$_GET['article']!=$arPart
					&&	$_GET['brand']!=$arPart['BKEY']
					&&	$_GET['brand']!=$arPart['BRAND']
					&&	$arPart['BKEY']!=''
					&&	$arPart['AKEY']!=''
				) 
				{					
					$arPart['IMG_SRC'] = imageLoader($arPart['IMG_SRC'],'http://77.120.224.229/');
					?>
					<div class="bx-viewport" class="bx-clone">
						<div class="name">
							<a class="title" href="/autoparts/products/<?=$arPart['BRAND']?>/<?=$arPart['ARTICLE']?>"><?=$arPart['BRAND']?> <?=$arPart['ARTICLE']?><?=$arPart['CRITERIA']?></a></div>
							<div class="image">
								<a href="/autoparts/products/<?=$arPart['BRAND']?>/<?=$arPart['ARTICLE']?>"><img src="<?=str_replace('http:// _DEL _', 'https://',$arPart['IMG_SRC'])?>" alt="<?=$arPart['BKEY']?> <?=$arPart['AKEY']?><?=$arPart['CRITERIA']?>"></a>
							</div>
							<div class="manufacturer-pr">
								<p><span class="info">Производитель: </span>
								<?=$arPart['BRAND']?></p>
								<p><span class="info">Цена: </span>
								<?php
								$available=false;
								if(isset($arResult['PRICES'][$arPart['PKEY']]))
									foreach($arResult['PRICES'][$arPart['PKEY']] as $price_arr) {
										$price=[];
										if($price_arr['AVAILABLE_NUM']>0) {
											$price[]= $price_arr['PRICE_CONVERTED'];
											$available=true;
										}
									}
									$price=getPrice($price);
									if($price>=100) $price=number_format($price, 0, ',', ' ');
									if($available) {
										echo $price, ' ','грн';
									} else echo '<span class="notinstock">под заказ</span>';
								?></p>
							</div>
							<div class="button-block">
								<a href="/autoparts/products/<?=$arPart['BRAND']?>/<?=$arPart['ARTICLE']?>">Подробнее</a>
								<div class="cart">
									<input type="button" value="" onclick="addToCart('40');" class="button hidden">
								</div>
							</div>
							
							<table class="attribute">
							<? 
							$AID=intval($arPart['AID']);
						
							$TDMCore->DBSelect("TECDOC");
							$rsProps = TDSQL::GetPropertys($AID);
							
							$arUnqs=[];
							$arProps=[];
							while($arProp = $rsProps->Fetch()){
								$Unq=$arProp['NAME'].$arProp['VALUE'];
								if(!in_array($Unq,$arUnqs)){
									$arUnqs[] = $Unq;
									$arProps[] = $arProp;
								}
							}
							
							foreach($arProps as $arProp){
								$arProp['NAME'] = str_replace('/мм?','/мм²',$arProp['NAME']);
								$arProp['NAME'] = str_replace('? ','Ø ',$arProp['NAME']);
								if(strpos($arProp['NAME'],'[')>0){
									$Dim = substr($arProp['NAME'],strpos($arProp['NAME'],'['));
									$arProp['NAME'] = str_replace(' '.$Dim,'',$arProp['NAME']);
									$Dim = str_replace('[','',$Dim); $Dim = str_replace(']','',$Dim);
									$arProp['VALUE'] = $arProp["VALUE"].' '.$Dim;
								}
								?>
								<tr><td class="tarig"><?=UWord($arProp['NAME'])?>: </td><td><?=$arProp['VALUE']?></td></tr>
								<?
							} ?>
							</table>
					</div><?php 
					$count_analogs++;
					if($count_analogs%4==0) echo '<div class="clearfix"></div>';
				} ?>
			</div>
		</div>
	</div>
<?php } ?>
<script>
	jQuery(document).ready(function() {
		var count=-1;
		var height=0;
		jQuery('.bx-viewport .image').each(function(el) {
			count++;
			if(jQuery(this).height()> height) 
				height=jQuery(this).height();
			if(count%4==3) {
				for(i=0;i>-4;i--) {
					var h=(height-jQuery('.bx-viewport .image').eq(count/1+i).height())/2;
					if(h>0)
					jQuery('.bx-viewport .image').eq(count/1+i).css('margin',h+'px 0');
				}
					height=0;
			}
		});
		/*for(var i=0; i<count%4; i++) {
			var h=(height-jQuery('.bx-viewport .image').eq(count-i).height)/2;
			if(h>0) jQuery('.bx-viewport .image').eq(count-i).css('margin',h+'px 0');
		}*/
	});
</script>	