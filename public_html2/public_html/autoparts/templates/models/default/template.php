<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();

if($_POST['key']=='model') {
	$n=0;
	$json_id=[];
	foreach($arResult['MODELS'] as $CurModel=>$arModels) {
		foreach($arModels as $arModel) {
			if($_POST['years']>=1990&&(
						   $arModel['DATE_FROM']<=$_POST['years']
						&&( 
							!is_numeric($arModel['DATE_TO'])||
							$arModel['DATE_TO']=='До н.в.'||
							$arModel['DATE_TO']>=$_POST['years']))
			) {
				$CurModel=trim($CurModel);
				$modelsToJson[$n]['name']=$arModel['MOD_CDS_TEXT'];
				$modelsToJson[$n]['model_name']=$CurModel;
				$modelsToJson[$n]['url']=$arModel['URL'];
				$n++;
			} 
		}
	}
	exit(json_encode($modelsToJson, JSON_FORCE_OBJECT));
}
if($_POST['key']=='years2') {
	$n=0;
	$json_id=[];
	print_r($arResult['MODELS']);
	foreach($arResult['MODELS'] as $CurModel=>$arModels) {
		$CurModel=trim($CurModel);
		$modelsToJson[$n]=$CurModel;
		$n++;
	}
		exit(json_encode($modelsToJson, JSON_FORCE_OBJECT));
}
?>
<h1 class="entry-title"><?=TDM_H1?></h1>
<?TDMShowBreadCumbs()?>
<hr style="width:86%;">
<div class="autopic" title="<?=$arResult['MFA_MFC_CODE']?>" style="background:url(<?=$arResult['BRAND_LOGO_SRC']?>)"></div>
<div style="padding:3px;"></div>
<?=TDMShowSEOText("TOP")?>
<?if($arResult['MODELS_COUNT']>12){?>
	<script>var AllLng = '<?=Lng('All',1,0)?>'; ShowNFilter=1;</script>
	<div class="modelsfilter">
		<a href="javascript:void(0)"><?=Lng('All',1,0)?></a>
	</div>
<?}?>
<div class="subModelNav">
	◄ Выбрать другую модель
</div>
<div class="modelall">
	<?if($arResult['MODELS_COUNT']>0){?>
		<?foreach($arResult['MODELS'] as $CurModel=>$arModels){
			$CurModel=trim($CurModel);
			if(file_exists($_SERVER['DOCUMENT_ROOT'].'/autoparts/media/models/'.strtolower($arResult['UBRAND']).'/'.$CurModel.'.jpg')) {
				$arResult['MODEL_PICS'][$CurModel]='/autoparts/media/models/'.strtolower($arResult['UBRAND']).'/'.$CurModel.'.jpg';
			}
			?>
			<div class="modelsdiv model<?php echo str_replace(' ','-',mb_strtolower($CurModel)); ?>" style="background-image:url(<?=$arResult['MODEL_PICS'][$CurModel]?>);">
				<div class="modelname"><?=$CurModel?></div>
				<?if(count($arModels)<=1){
					$arModel = $arModels[0];
					$arModel['MOD_CDS_TEXT'] = str_replace(trim($CurModel),'',$arModel['MOD_CDS_TEXT']);
					$arModel['MOD_CDS_TEXT'] = str_replace('[USA]','(US)',$arModel['MOD_CDS_TEXT']);?>
					<a href="<?=$arModel['URL']?>" class="ampick" title="<?=$arModel['MOD_CDS_TEXT']?> <?=$arModel['DATE_FROM']?> - <?=$arModel['DATE_TO']?>"><?=$arModel['MOD_CDS_TEXT']?> <?=$arModel['DATE_FROM']?> - <?=$arModel['DATE_TO']?></a>
				<?}else{?>
					<div class="submodels">
						<?foreach($arModels as $arModel){?>
							<h3><a href="<?=$arModel['URL']?>"><?=$arModel['MOD_CDS_TEXT']?> <?=$arModel['DATE_FROM']?> - <?=$arModel['DATE_TO']?></a></h3>
						<?}?>
					</div>
				<?}/*print_r($arResult['MODEL_PICS'][$CurModel]);*/?>
			</div>
			<?
		}?>
	<?}else{?>
		<?=Lng('No_models');?> ...
	<?}?>
</div>
<div class="tclear"></div>
<?=TDMShowSEOText("BOT")?>
<br>
<br>
<a href="/<?=TDM_ROOT_DIR?>/" class="bglink">&#9668; <?=Lng('Back_brand_selection')?></a>

<?if($arResult['MODELS_COUNT']>0){?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('.modelall').css('min-height', jQuery('.modelall').height());
			
			jQuery('.modelsdiv').click(function() {
				if(!jQuery(this).hasClass('active')) {
					if(jQuery(this).find('a.ampick').size()>0)
						window.location.href=jQuery(this).find('a.ampick').attr('href');
					else {
						history.pushState('','',document.location.pathname+jQuery(this).find('.modelname').text().replace(" ","-")+'/');
						jQuery('.modelsdiv,.modelsfilter').not(jQuery(this)).finish().hide(0);
						jQuery(this).addClass('active');
						jQuery('.active .modelname').prepend('<span class="autoMark">'+jQuery('.autopic').attr('title')+' </span>');
						jQuery('.subModelNav').addClass('active').slideDown(330);
						jQuery('html, body').animate({
							scrollTop: jQuery('h1').eq(0).offset().top
						}, 800);
					}
				}
			});
			jQuery('.subModelNav').click(function() {
				history.pushState('','',jQuery('.subModelNav').attr('attr-href').replace(" ","-"));
				jQuery('html, body').animate({scrollTop: $("h1").eq(0).offset().top }, 500);
				jQuery('.subModelNav').removeClass('active').slideUp(660);
				jQuery('.active .modelname span.autoMark').remove();
				jQuery('.modelsdiv.active').removeClass('active');
				jQuery('.modelsdiv,.modelsfilter').finish().show(660);
			});
			
			<?php if($_GET['submodel']!='') { ?>
				var submodelblock=jQuery(".model<?php echo mb_strtolower($_GET['submodel']); ?>");
				if(submodelblock.size()>0) {
					jQuery('.modelsdiv,.modelsfilter').not(submodelblock).finish().hide(0);
					submodelblock.addClass('active');
					jQuery('.active .modelname').prepend('<span class="autoMark">'+jQuery('.autopic').attr('title')+' </span>');
					jQuery('.subModelNav').addClass('active').slideDown(330);
					jQuery('.subModelNav').attr('attr-href',window.location.href.slice(0,-1).replace(/\/[^\/]+$/, '')+"/");
				} else {
					history.pushState('','',window.location.href.slice(0,-1).replace(" ","-").replace(/\/[^\/]+$/, '')+"/");
				}
			<?php } else { ?>
				jQuery('.subModelNav').attr('attr-href', document.location.href);
			<?php } ?>
			
		});
	</script>
<?}?>

<?//echo '<pre>'; print_r($arResult); echo '</pre>';?>