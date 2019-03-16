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
	<?if($arResult['MODELS_COUNT']>0){
			print_r($arResult);?>
		<?foreach($arResult['MODELS'] as $CurModel=>$arModels){
			$CurModel=trim($CurModel);
			/*if($arResult['MODEL_PICS'][$CurModel]=='/autoparts/media/models/default.jpg') {
				if(file_exists())
			}*/
			
			
			?>
			<div class="modelsdiv" style="background-image:url(<?=$arResult['MODEL_PICS'][$CurModel]?>);">
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
				<?}print_r($arResult['MODEL_PICS'][$CurModel]);?>
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
		$(document).ready(function() {
			jQuery('.modelall').css('min-height', jQuery('.modelall').height());
			
			jQuery('.modelsdiv').click(function() {
				if(false)if(!jQuery(this).hasClass('active')) {
					if(jQuery(this).find('a.ampick').size()>0)
						window.location.href=jQuery(this).find('a.ampick').attr('href');
					else {
						jQuery('.modelsdiv,.modelsfilter').not(jQuery(this)).finish().hide(330);
						jQuery(this).addClass('active');
						jQuery('.active .modelname').prepend('<span class="autoMark">'+jQuery('.autopic').attr('title')+' </span>');
						jQuery('.subModelNav').addClass('active').slideDown(330);
					}
				}
			});
			jQuery('.subModelNav').click(function() {
				jQuery('.subModelNav').removeClass('active').slideUp(660);
				jQuery('.active .modelname span.autoMark').remove();
				jQuery('.modelsdiv.active').removeClass('active');
				jQuery('.modelsdiv,.modelsfilter').finish().show(660);
			});
		});
	</script>
<?}?>

<?//echo '<pre>'; print_r($arResult); echo '</pre>';?>