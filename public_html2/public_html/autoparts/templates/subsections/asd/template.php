<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();?>
<link rel="stylesheet" href="/autoparts/templates/subsections/asd/style.css" type="text/css">
<h1><?=TDM_H1?></h1>
<?TDMShowBreadCumbs()?>
<hr style="width:86%;">
<div class="autopic" title="<?=$arResult['MFA_MFC_CODE']?>" style="background:url(<?=$arResult['BRAND_LOGO_SRC']?>)"></div>
<?=TDMShowSEOText("TOP")?>

<?jsLinkJqueryUi()?>
<script> 
	/*$(function(){
		$( "#subsections" ).accordion({active:false, collapsible: true, heightStyle:"30px"});
		$("#subsections a").click(function(){
			window.location = $(this).attr('href');
			return false;
		});
	}); */
</script>

<?if($arResult['CNT']>0){?>

	<table class="TecDocSubCat"><tr><td style="vertical-align:top;">
		<div class="rsecs" style="background-image:url(<?=$arResult['RSECTION_PICTURE']?>);">
			<div class="rseclinks">
			<?if(is_array($arResult['ROOT_SECTIONS'])){
				foreach($arResult['ROOT_SECTIONS'] as $arRSec){?>
					<a href="<?=$arRSec['LINK']?>" <?if($arRSec['ACTIVE']=="Y"){?>class="rsactive"<?}?> ><?=$arRSec['NAME']?></a>
				<?}
			}else{?>
				<a class="goBack" href="<?=$arRSec['RSEC_LINK']?>"><span>&#65513;</span> <?=Lng('All_sections',0,0)?></a>
				<script>jQuery(document).ready(function() { jQuery('.goBack').attr('href',$('.breadcumbs a:eq(-2)').attr('href'));  });</script>
			<?}?>
			</div>
		</div>
	</td><td width="90%" style="vertical-align:top;">
		
		<?if(!$arResult['FILTER_BY_TYPE'] AND TDM_ISADMIN){?>
			<div class="ignored_admin_note">The type of model is ignored - all subsections viewed</div>
		<?}
		
				
				$i=-1;
				$j=$sub=0;
				$arr=array();
		
		?>
		
		<div id="subsections">
<?		foreach($arResult['SECTIONS'][$arResult['ROOT_SID']] as $arSec){
			if($arSec['URL']=='' AND count($arResult['SECTIONS'][$arSec['STR_ID']])<=0){ continue; } 
			//Hide if TD childs was moved out
			
			if($arSec['URL']!='') {
				$url[$j]='<a href="'.$arResult['CSEC_LINK'].$arSec['URL'].'" class="rtlink">'.$arSec['NAME'].'</a>';
				$url_text[$j]=$arSec['NAME'];
				$j++;
			}
			else {
				$i++;
				$num=0;
				$title[$i]=$arSec['NAME'].":";
			}

			if(is_array($arResult['SECTIONS'][$arSec['STR_ID']]))
			foreach($arResult['SECTIONS'][$arSec['STR_ID']] as $arSec2){
					if($arSec2['URL']!='') { 
						if(is_array($arResult['SECTIONS'][$arSec2['STR_ID']])) {
							$arr[$i][$num]['title'];
						} else {
							$arr[$i][$num]='<a href="'.$arResult['CSEC_LINK'].$arSec2['URL'].'">'.$arSec2['NAME'].'</a>';
						}
						$num++;
					} else {
						$arr[$i][$num]['title']= $arSec2['NAME'];
					} 
					
				if(is_array($arResult['SECTIONS'][$arSec2['STR_ID']]))
				foreach($arResult['SECTIONS'][$arSec2['STR_ID']] as $arSec3) { 
					if($arSec3['URL']!='') { 
						$arr[$i][$num][$sub]['url']=$arResult['CSEC_LINK'].$arSec3['URL'];
						$arr[$i][$num][$sub]['name']=$arSec3['NAME'];
						$sub++;
					} else {
						$arr[$i][$num][$sub]['url']='#';
						$arr[$i][$num][$sub]['name']= $arSec3['NAME'];
					}
				}
			}
		}
		
		if(count($url_text)>0) {
			asort($url_text);
			echo '<div class="subCategoryBlock headerCatUrl"><div class="shead">Категории:</div><div class="sbody">';
			foreach($url_text as $key=>$val) {
				echo '<div class="shortPath">'.$url[$key].'</div>';
			}
			echo '</div></div>';
		} 
		
		if(count($title)>0) {
			asort($title);
			foreach($title as $key=>$val) {
				echo '<div class="subCategoryBlock">';
				if(isset($arr[$key])) {
					echo '<div class="shead">'.$val.'</div>
					<div class="sbody">';
					asort($arr[$key]);
					foreach($arr[$key] as $key2=>$arr2) {
						if(count($arr2)<1||!is_array($arr2)) {
							echo '<div class="level2">'.$arr2.'</div>';
						} else  {
							
							if(isset($arr2['title'])) {
								echo '<div class="subtitle">'.$arr2['title']."</div>";
							}
							asort($arr2);
							foreach($arr2 as $key3=>$sub) {
								if(isset($arr2[$key3]['url'])&&isset($arr2[$key3]['name']))
									echo '<div class="levl3"><a href="'.$arr2[$key3]['url'].'">'.$sub['name'].'</a></div>';
							}
						}
					}
					echo '</div>';
				}
				echo '</div>';
			}
		} ?>
		</div>
		
	</table>
	
<?}else{?>
	<br><br>
	<b><?=Lng('No_parts_for_model')?>...</b>
	<br><br><br><br>
<?}?>



<div class="tclear"></div>

<?=TDMShowSEOText("BOT")?>
<br>
<br>


<?//echo '<pre>'; print_r($arResult); echo '</pre>';?>