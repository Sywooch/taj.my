<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();
if($_GET['t']==1) echo '<br><br>'.json_encode($arResult['PARTS']).'<br><hr>';
if($_POST['getcategorynames']>0) {
		$namejson=[];
		$n=0;
	foreach($arResult['PARTS'] as $NumKey=>$arPart) /*if($arPart['AID']>1) */
	{
		if($_POST['getfullinfo']==1) { 
			if(($_GET['article']==$arPart['AKEY']&&$_GET['brand']==$arPart['BKEY'])||$_POST['admin']==1) {
				$namejson[$n]['AKEY']=$arPart['AKEY'];
				$namejson[$n]['BKEY']=$arPart['BKEY'];
				$namejson[$n]['CATEGORY']=$arPart['TD_NAME'];
				$namejson[$n]['IMG']=$arPart['IMG_ADDITIONAL'];
				$namejson[$n]['PRICE']=$arResult['PRICES'][$arPart['PKEY']];
				$namejson[$n]['NAME']=$arPart['TD_NAME'];
				$namejson[$n]['ALL']=$arPart;
				$n++;
				
			} // NO ELSE, ONLY ==
		} else {
			$item_all=$arPart['TD_NAME'];
			
			$split=preg_split('[,|;]',$item_all);
			foreach($split as $item) {
				$namejson[$n]['AKEY']=$arPart['AKEY'];
				$namejson[$n]['BKEY']=$arPart['BKEY'];
				$namejson[$n]['CATEGORY']=$item;
				$n++;
			}
			
		}
	}
	die(json_encode($namejson, JSON_UNESCAPED_UNICODE));
} 


if($_POST['addtocard']==true) {
	foreach($arResult['PARTS'] as $NumKey=>$arPart)
	if(($_GET['article']==$arPart['AKEY']&&$_GET['brand']==$arPart['BKEY'])) {
		echo $arPart['AKEY'].$arPart['BKEY'];
		if($_POST['quantity']<1) $quantity=1; else $quantity=$_POST['quantity'];
		
		session_start();
		
		if(is_array($_SESSION['cart'])) {
			$cart=$_SESSION['cart'];
			if($arPart['AID']>0) {
				$key = array_search($arPart['AID'], array_column($_SESSION['cart'],'product_id'));
				if(!$key&&($key===0||$key>0)) {
					$_SESSION['cart'][$key]['quantity']+=$quantity;
					die('true;'.$key); 
					//END
				} 
			}
		}
			$stock_all_price=[];
			$stock_all_price_n=0;
			//SET PRICE 
			if(isset($arResult['PRICES'][$arPart['PKEY']])) {
				foreach($arResult['PRICES'][$arPart['PKEY']] as $arPriceKey){ 
					//print_r($arPriceKey);
					if ($arPriceKey['AKEY']==$arPart['AKEY']&&$arPriceKey['AVAILABLE_NUM']>0) {
						$stock_all_price[]=$arPriceKey['PRICE_CONVERTED'];
					}
					if($_GET['t']==1) var_dump($arPriceKey);
				} 
			}
			
			$productPrice = getPrice($stock_all_price);
			//SET ID 
			if($arPart['AID']<1) $I_ID=rand(9999999999,999999999999 ); else $I_ID=$arPart['AID'];
			if($arPart["ARTICLE"]=='') $art=$arPart["AKEY"]; else $art=$arPart["ARTICLE"];
			if($arPart["BRAND"]=='') $brand=$arPart["BKEY"]; else $art=$arPart["BRAND"];
			
			// SET NEW PRODUCT ARRAY 
			
			$addcard["tecdoc"]				="Y";
			$addcard["product_id"]			=$I_ID;
			$addcard["key"]					="0123";
			$addcard["AKEY"]				=$arPart["AKEY"];
			$addcard["BKEY"]				=$arPart["BKEY"];
			$addcard["price"]				=$productPrice;
			$addcard["quantity"]			=$quantity;
			$addcard["stock"]				="100";
			$addcard["name"]				=$arPart['NAME'].' '.$brand;
			$addcard["image"]				=imageLoader($arPart['IMG_SRC'],'http://77.120.224.229/');
			$addcard["brand"]				=$arPart["BRAND"];
			$addcard["product_url"]			="/autoparts/products/".$arPart['BKEY']."/".$arPart['AKEY']."/";
			$addcard["day"]					="0";
			$addcard["article"]				=$art;
			$addcard["reward"]				=0;
			$addcard["minimum"]				=1;
			$addcard["weight"]				="";
			$addcard["weight_prefix"]		="";
			$addcard["weight_class_id"]		=2;
			$addcard["points"]				="" ;
			$addcard["points_prefix"]		="Шт..";
			
			$addcard["option"][0]["name"]			="Артикул";
			$addcard["option"][0]["option_value"]	=$art;
			$addcard["option"][0]["type"]			="text";
			$addcard["option"][1]["name"]			="Поставщик";
			$addcard["option"][1]["option_value"]	="";
			$addcard["option"][1]["type"]			="text";
			$addcard["option"][2]["name"]			="Срок поставки (дней)";
			$addcard["option"][2]["option_value"]	="0";
			$addcard["option"][2]["type"]			="text";
			$addcard["option"][3]["name"]			="Наличие";
			$addcard["option"][3]["option_value"]	="30";
			$addcard["option"][3]["type"]			="text";
			$addcard["option"][4]["name"]			="Price";
			$addcard["option"][4]["option_value"]	=$productPrice." UAH";
			$addcard["option"][4]["type"]			="text";
			$addcard["option"][5]["name"]			="Date";
			$addcard["option"][5]["option_value"]	=date("m.d.y");
			$addcard["option"][5]["type"]			="text";
			$addcard["option"][6]["name"]			="Code";
			$addcard["option"][6]["option_value"]	="";
			$addcard["option"][6]["type"]			="text";
			
			$_SESSION['cart'][]=$addcard;
			die(json_encode($addcard));
	}
}
?>
<?php
if(count($arResult['PARTS'])>0){?>
<div class="tclear"></div>
<div class="productpage">
	<?// VIEWS
	//if($arResult['VIEW']=="CARD"){
		include('view_card.php');
//	}elseif($arResult['VIEW']=="LIST"){
//		include('view_list.php');
	//}?>
</div>
<?php
}else{
	$err404name="Товар не найден";
	require_once('templates/noproduct/temptation.php');
}?>	
	<script>
		jQuery(function($){
			$(document).ready(function() {
				$('#search ul #tecdoc').removeClass('active');
				$('#search ul #tecdoc > li').addClass('active');
				$('input[name=\'search\']').attr('value', "<?=$_REQUEST['article']?>");
				$('.button-search').click();
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

<?
/*
if($arResult['PAGINATION']['TOTAL_PAGES']>1 AND $arResult['PAGINATION']['ITEMS_ON_THIS_PAGE']>6){?>
	<br>
	<?TDMShowPagination($arResult['PAGINATION'],Array(
		"PAGE_TEXT"=>"Y",
		"TOTAL_TEXT"=>Lng('Total_items',1,0),
		"PAGES_DIAPAZON"=>6,
	))?>
	<div class="tclear"></div>
	<hr>
<?}
*/
?>



<?=TDMShowSEOText("BOT")?>

<script>
	jQuery(document).ready(function(){
		/*$(".cbx_imgs").colorbox({ current:'', innerWidth:900, innerHeight:600, onComplete:function(){$('.cboxPhoto').unbind().click($.colorbox.next);} });
		$(".cbx_chars").colorbox({rel:false, current:'', overlayClose:true, arrowKey:false, opacity:0.6});
		*/
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
		if(i%4!=0) {
			for(j=i-i%4;j<i;j++)
				jQuery(".tditem.it .name").eq(j).height(Math.max.apply(null,h));
		}
		$('body').on('click', '[name="fast_button"]', function(){
			if(jQuery('.fast_order input[name="fast_phone"]').val().length>6) {
				var phone = $('[name="fast_phone"]').val();
				var name = jQuery('h1.name').text();
				$.post( "order.php", {
					phone: phone,
					page: document.location.href,
					productName : name.trim()
				})
				.done(function( data ) {
					fastOrderDialog.dialog( "open" );
					jQuery('.fast_order').hide();
				});
			} else {
				jQuery('.fast_order input[name="fast_phone"]').css('border-color','red');
			}
		});
		checkAvDialog = jQuery( "#checkAvailability" ).dialog({
		  autoOpen: false,
		  width: 350,
		  modal: true,
		  buttons: {
			"Отправить заявку": checkAvailability,
			"Отменить": function() {
			  checkAvDialog.dialog( "close" );
			}
		  }
		});
		fastOrderDialog = jQuery( "#fastOrderSubmit" ).dialog({
		  autoOpen: false,
		  width: 350,
		  modal: true,
		  buttons: {
			"Закрыть": function() {
			  fastOrderDialog.dialog( "close" );
			}
		  }
		});
		AppsList = jQuery( "#AppsList" ).dialog({
		  autoOpen: false,
		  width: '80%',
		  modal: false,
		  buttons: {
			"Закрыть": function() {
			  AppsList.dialog( "close" );
			}
		  }
		});
		jQuery('.apps a').click(function(e) {
			e.preventDefault();
			jQuery('#AppsList').load(this.href);
			AppsList.dialog('open');
		});
		jQuery( "input#button-cart.notinstock" ).on( "click", function() {
			jQuery('#checkAvailability .errPhone').hide();
			jQuery('#checkAvailability').attr('title', jQuery(this).attr('title'));
			checkAvDialog.dialog( "open" );
		});
		jQuery('.ui-widget-overlay.ui-front').click(function() {
			checkAvDialog.dialog( "close" );
		});
		
		jQuery('input[name="fast_phone"], input#checkAvPhone').mask('+38(000) 000 00 00');	
		jQuery('input[name="fast_phone"], input#checkAvPhone').focus(function() {
			if(jQuery(this).val()==''||jQuery(this).val('+38')=='')
				jQuery(this).val('+38');
		});
	});
	function checkAvailability() {
		if(jQuery('#checkAvPhone').val().length<6) {
			jQuery('#checkAvailability .errPhone').show();
		} else {
			var phone = $('input#checkAvPhone').val();
			var name = jQuery('h1.name').text();
			$.post( "order.php", {
				phone: phone,
				page: document.location.href,
				productName : name.trim()
			})
			.done(function( data ) {
				checkAvDialog.dialog( "close" );
				fastOrderDialog.dialog( "open" );
			});
		}
		
	}
</script>
<div class="hidden">
	<div id="checkAvailability" title="Уточнить наличие">
	  <form>
		<fieldset>
		  <label for="phone">Телефон
		  <input type="text" name="phone" id="checkAvPhone" value="+38" placeholder="+38(___) ___ __ __"></label>
		  <p class="errPhone" style="display:none;">Введите номер телефона.</p>
		  <!-- Фикс субмита по ентеру -->
		  <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
		</fieldset>
	  </form>
	</div>
	<div id="AppsList" title="Совместимость с авто:">
		<div class="loading">Загрузка</div>
	</div>
	<div id="fastOrderSubmit" title="Заказ оформлен">
		<p>
			<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
			Наш оператор свяжется с Вами ближайшее время.
		</p>
	</div>
</div>