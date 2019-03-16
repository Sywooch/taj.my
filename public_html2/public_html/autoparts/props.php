<?
require_once("tdmcore/defines.php");
require_once("tdmcore/init.php");
?>
<link rel="stylesheet" href="/<?=TDM_ROOT_DIR?>/styles.css" type="text/css">
<div style="padding:30px;">
<?
if($_GET['of']>0) $AID=intval($_GET['of']);
	else if($arPart['AID']>0) $AID=$arPart['AID'];
if($AID<=0){echo 'Error! Invalid number parameters.'; die();}

$TDMCore->DBSelect("TECDOC");
$rsProps = TDSQL::GetPropertys($AID);
$arUnqs=Array();
while($arProp = $rsProps->Fetch()){
	$Unq=$arProp['NAME'].$arProp['VALUE'];
	if(!in_array($Unq,$arUnqs)){
		$arUnqs[] = $Unq;
		$arProps[] = $arProp;
	}
}?>


<?$rsNums = TDSQL::LookupAnalog($AID,Array(2,3,5)); //2-Торговый, 3-Оригинальный, 4-Неоригинальный, 5-Штрих код
while($arNum = $rsNums->Fetch()){
	$arNums[] = $arNum;
}
if(count($arNums)>0){?>
	<table class="chartab" style="float:left;"><tr class="head"><td colspan="2"><?=Lng('Related_numbers',1,0)?>:</td><td><?=Lng('Number_type',1,0)?></td></tr>
	<?
	foreach($arNums as $arNum){$Srch='';
		if($arNum['ARTICLE']==""){continue;}
		if($arNum['TYPE']==2){$arNum['TYPE']='<span class="artkind_trade">'.Lng('Trade',1,0).'</span>'; $Srch='Y';}
		if($arNum['TYPE']==3){$arNum['TYPE']='<span class="artkind_original">'.Lng('Original',1,0).'</span>'; $Srch='Y';}
		if($arNum['TYPE']==4){$arNum['TYPE']='<span class="artkind_analog">'.Lng('Analog',1,0).'</span>'; $Srch='Y';}
		if($arNum['TYPE']==5){$arNum['TYPE']='<span class="artkind_barcode">'.Lng('Barcode',1,0).'</span>';}
		?>
		<tr><td class="tarig"><?=$arNum['BRAND']?></td>
			<td><?if($Srch=="Y"){?><a href="/<?=TDM_ROOT_DIR?>/search/<?=TDMSingleKey($arNum['ARTICLE'])?>/"><?}?><?=$arNum['ARTICLE']?></a></td>
			<td><?=$arNum['TYPE']?></td>
		</tr>
		<?
	}
	?>
	</table>
<?}?>