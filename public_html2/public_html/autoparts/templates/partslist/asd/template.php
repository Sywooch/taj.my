<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();?>
<link rel="stylesheet" href="/<?=TDM_ROOT_DIR?>/media/js/colorbox/cmain.css" />
<?jsLinkFormStyler()?>
<script>AddFSlyler('select');</script>

	
<div class="tclear"></div>
<h1><?=TDM_H1?></h1>
<?TDMShowBreadCumbs()?>
<hr style="width:86%;">
<div class="autopic" title="<?=$arResult['MFA_MFC_CODE']?>" style="background:url(<?=$arResult['BRAND_LOGO_SRC']?>)"></div>
<?=TDMShowSEOText("TOP")?>

<?if(count($arResult['PARTS'])>0){?>
<?if($arResult['SHOW_FILTER_BRANDS']==1 AND $arResult['ALL_BRANDS_COUNT']>0 AND ($arResult['PAGINATION']['TOTAL_PAGES']>1 OR $arResult['FILTERED_BRANDS_COUNT']>0) ){?>
	<script>FIRST_PAGE_LINK='<?=$arResult['FIRST_PAGE_LINK']?>';</script>
	<div class="filterdiv">
		<div class="bftitle"><?=Lng('Filter_by_manufacturer',1,0)?>: </div>
		<?if($arResult['ALL_BRANDS_COUNT']>$arResult['LETTERS_LIMIT']){?>
			<div class="letfilter"><?foreach($arResult['ALL_BRANDS_LETTERS'] as $LET){?><a href="javascript:void(0)"><?=$LET?></a><?}?></div><div class="tclear"></div>
			<script>ShowLettersFilter=1;</script>
			<div class="allbrands">
				<?foreach($arResult['ALL_BRANDS'] as $BKEY=>$BRAND){
					if($arResult['AB_MIN_PRICE_F'][$BKEY]>0){$MinPrice='<i>'.Lng('from',2,0).'</i> <span>'.$arResult['AB_MIN_PRICE_F'][$BKEY].'</span>';}else{$MinPrice='';}?>
					<a href="javascript:void(0)" class="bfname" OnClick="AddBrandFilter('<?=$BKEY?>')"><?=$BRAND?> <?=$MinPrice?></a>
				<?}?>
			</div>
			<div class="tclear"></div>
			<?if($arResult['FILTERED_BRANDS_COUNT']>0){?>
				<div class="allbrands" style="padding-top:10px;">
					<div class="filteredby"><?=Lng('Filtered_by',1,0)?>: </div>
					<?foreach($arResult['FILTERED_BRANDS'] as $BKEY=>$BRAND){
						if($arResult['AB_MIN_PRICE_F'][$BKEY]>0){$MinPrice='<i>'.Lng('from',2,0).'</i> <span>'.$arResult['AB_MIN_PRICE_F'][$BKEY].'</span>';}else{$MinPrice='';}?>
						<a href="javascript:void(0)" class="remove" OnClick="RemoveBrandFilter('<?=$BKEY?>')"><?=$BRAND?> <?=$MinPrice?> <div class="delimg"></div></a>
					<?}
					if($arResult['FILTERED_BRANDS_COUNT']>1){?>
						<a href="javascript:void(0)" class="removeall" OnClick="RemoveBrandFilter('BFRA')"><div></div></a>
					<?}?>
				</div>
			<?}?>
		<?}else{?>
			<div class="allbrands">
				<?foreach($arResult['ALL_BRANDS'] as $BKEY=>$BRAND){
					if($arResult['AB_MIN_PRICE_F'][$BKEY]>0){$MinPrice='<i>'.Lng('from',2,0).'</i> <span>'.$arResult['AB_MIN_PRICE_F'][$BKEY].'</span>';}else{$MinPrice='';}
					if(array_key_exists($BKEY,$arResult['FILTERED_BRANDS'])){?>
						<a href="javascript:void(0)" class="remove" OnClick="RemoveBrandFilter('<?=$BKEY?>')"><?=$BRAND?> <?=$MinPrice?> <div class="delimg"></div></a>
					<?}else{?>
						<a href="javascript:void(0)" class="bfname" OnClick="AddBrandFilter('<?=$BKEY?>')"><?=$BRAND?> <?=$MinPrice?></a>
					<?}?>
				<?}?>
				<?if($arResult['FILTERED_BRANDS_COUNT']>1){?>
					<a href="javascript:void(0)" class="removeall" OnClick="RemoveBrandFilter('BFRA')"> <?=$MinPrice?> <div></div></a>
				<?}?>
			</div>
			
		<?}?>
		<div class="tclear"></div>
	</div>
	<hr>
<?}?>

<div class="sortingBlock">
	<div class="ProductSorting">
		<div class="sortdiv">
			<form action="<?=$arResult['FIRST_PAGE_LINK']?>" id="sortform" method="post">
				<span><?=Lng('Sort_by',1,0)?>: </span>
				<select name="SORT" id="sortby" class="styled" style="width:300px;" OnChange="$('#sortform').submit();">
					<option value="1" ><?=Lng('Sort_brand_rating_price',1,0)?></option>
					<option value="2" <?if($arResult['SORT']==2){echo 'selected';}?> ><?=Lng('Sort_description_price',1,0)?></option>
					<option value="3" <?if($arResult['SORT']==3){echo 'selected';}?> ><?=Lng('Sort_lowest_price',1,0)?></option>
					<option value="6" <?if($arResult['SORT']==6){echo 'selected';}?> >Наибольшей цене</option>
					<option value="4" <?if($arResult['SORT']==4){echo 'selected';}?> ><?=Lng('Sort_lowest_delivery_time',1,0)?></option>
					<option value="5" <?if($arResult['SORT']==5){echo 'selected';}?> ><?=Lng('Sort_photo_available',1,0)?></option>
				</select>
			</form>
		</div>
		<?if($arResult['PAGINATION']['TOTAL_PAGES']>1){?>
			<?TDMShowPagination($arResult['PAGINATION'],Array(
				"PAGE_TEXT"=>"Y",
				"TOTAL_TEXT"=>Lng('Total_items',1,0),
				"PAGES_DIAPAZON"=>6,
			))?>
		<?}?>
	</div>
	<hr>
</div>
<?if($arResult['GROUP_NAME']!=''){?>
	<div class="pricetype">
		<?=Lng('Your_prices_level')?>: <b><?=$arResult['GROUP_NAME']?> 
		<?if($arResult['GROUP_VIEW']==2){echo '('.$arResult['GROUP_DISCOUNT'].'%)';}?></b>
	</div>
<?}?>
<div class="tclear"></div>
<div class="product-grid box-product">
	<?// VIEWS
	//if($arResult['VIEW']=="CARD"){
		include('view_card.php');
//	}elseif($arResult['VIEW']=="LIST"){
//		include('view_list.php');
	//}?>
</div>
	<?php if(!count($arResult['PARTS'])>0){
		$err404name="Товары не найдены";
		$search_list=0;
		require_once('templates/search_list/list.php');
		if($search_list<1) {
			require_once('templates/noproduct/temptation.php');
			echo '<style>.sortingBlock {display:none;}</style>';
		}
	}
} else{
	$err404name="Товары не найдены";
	$search_list=0;
		require_once('templates/search_list/list.php');
		if($search_list<1) {
			require_once('templates/noproduct/temptation.php');
			echo '<style>.sortingBlock {display:none;}</style>';
		}
}?>	
	
	<script>
		jQuery(function($){
			$(document).ready(function() {
				$('#search ul #tecdoc').removeClass('active');
				$('#search ul #tecdoc > li').addClass('active');
				$('input[name=\'search\']').attr('value', "<?=$_REQUEST['article']?>");
				//$('.button-search').click();
			});
				var i=1;
				var h=[0];
				jQuery(".tditem.it .name").each(function() {
					if(i%4==0) {
						for(j=0;j<4;j++)
							jQuery(".tditem.it .name").eq(j).height(Math.max.apply(null,h));
					}
					h[i%4]=jQuery(this).height();
					i++;
				});
				if(i<=4) jQuery(".tditem.it .name").height(Math.max.apply(null,h));
		});
	</script>


<div class="tclear"></div>

<?if($arResult['PAGINATION']['TOTAL_PAGES']>1 AND $arResult['PAGINATION']['ITEMS_ON_THIS_PAGE']>6){?>
	<br>
	<?TDMShowPagination($arResult['PAGINATION'],Array(
		"PAGE_TEXT"=>"Y",
		"TOTAL_TEXT"=>Lng('Total_items',1,0),
		"PAGES_DIAPAZON"=>6,
	))?>
	<div class="tclear"></div>
	<hr>
<?}?>



<?=TDMShowSEOText("BOT")?>
<br>
<br>


<script>
	$(document).ready(function(){
		
		var i=1;
		var h=[0];
		jQuery(".tditem.it .name").each(function() {
			if(i%4==0) {
				for(j=i-4;j<i;j++)
					jQuery(".tditem.it .name").eq(j).height(Math.max.apply(null,h));
			}
			h[i%4]=jQuery(this).height();
			i++;
		});
		if(i%4!=0) 
			for(j=i-i%4;j<i;j++)
				jQuery(".tditem.it .name").eq(j).height(Math.max.apply(null,h));
	
		dialog = $( "#checkAvailability" ).dialog({
			  autoOpen: false,
			  width: 350,
			  modal: true,
			  buttons: {
				"Отправить заявку": checkAvailability,
				"Отменить": function() {
				  dialog.dialog( "close" );
				}
			  }
		  });

		$( ".tdm_content .preorder" ).button().on( "click", function() {
			
			jQuery('#checkAvailability .errPhone').hide();
			jQuery('#checkAvProduct').val(jQuery(this).closest('.tditem.it').find('.name>a').text());
			//jQuery('#checkAvailability').attr('title', jQuery(this).attr('title'));
			dialog.dialog( "open" );
		});
		$('.ui-widget-overlay.ui-front').click(function() {
			dialog.dialog( "close" );
		});
	});
	function checkAvailability() {
		if(jQuery('#checkAvPhone').val().length<6) {
			jQuery('#checkAvailability .errPhone').show();
		} else {
			$.post( "order.php", {
					phone: jQuery('input#checkAvPhone').val(),
					page: document.location.href,
					productName : jQuery('input#checkAvProduct').val()
				})
				.done(function( data ) {
					dialog.dialog( "close" );
					jQuery('.fast_order').hide();
				});
		}
		
	}
		 
</script>
<div id="checkAvailability" title="Уточнить наличие">
 
  <form>
    <fieldset>
      <label for="phone">Телефон
      <input type="text" name="phone" id="checkAvPhone" value="" placeholder="+38(___) ___ __ __"></label>
	  <input type="hidden" value="" name="product" id="checkAvProduct">
	  <p class="errPhone" style="display:none;">Введите номер телефона.</p>
      <!-- Фикс субмита по ентеру -->
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>
<?//echo '<pre>'; print_r($arResult); echo '</pre>';?>