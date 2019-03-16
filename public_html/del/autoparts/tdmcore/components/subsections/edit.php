<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();?>
<?
$RSID = intval($_REQUEST['sec_id']);
if($RSID<=0){ErAdd('Root section ID is not set');}
//Save changes
if($_POST['editme']=="Y"){
	if($_POST['TEMPLATE']==""){ErAdd(Lng('A_required_field')." - ".Lng('Template'),1);}
	if(ErCheck()){
		$arACTIVE = $arComSets['ACTIVE']; //Add records of other brands models to
		$arACTIVE[$RSID] = $_POST['ACTIVE'];
		$arNAME = $arComSets['NAME'];
		foreach($_POST['NAME'] as $nSID=>$nVal){ $nVal=trim($nVal);  $arNAME[$nSID] = $nVal; }
		$arCODE = $arComSets['CODE'];
		foreach($_POST['CODE'] as $nSID=>$nVal){ $nVal=trim($nVal); if($nVal!=''){ $arCODE[$nSID] = StrForURL($nVal);} }
		$arPARENT = $arComSets['PARENT'];
		foreach($_POST['PARENT'] as $nSID=>$nVal){ $nVal=trim($nVal); if($nVal!=''){ $arPARENT[$nSID] = intval($nVal);} }
		$arIGNORE = $arComSets['IGNORE'];
		$arIGNORE[$RSID] = intval($_POST['IGNORE']);
		$SvRes = TDMSaveSetsFile(TDMGetSetsPath($CompCode),"arComSets",Array(
			Array("S","TEMPLATE",$_POST['TEMPLATE']),
			Array("I","CACHE",intval($_POST['CACHE'])),
			Array("A","IGNORE",$arIGNORE,Array(1,1,0,0)),
			Array("A","ACTIVE",$arACTIVE,Array(1,1,0,0)), //WithKeys,NewLine,KeyStr,ValStr
			Array("A","NAME",$arNAME,Array(1,1,0,1)),
			Array("A","PARENT",$arPARENT,Array(1,1,0,0)),
			Array("A","CODE",$arCODE,Array(1,1,0,1)),
		));
		if($SvRes){
			NtAdd(Lng("Settings_saved"));
			$arComSets = TDMGetSets($CompCode);
			
			//clear cache
			array_map('unlink', glob(TDM_PATH.'/tdmcore/cache/'.$CompCode.'/*'));
		}else{ErAdd("False to save settings!",2);}
	}
}

$TDMCore->DBConnect("TECDOC");
$arSections = Array();
$rsSec2 = TDSQL::GetSections(0,$RSID,'DESCENDANTS');
while($arSec2 = $rsSec2->Fetch()){
	$arSections[] = $arSec2;
	$rsSec3 = TDSQL::GetSections(0,$arSec2['STR_ID']);
	while($arSec3 = $rsSec3->Fetch()){
		$arSections[] = $arSec3;
		$rsSec4 = TDSQL::GetSections(0,$arSec3['STR_ID']);
		while($arSec4 = $rsSec4->Fetch()){
			$arSections[] = $arSec4;
		}
	}
}

//Section picture
$SPicSrc = '/'.TDM_ROOT_DIR.'/media/sections/'.$RSID.'.jpg';
if(file_exists($_SERVER["DOCUMENT_ROOT"].$SPicSrc)){$RSPICTURE = $SPicSrc;}
else{$RSPICTURE = '/'.TDM_ROOT_DIR.'/media/sections/default.png';}

$arRComSets = TDMGetSets('sections');
foreach($arRComSets["CODE"] as $RtSID=>$RCode){
	$RtName = Lng($arRComSets["NAME"][$RtSID],0,0);
	if($RtName!=''){$arRSecs[$RtSID]=$RtName;}else{$arRSecs[$RtSID]='- '.UWord($RCode);}
}
?>
<?ErShow();?>
<div class="secrpic" style="background-image:url(<?=$RSPICTURE?>);"></div>


<table class="formtab" >
<tr>
	<td class="fname"><?=Lng('Section')?>: </td>
	<td class="fvalues">
		<select name="RSECTION" style="width:300px;" onchange="window.location = '?to=subsections&brand=<?=$_REQUEST['brand']?>&sec_id='+$(this).val();">
			<?FShowSelectOptionsK($arRSecs,$RSID);?>
		</select>
	</td>
</tr>
<tr>
	<td class="fname"><?=Lng('Component_cache')?>: </td>
	<td class="ftext">
		<input type="checkbox" name="CACHE" value="1" <?if($arComSets['CACHE']==1){?> checked <?}?> > 
	</td>
</tr><tr>
	<td class="fname"><?=Lng('Template')?>: </td>
	<td class="fvalues">
		<select name="TEMPLATE" style="width:200px;">
			<?$arTemps = TDMGetTemplates($CompCode);
			FShowSelectOptions($arTemps,$arComSets['TEMPLATE']);?>
		</select>
	</td>
</tr><tr>
	<td class="fname"><?=Lng('Ignore_type_of_car')?>: </td>
	<td class="ftext">
		<input type="checkbox" name="IGNORE" value="1" <?if($arComSets['IGNORE'][$RSID]==1){?> checked <?}?> >  
		<span class="tiptext"><?=Tip('Not_check_in_db_type_car')?></span>
	</td>
</tr>
<tr><td colspan="2"><hr></td></tr>
</table>

<button onclick="translitall(event)">ТРАНСЛИТ</button>
<script>
function translitall(e) {
	e.preventDefault();
	jQuery('input.url').each(function() {
		tr=(translit($.trim(jQuery(this).parent().parent().find('td.name span').text()),5).toLowerCase().replace(/[^A-Za-zА-Яа-яЁё|-| ]/g, ""));
		jQuery(this).val(tr.replace(/\s+/ig," ").replace(/\s/ig, '-'));
	});
}
</script>
<table class="eftab">
	<tr class="head">
		<td title="TecDoc Section ID">SID</td>
		<td title="Dynamic Parent Section ID">PID</td>
		<td title="TecDoc fixed Parent Section ID">TID</td>
		<td><?=Lng('Off_')?></td>
		<td><?=Lng('Name')?></td>
		<td title="<?=strip_tags(Tip('Language_phrases_in_field'));?>"><?=Lng('Rename_to')?>*</td>
		<td>URL code <?/*<a href="javascript:void(0);" onclick="AddFormPost('FILLCODE')"><img src="images/fill.png" width="16px" height="16px" title="<?=Tip('Automatically_fillin_CODE_fields')?>"/></a>*/?></td>
	</tr>
	<?
	$arACTIVE = Array();
	if(is_array($arComSets['ACTIVE'][$RSID])){$arACTIVE=$arComSets['ACTIVE'][$RSID];}
	$log='';
	foreach($arSections as $arSec){
		$SID = $arSec['STR_ID']; $NStyle='';
		if($arComSets['PARENT'][$SID]>0 AND $arComSets['PARENT'][$SID]!=$arSec['PID']){$PID=$arComSets['PARENT'][$SID]; $PIDStyle='color:#ff0000;';}else{$PID=$arSec['PID']; $PIDStyle='';}
		if(in_array($SID,$arACTIVE)){$IsSel="checked";}else{$IsSel="";}
		if($arSec['STR_LEVEL']<4){$Lvl = ''; $NStyle='style="font-weight:bold;"'; if($Cnt>0){?><tr><td colspan="5"><hr></td></tr><?} $Cnt=0; }
		if($arSec['STR_LEVEL']==4){$Lvl = '&nbsp;&nbsp;&nbsp;&raquo;'; $Cnt++;}
		if($arSec['STR_LEVEL']==5){$Lvl = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;';}
		if($_GET['tab']==1||$SvRes)
			$log.='<tr><td>'.$SID."</td><td>".$arSec['PID']."</td><td>".UWord($arSec['STR_DES_TEXT'])."</td><td>".$arComSets['CODE'][$SID]."</td></tr>";
		?>
		<tr><td class="gcolor"><?=$SID?></td>
			<td><input type="text" name="PARENT[<?=$SID?>]" value="<?=$PID?>" style="width:50px; <?=$PIDStyle?>"></td>
			<td class="gcolor"><?=$arSec['PID']?></td>
			<td><input type="checkbox" name="ACTIVE[]" value="<?=$SID?>" <?=$IsSel?> ></td>
			<td class="name" <?=$NStyle?> ><?=$Lvl?> <span><?=UWord($arSec['STR_DES_TEXT'])?></span></td>
			<td><input type="text" name="NAME[<?=$SID?>]" value="<?=$arComSets['NAME'][$SID]?>" style="width:220px;"></td>
			<td>
				<?if($arSec['DESCENDANTS']<=0){
					if($_POST['ADDFIELD']=="FILLCODE" AND $arComSets['CODE'][$SID]==''){$arComSets['CODE'][$SID]=StrForURL($arSec['STR_DES_TEXT'],false);}?>
					<input class="url" type="text" name="CODE[<?=$SID?>]" value="<?=$arComSets['CODE'][$SID]?>" style="width:180px;">
				<?}?>
			</td>
		</tr>
	<? }?>
</table>

<?php if($log!='') echo '<table>',$log, '</table>';
?>
<br>
<span class="tiptext">* <?=Tip('Language_phrases_in_field');?></span>
<br><br>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

<script>


/* jshint -W100 */
/**
* @name      translit.js
* @author    XGuest <xguest@list.ru>
* @link      https://github.com/xguest/iso_9_js
* @version   1.0.4
* @copyright GPL applies.
*            No warranties XGuest[28.03.2016/07:59:18] translit [ver.1.0.4]
* #guid      {E7088033-479F-47EF-A573-BBF3520F493C}
*
* @description Прямая и обратная транслитерация
*              Соответствует ISO 9:1995 и ГОСТ 7.79-2000 системы А и Б
*
* @param {String}  str транслитерируемая строка
* @param {Number}  typ ± направление (тип) транслитерации
*                      + прямая с латиницы в кириллицу
*                      - обратная
*                      system A = 1-диакритика;
*                      system B = 2-Беларусь;3-Болгария;4-Македония;5-Россия;6-Украина;
* @example
* function example() {
*  var a, b = [
*     [],
*     ["Диакритика", "Съешь ещё этих мягких французских булок, да выпей же чаю!"],
*     ["Беларускую", "З'ясі яшчэ гэтых мяккіх французскіх булак, ды выпі ж чаю!"],
*     ["Български",  "Яжте повече от тези меки кифлички, но също така се пие чай!"],
*     ["Македонски", "Јадат повеќе од овие меки францускиот ролни, па пијат чај!"],
*     ["Русский",    "Съешь ещё этих мягких французских булок, да выпей же чаю!"],
*     ["Українська", "З'їж ще цих м'яких французьких булок, та випий же чаю!"]
*  ], c, d;
*  for(a = 1; a < b.length - 1; a++) {
*   c = b[a][0];                                       // Language
*   d = b[a][1];                                       // Source
*   e = translit(d, a);                                // Forward
*   console.log(
*    "%s - %s\nSource  : %s\nTranslit: %s\nReverse : %s\n",
*    c,                                                // Language
*    translit(c, a),                                   // Transliterated language
*    d,                                                // Source
*    e,                                                // Forward
*    translit(e, -1 * a)                               // Reverse
*   );
*  }
* };
**/
function translit(str, typ) {
  var func = (function(typ) {
  /** Function Expression
  * Вспомогательная функция.
  *
  * FINISHED TESTED!
  * В ней и хотелось навести порядок.
  *
  * Проверяет направление транслитерации.
  * Возвращает массив из 2 функций:
  *  построения таблиц транслитерации.
  *  и пост-обработки строки (правила из ГОСТ).
  *
  * @param  {Number} typ
  * @return {Array}  Массив функций пред и пост обработки.
  **/
    function prep (a) {
      var write = !a ? function(chr, row) {trantab[row] = chr;regarr.push(row);} :
      function(row, chr) {trantab[row] = chr;regarr.push(row);};
      return function(col, row) {        // создаем таблицу и RegExp
        var chr = col[abs] || col[0];    // Символ
        if (chr) write(chr, row);        // Если символ есть
        }
    }
    var abs = Math.abs(typ);             // Абсолютное значение транслитерации
    if (typ === abs) {                   // Прямая транслитерация в латиницу
      str = str.replace(/(i(?=.[^аеиоуъ\s]+))/ig, '$1`'); // "i`" ГОСТ ст. рус. и болг.
      return [prep(),                    // Возвращаем массив функций
        function(str) {                  // str - транслируемая строка.
          return str.replace(/i``/ig, 'i`').    // "i`" в ГОСТ ст. рус. и болг.
           replace(/((c)z)(?=[ieyj])/ig, '$1'); // "cz" в символ "c"
        }];
    } else {                             // Обратная транслитерация в кириллицу
      str = str.replace(/(c)(?=[ieyj])/ig, '$1z'); // Правило сочетания "cz"
      return [prep(1),function(str) {return str;}];// nop - пустая функция.
    }
  }(typ));
  var iso9 = {                           // Объект описания стандарта
    // Имя - кириллица
    //   0 - общие для всех
    //   1 - диакритика         4 - MK|MKD - Македония
    //   2 - BY|BLR - Беларусь  5 - RU|RUS - Россия
    //   3 - BG|BGR - Болгария  6 - UA|UKR - Украина
   /*-Имя---------0-,-------1-,---2-,---3-,---4-,----5-,---6-*/
    '\u0449': [   '', '\u015D',   '','sth',   '', 'shh','shh'], // 'щ'
    '\u044F': [   '', '\u00E2', 'ya', 'ya',   '',  'ya', 'ya'], // 'я'
    '\u0454': [   '', '\u00EA',   '',   '',   '',    '', 'ye'], // 'є'
    '\u0463': [   '', '\u011B',   '', 'ye',   '',  'ye',   ''], //  ять
    '\u0456': [   '', '\u00EC',  'i', 'i`',   '',  'i`',  'i'], // 'і' йота
    '\u0457': [   '', '\u00EF',   '',   '',   '',    '', 'yi'], // 'ї'
    '\u0451': [   '', '\u00EB', 'yo',   '',   '',  'yo',   ''], // 'ё'
    '\u044E': [   '', '\u00FB', 'yu', 'yu',   '',  'yu', 'yu'], // 'ю'
    '\u0436': [ 'zh','\u017E'],                                 // 'ж'
    '\u0447': [ 'ch','\u010D'],                                 // 'ч'
    '\u0448': [ 'sh', '\u0161',   '',   '',   '',    '',   ''], // 'ш'
    '\u0473': [   '','f\u0300',   '', 'fh',   '',  'fh',   ''], //  фита
    '\u045F': [   '','d\u0302',   '',   '', 'dh',    '',   ''], // 'џ'
    '\u0491': [   '','g\u0300',   '',   '',   '',    '', 'g`'], // 'ґ'
    '\u0453': [   '', '\u01F5',   '',   '', 'g`',    '',   ''], // 'ѓ'
    '\u0455': [   '', '\u1E91',   '',   '', 'z`',    '',   ''], // 'ѕ'
    '\u045C': [   '', '\u1E31',   '',   '', 'k`',    '',   ''], // 'ќ'
    '\u0459': [   '','l\u0302',   '',   '', 'l`',    '',   ''], // 'љ'
    '\u045A': [   '','n\u0302',   '',   '', 'n`',    '',   ''], // 'њ'
    '\u044D': [   '', '\u00E8', 'e`',   '',   '',  'e`',   ''], // 'э'
    '\u044A': [   '', '\u02BA',   '', 'a`',   '',  '``',   ''], // 'ъ'
    '\u044B': [   '',      'y', 'y`',   '',   '',  'y`',   ''], // 'ы'
    '\u045E': [   '', '\u01D4', 'u`',   '',   '',    '',   ''], // 'ў'
    '\u046B': [   '', '\u01CE',   '', 'o`',   '',    '',   ''], //  юс
    '\u0475': [   '', '\u1EF3',   '', 'yh',   '',  'yh',   ''], //  ижица
    '\u0446': [ 'cz',     'c'],                                 // 'ц'
    '\u0430': [ 'a'],                                           // 'а'
    '\u0431': [ 'b'],                                           // 'б'
    '\u0432': [ 'v'],                                           // 'в'
    '\u0433': [ 'g'],                                           // 'г'
    '\u0434': [ 'd'],                                           // 'д'
    '\u0435': [ 'e'],                                           // 'е'
    '\u0437': [ 'z'],                                           // 'з'
    '\u0438': [   '',      'i',   '',  'i',  'i',   'i', 'y`'], // 'и'
    '\u0439': [   '',      'j',  'j',  'j',   '',   'j',  'j'], // 'й'
    '\u043A': [ 'k'],                                           // 'к'
    '\u043B': [ 'l'],                                           // 'л'
    '\u043C': [ 'm'],                                           // 'м'
    '\u043D': [ 'n'],                                           // 'н'
    '\u043E': [ 'o'],                                           // 'о'
    '\u043F': [ 'p'],                                           // 'п'
    '\u0440': [ 'r'],                                           // 'р'
    '\u0441': [ 's'],                                           // 'с'
    '\u0442': [ 't'],                                           // 'т'
    '\u0443': [ 'u'],                                           // 'у'
    '\u0444': [ 'f'],                                           // 'ф'
    '\u0445': [  'x',     'h'],                                 // 'х'
    '\u044C': [   '', '\u02B9',  '`',  '`',   '',   '`',  '`'], // 'ь'
    '\u0458': [   '','j\u030C',   '',   '',  'j',    '',   ''], // 'ј'
    '\u2019': [ '\'','\u02BC'],                                 // '’'
    '\u2116': [  '#']                                           // '№'
   /*-Имя---------0-,-------1-,---2-,---3-,---4-,----5-,---6-*/
  }, regarr = [], trantab = {};
  /* jshint -W030 */                     // Создание таблицы и массива RegExp
  for (var row in iso9) {if (Object.hasOwnProperty.call(iso9, row)) {func[0](iso9[row], row);}}
  /* jshint +W030 */
  return func[1](                        // функция пост-обработки строки (правила и т.д.)
      str.replace(                       // Транслитерация
      new RegExp(regarr.join('|'), 'gi'),// Создаем RegExp из массива
      function(R) {                      // CallBack Функция RegExp
        if (R.toLowerCase() === R) {     // Обработка строки с учетом регистра
          return trantab[R];
        } else {
          return trantab[R.toLowerCase()].toUpperCase();
        }
      }));
}
module.exports = translit;
</script>