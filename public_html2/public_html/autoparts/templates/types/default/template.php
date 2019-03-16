<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();
if($_POST['key']=='model') {
	$n=0;
		foreach($arResult['TYPES'] as $types) {
			if($types['START']<=$_POST['years']
					&&( !is_numeric($types['END'])||$types['END']=='До н.в.'
						||$types['END']>=$_POST['years'])
			) {
				$typesToJson[$n]['name']=$types['TYP_CDS_TEXT'];
				$typesToJson[$n]['v']=round($types['TYP_CCM'],-2)/1000;
				$typesToJson[$n]['url']=$types['URL'];
				$typesToJson[$n]['engine']=$types['ENG_CODE'];
				$typesToJson[$n]['fuel']=$types['TYP_FUEL_DES_TEXT'];
				
				$typesToJson[$n]['cylinders']=$types['TYP_CYLINDERS'];
				$n++;
			}
		}
		exit(json_encode($typesToJson, JSON_FORCE_OBJECT));
}
?>
<h1 class="entry-title"><?=TDM_H1?></h1>
<?TDMShowBreadCumbs()?>
<hr style="width:86%;">
<div class="autopic" title="<?=$arResult['MFA_MFC_CODE']?>" style="background:url(<?=$arResult['PIC_SRC']?>);<?if($arResult['PIC_TYPE']=='MODEL_TYPE'){?>width:180px;height:110px;<?}?>"></div>
<?=TDMShowSEOText("TOP")?>

<table class="corp_table">
	<tr class="head"><td><?=Lng('Model')?></td><td><?=Lng('Year_construction')?></td><td><?=Lng('Engine')?></td>
		<td><?=Lng('Power')?></td><td><?=Lng('Capacity')?></td><td><?=Lng('Cylinder')?></td><td><?=Lng('Fuel')?></td>
		<td><?=Lng('Body')?></td><td></td><?/*<td><?=Lng('Axis')?></td>*/?>
	</tr>
	<?foreach($arResult['TYPES'] as $arType){
		echo '<tr class="gtr pads">';
		echo '<td><a class="dblock" href="'.$arType['URL'].'">'.$arType['TYP_CDS_TEXT'].'</a></td>';
		echo '<td>'.$arType['START'].' - '.$arType['END'].'</td>';
		echo '<td>'.$arType['ENG_CODE'].'</td>';
		echo '<td>'.$arType['TYP_KW_FROM'].' <span>'.Lng('Kv',1,0).'</span> - '.$arType['TYP_HP_FROM'].' <span>'.Lng('Hp',1,0).'</span></td>';
		echo '<td>'.$arType['TYP_CCM'].' <span>'.Lng('sm',1,0).'<sup>3</sup></span></td>';
		echo '<td>'.$arType['TYP_CYLINDERS'].'</td>';
		echo '<td>'.$arType['TYP_FUEL_DES_TEXT'].'</td>';
		echo '<td>'.$arType['TYP_BODY_DES_TEXT'].'</td>';
		echo '<td><a class="dblock nextstep" href="'.$arType['URL'].'">Выбрать</a></td>';
		//echo '<td>'.$arType['TYP_AXLE_DES_TEXT'].'</td>';
		echo '</tr>';
	}?>
</table>


<div class="tclear"></div>

<?=TDMShowSEOText("BOT")?>
<br>
<br>
<a href="/<?=TDM_ROOT_DIR?>/<?=$arResult['BRAND']?>/" class="bglink">&#9668; <?=Lng('Back_model_selection')?> <?=$arResult['UBRAND']?></a>


<?//echo '<pre>'; print_r($arResult); echo '</pre>';?>