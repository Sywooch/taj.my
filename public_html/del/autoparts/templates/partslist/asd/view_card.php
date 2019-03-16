<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();

function priceOrderSortMin($a, $b) {
	if ($a['productPrice'] === $b['productPrice']) return 0;
	return $a['productPrice'] > $b['productPrice'] ? 1 : -1;
}
function priceOrderSortMax($a, $b) {
	if ($a['productPrice'] === $b['productPrice']) return 0;
	return $a['productPrice'] < $b['productPrice'] ? 1 : -1;
}

for($stock_ordering_i=0;$stock_ordering_i<=1;$stock_ordering_i++) {
foreach($arResult['PARTS'] as $NumKey=>$arPart) {
	$arResult['PARTS'][$NumKey]['productPrice'] = 0;
	if(isset($arPart['PKEY'])&&isset($arResult['PRICES'][$arPart['PKEY']])&&is_array($arResult['PRICES'][$arPart['PKEY']])){
		foreach($arResult['PRICES'][$arPart['PKEY']] as $arPrice) {
			$stock_ordering==false;
			$arResult['PARTS'][$NumKey]['stockStatus']=false;
			$Prices=[];
			if(isset($arResult['PRICES'][$arPart['PKEY']])) {
				foreach($arResult['PRICES'][$arPart['PKEY']] as $arPrice){ 
					if($arPrice['AVAILABLE']>0) {
						$stock_ordering=true; 
						$arResult['PARTS'][$NumKey]['stockStatus']=true; 
						if ($arPrice['AKEY']==$arPrice['AKEY']&&$arPrice['AVAILABLE']>0) {
							$Prices[]=$arPrice['PRICE_CONVERTED'];
						}
					}	
				}
			}
			$arResult['PARTS'][$NumKey]['productPrice'] = getPrice($Prices);
			if($arResult['PARTS'][$NumKey]['productPrice']>=100) {
				$arResult['PARTS'][$NumKey]['productPriceFormated']=number_format($arResult['PARTS'][$NumKey]['productPrice'], 0, ',', ' ');
			}
		}
	
	}
}
if($_SESSION["TDM_SECPARTS_SORTING"]==3||$_SESSION["TDM_SECPARTS_SORTING"]<1) {
	uasort($arResult['PARTS'], 'priceOrderSortMin');
} elseif($_SESSION["TDM_SECPARTS_SORTING"]==6) {
	uasort($arResult['PARTS'], 'priceOrderSortMax');
} 
$Cnt=0;
foreach($arResult['PARTS'] as $NumKey=>$arPart)
	if(isset($arPart['PKEY'])&&isset($arResult['PRICES'][$arPart['PKEY']])&&is_array($arResult['PRICES'][$arPart['PKEY']])){
		if(($arResult['PARTS'][$NumKey]['stockStatus']&&$stock_ordering_i==0)||(!$arResult['PARTS'][$NumKey]['stockStatus']&&$stock_ordering_i==1)){
			$Cnt++; $PCnt=0; $cm=''; $AddF=0;
			//Criteria display method
			
			$arPart['IMG_SRC'] = imageLoader($arPart['IMG_SRC'],'http://77.120.224.229/');
			
			if(isset($arPart['CRITERIAS_COUNT'])&&$arPart['CRITERIAS_COUNT']>0){
				foreach($arPart['CRITERIAS'] as $Criteria=>$Value){ 
					if($Criteria!=''){$arPart['CRITERIA'].=$cm.$Criteria.' - '.$Value;}else{$arPart['CRITERIA'].=$cm.UWord($Value);} $cm='; ';
				}
			}?>
			<div class="tditem it" id="item<?=$arPart['PKEY']?>">
				<div class="name">
					<a href="/autoparts/products/<?=$arPart['BRAND']?>/<?=$arPart['ARTICLE']?>/" title="<?=$arPart['BKEY']?> <?=$arPart['AKEY']?>"><?=$arPart['BRAND']?> <?=$arPart['ARTICLE']?></a>
					<?php if(isset($arPart['CRITERIA'])) {?>
						<span class="criteria"><?=$arPart['CRITERIA']?></span>
					<?php } ?>
				</div>
				
				<div class="image">
					<div class="stock-label"><?php if($arResult['PARTS'][$NumKey]['stockStatus']) echo 'есть в наличии'; else echo 'под заказ'; ?></div>
					<a href="/autoparts/products/<?=$arPart['BRAND']?>/<?=$arPart['ARTICLE']?>" title="<?=$arPart['BRAND']?> <?=$arPart['ARTICLE']?>">
						<?if(isset($arResult['ART_LOGOS'][$arPart['AID']])&&$arResult['ART_LOGOS'][$arPart['AID']]!=''){?>
							<img src="<?=$arResult['ART_LOGOS'][$arPart['AID']]?>" class="productImage">
						<?}?>
						<?if(isset($PicText)&&$PicText!=''){?>
							<img src="/autoparts/media/images/nopic.jpg" class="photobox productImage">
						<?}else{?>
							<img src="<?=$arPart['IMG_SRC']?>" class="photobox productImage">
						<?}?>
					</a>
				</div>
				<div class="manufacturer-pr">
					
					<?if($AddF>0){?><div class="addphoto" title="<?=Lng('Photo_count',1,0);?>">x<?=($AddF+1)?></div><?}?>
					<?// Brand & article: ?>
					<?if(TDM_ISADMIN AND $arPart['LINK_CODE']!=''){$BrandClass='linked';?>
						<a href="/<?=TDM_ROOT_DIR?>/admin/dbedit.php?selecttable=Y&table=TDM_LINKS&LINK=<?=$arPart['LINK_LEFT_AKEY']?>" target="_blank" class="ttip link" title="<?=$arPart['LINK_INFO']?><br><?=$arPart['LINK_CODE']?>"></a>
					<?}else{$BrandClass='';}?>
					<?php 
						/* --------------------------
										<span>Тип:</span> <?=$arPart['NAME']?></b>
										<?if($arPart["AID"]>0){?>
											<a href="javascript:void(0)" OnClick="AppWin('<?=TDM_ROOT_DIR?>',<?=$arPart["AID"]?>,980)" class="carsapp" target="_blank" title="<?=Lng('Applicability_to_model_cars',1,0)?>"></a>
											<a href="/<?=TDM_ROOT_DIR?>/props.php?of=<?=$arPart["AID"]?>" class="dopinfo popup" target="_blank" title="<?=Lng('Additional_Information',1,0)?>"></a>
										<?}?>
						-------------------------------*/?>
				</div>
				<div class="price">
					<div class="prices">
					<?php if($arPart["PRICES_COUNT"]>0){?>
						<div class="pricetab">
							<?php 
							$productPrice = $arPart['productPrice'];
							if($productPrice>=100) {
								$productPrice=number_format($productPrice, 0, ',', ' ');
							}
							if($productPrice>0){ ?>
								<div class="priceVal">
									<span class="value"><?=$productPrice;?></span> <span class="curr">грн.</span>
								</div><?php 
								if($arResult['ADDED_PHID']==$arPrice['PHID']) { ?>
									<div class="cartadded">В корзине</div>
								<? } else { ?>
									<div><a href="javascript:void(0)" class="addtocart" OnClick="TDAddToCart('<?php echo $arPart['BKEY'],'/',$arPart['AKEY'];?>')" title="Добавить в корзину">Купить</a></div>
								<? }
							} else echo '<a class="preorder">Уточнить наличие</a>'; ?>
							</div>
						<?php 
					} ?>
					<input type="hidden" name="productBrand" value="<?=$arPart['BRAND']?>">
					</div>
				</div>
				<?if(TDM_ISADMIN&&$_GET['test']>0){?>
					<div class="article ttip "> 
						BKEY: <?=$arPart['BKEY']?><br>
						AKEY: <?=$arPart['AKEY']?><br>
						ID:<?=$arPart['AID']?>
					</div>
					<div><?php 
						if(is_array($arResult['PRICES'][$arPart['PKEY']]))
						foreach($arResult['PRICES'][$arPart['PKEY']] as $arPrice){
								if(TDM_ISADMIN) {
									if($PCnt>2){$HClass='ip'.$arPart['PKEY']; $HStyle='style="display:none;"';}else{$HStyle=''; $HClass='';}?>
										<a style="display:block;<?
												if($arPrice['AVAILABLE_NUM']<0)echo " color:red;";
											?>" href="<?php
												echo $arPrice['EDIT_LINK']
											?>" class="popup editprice">
											<?=$arPrice['PRICE_FORMATED']?> грн (<?=$arPrice['PRICE']?> <?=$arPrice['CURRENCY']?>)
										</a>
										<?
								
								}
						}?>
					</div>
				<?}
				$AID=intval($arPart['AID']);
				
				$TDMCore->DBSelect("TECDOC");
				$rsProps = TDSQL::GetPropertys($AID);
				unset($arProps);
				$arUnqs=Array();
				while($arProp = $rsProps->Fetch()){
					$Unq=$arProp['NAME'].$arProp['VALUE'];
					if(!in_array($Unq,$arUnqs)){
						$arUnqs[] = $Unq;
						$arProps[] = $arProp;								
					}
				}?>
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
			</div>
<?php }
}
}