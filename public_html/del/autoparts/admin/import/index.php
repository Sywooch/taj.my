<?php

define("TDM_PROLOG_INCLUDED", true);
define("TDM_ADMIN_SIDE", true);
require_once("../../tdmcore/init.php");
if ($_SESSION["TDM_ISADMIN"] != "Y") {
	header("Location: /" . TDM_ROOT_DIR . "/admin/");
	exit();
}
$arASupps = array();
$resDB = new TDMQuery();
$resDB->Select("TDM_IM_SUPPLIERS", array(), array());
while ($arSupp = $resDB->Fetch()) {
	if ($_POST["delete"] == "Y" && $_POST["delem"] == "DELSUP" . $arSupp["ID"]) {
		$DResCnt = $resDB->Delete("TDM_IM_SUPPLIERS", array("ID" => $arSupp["ID"]));
		if (0 < $DResCnt) {
			$resDB->Delete("TDM_IM_COLUMNS", array("SUPID" => $arSupp["ID"]));
			TDMRedirect("admin/import/");
		}
	}
	if (!($_REQUEST["ID"] == $arSupp["ID"])) {
		continue;
	}
	$CID = $arSupp["ID"];
	$arCSupp = $arSupp;
	$_POST["CODE"] = $arSupp["CODE"];
	if (!($_POST["edit"] != "Y")) {
		continue;
	}
	foreach ($arSupp as $Key => $Value) {
		$_POST[$Key] = $Value;
	}
}
if ($_POST["delete"] == "Y") {
	$rsCSp = new TDMQuery();
	if ($_POST["delem"] == "EMPTY_PRICES") {
		$rsCSp->Delete("TDM_PRICES", array("CODE" => $arCSupp["CODE"]));
		$Clr1 = "redcolor";
	}
	if ($_POST["delem"] == "EMPTY_LINKS") {
		$rsCSp->Delete("TDM_LINKS", array("CODE" => $arCSupp["CODE"]));
		$Clr2 = "redcolor";
	}
}
if (0 < $arCSupp["ID"]) {
	$rsCSp = new TDMQuery();
	$rsCSp->SimpleSelect("SELECT COUNT(*) FROM TDM_PRICES WHERE CODE=\"" . $arCSupp["CODE"] . "\" ");
	if ($arDB = $rsCSp->Fetch()) {
		$PricesCount = $arDB["COUNT(*)"];
	}
	$rsCSp->SimpleSelect("SELECT COUNT(*) FROM TDM_LINKS WHERE CODE=\"" . $arCSupp["CODE"] . "\" ");
	if ($arDB = $rsCSp->Fetch()) {
		$LinksCount = $arDB["COUNT(*)"];
	}
}
if ($_POST["edit"] == "Y") {
	$_POST["ARTBRA_SIDE"] = intval($_POST["ARTBRA_SIDE"]);
	$_POST["PRICE_TYPE"] = intval($_POST["PRICE_TYPE"]);
	$_POST["PRICE_EXTRA"] = intval($_POST["PRICE_EXTRA"]);
	$_POST["PRICE_ADD"] = floatval($_POST["PRICE_ADD"]);
	if(floatval($_POST["CURR_CURSE"])>0) 
		$_POST["CURR_CURSE"] = floatval($_POST["CURR_CURSE"]);
	else $_POST["CURR_CURSE"] = '';
	$_POST["MIN_AVAIL"] = intval($_POST["MIN_AVAIL"]);
	$_POST["MAX_DAY"] = intval($_POST["MAX_DAY"]);
	$_POST["DAY_ADD"] = intval($_POST["DAY_ADD"]);
	$_POST["CONSIDER_HOT"] = intval($_POST["CONSIDER_HOT"]);
	$_POST["DELETE_ON_START"] = intval($_POST["DELETE_ON_START"]);
	$_POST["DEF_BRAND"] = substr($_POST["DEF_BRAND"], 0, 32);
	$_POST["FILE_PATH"] = substr(trim($_POST["FILE_PATH"]), 0, 128);
	$_POST["FILE_NAME"] = substr(trim($_POST["FILE_NAME"]), 0, 32);
	$_POST["FILE_PASSW"] = substr(trim($_POST["FILE_PASSW"]), 0, 32);
	$_POST["START_FROM"] = intval($_POST["START_FROM"]);
	$_POST["STOP_BEFORE"] = intval($_POST["STOP_BEFORE"]);
	$_POST["CURRENCY"] = substr($_POST["CURRENCY"], 0, 3);
	$_POST["DEF_AVAILABLE"] = intval($_POST["DEF_AVAILABLE"]);
	$_POST["DEF_STOCK"] = substr($_POST["DEF_STOCK"], 0, 16);
	if (strlen($_POST["NAME"]) < 3) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Name"), 1);
	}
	if ($CID <= 0 && strlen($_POST["CODE"]) < 3) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Code"), 1);
	}
	if (strlen($_POST["COLUMN_SEP"]) < 1) {
		$_POST["COLUMN_SEP"] = ";";
	}
	if (strlen($_POST["FILE_PATH"]) < 5) {
		ErAdd(Lng("A_required_field") . " - " . Lng("File_path"), 1);
	}
	if (ErCheck() && $CID <= 0) {
		$resDB->Select("TDM_IM_SUPPLIERS", array(), array("CODE" => $_POST["CODE"]));
		if ($arRes = $resDB->Fetch()) {
			ErAdd(Lng("Code") . " \"" . $_POST["CODE"] . "\" " . Lng("is_already_exist", 2), 1);
		}
	}
	if (ErCheck()) {
		if ($_POST["STOP_BEFORE"] < $_POST["START_FROM"]) {
			$_POST["START_FROM"] = $_POST["STOP_BEFORE"];
		}
		if ($_POST["STOP_BEFORE"] < $_POST["START_FROM"]) {
			$_POST["STOP_BEFORE"] = $_POST["START_FROM"];
		}
		$arFields = array("NAME" => trim($_POST["NAME"]), "COLUMN_SEP" => $_POST["COLUMN_SEP"], "ARTBRA_SEP" => $_POST["ARTBRA_SEP"], "ARTBRA_SIDE" => $_POST["ARTBRA_SIDE"], "ENCODE" => $_POST["ENCODE"], "FILE_PATH" => $_POST["FILE_PATH"], "FILE_NAME" => $_POST["FILE_NAME"], "FILE_PASSW" => $_POST["FILE_PASSW"], "START_FROM" => $_POST["START_FROM"], "STOP_BEFORE" => $_POST["STOP_BEFORE"], "PRICE_EXTRA" => $_POST["PRICE_EXTRA"], "CONSIDER_HOT" => $_POST["CONSIDER_HOT"], "DELETE_ON_START" => $_POST["DELETE_ON_START"], "PRICE_ADD" => $_POST["PRICE_ADD"], "PRICE_TYPE" => $_POST["PRICE_TYPE"], "MIN_AVAIL" => $_POST["MIN_AVAIL"], "MAX_DAY" => $_POST["MAX_DAY"], "DEF_BRAND" => $_POST["DEF_BRAND"], "DEF_CURRENCY" => $_POST["DEF_CURRENCY"], "DAY_ADD" => $_POST["DAY_ADD"], "DEF_AVAILABLE" => $_POST["DEF_AVAILABLE"], "DEF_STOCK" => $_POST["DEF_STOCK"], "CURR"=> $_POST['CURR_CURSE']);
		if (0 < $CID) {
			$IRes = $resDB->Update2("TDM_IM_SUPPLIERS", $arFields, array("ID" => $CID));
			if ($IRes) {
				NtAdd(Lng("Record_updated") . ": " . $_POST["NAME"]);
			}
			if (isset($_POST["NUM"]) && 0 < count($_POST["NUM"]) && isset($_POST["FIELD"]) && 0 < count($_POST["FIELD"])) {
				$_POST["NUM"] = array_unique($_POST["NUM"], SORT_REGULAR);
				$_POST["FIELD"] = array_unique($_POST["FIELD"], SORT_REGULAR);
				foreach ($_POST["NUM"] as $ID => $NUM) {
					if (!(0 < $NUM && $_POST["FIELD"][$ID] != "")) {
						continue;
					}
					$resDB->Update2("TDM_IM_COLUMNS", array("NUM" => $NUM, "FIELD" => $_POST["FIELD"][$ID]), array("ID" => $ID));
				}
			}
			if (isset($_POST["NEW_NUM"]) && 0 < count($_POST["NEW_NUM"]) && isset($_POST["NEW_FIELD"]) && 0 < count($_POST["NEW_FIELD"])) {
				$_POST["NEW_NUM"] = array_unique($_POST["NEW_NUM"], SORT_REGULAR);
				$_POST["NEW_FIELD"] = array_unique($_POST["NEW_FIELD"], SORT_REGULAR);
				foreach ($_POST["NEW_NUM"] as $Key => $NUM) {
					if (!(0 < $NUM && $_POST["NEW_FIELD"][$Key] != "")) {
						continue;
					}
					$resDB->Insert("TDM_IM_COLUMNS", array("SUPID" => $CID, "NUM" => $NUM, "FIELD" => $_POST["NEW_FIELD"][$Key]));
				}
			}
		}
		else {
			$arFields["CODE"] = StrForURL(trim($_POST["CODE"]));
			$NewID = $resDB->Insert("TDM_IM_SUPPLIERS", $arFields);
			if ($NewID) {
				if (isset($_POST["NEW_NUM"]) && 0 < count($_POST["NEW_NUM"]) && isset($_POST["NEW_FIELD"]) && 0 < count($_POST["NEW_FIELD"])) {
					$_POST["NEW_NUM"] = array_unique($_POST["NEW_NUM"], SORT_REGULAR);
					$_POST["NEW_FIELD"] = array_unique($_POST["NEW_FIELD"], SORT_REGULAR);
					foreach ($_POST["NEW_NUM"] as $Key => $NUM) {
						if (!(0 < $NUM && $_POST["NEW_FIELD"][$Key] != "")) {
							continue;
						}
						$resDB->Insert("TDM_IM_COLUMNS", array("SUPID" => $NewID, "NUM" => $NUM, "FIELD" => $_POST["NEW_FIELD"][$Key]));
					}
				}
				TDMRedirect("admin/import/?ID=" . $NewID);
			}
		}
	}
}
$resDB->Select("TDM_IM_SUPPLIERS", array(), array());
while ($arSupps = $resDB->Fetch()) {
	$arASupps[] = $arSupps;
}
if ($_REQUEST["ID"] == "NEW" || 0 < $CID) {
	$DoEdit = "Y";
	$arCols = array();
	$arCurs = array();
	foreach ($TDMCore->arCurs as $Cur => $arCur) {
		$arCurs[] = $Cur;
	}
	if (count($arCurs) <= 0) {
		$arCurs[] = "USD";
	}
	$arNums[0] = "";
	$i = 1;
	while ($i < 26) {
		$arNums[] = $i;
		++$i;
	}
	$arFields = array("" => "", "ARTICLE_BRAND" => Lng("Article", 1, 0) . " & " . Lng("Brand", 1, 0), "ARTICLE" => Lng("Article", 1, 0), "BRAND" => Lng("Brand", 1, 0), "PRICE" => Lng("Price", 1, 0), "ALT_NAME" => Lng("Name", 1, 0), "CURRENCY" => Lng("Currency", 1, 0), "DAY" => Lng("Dtime", 1, 0), "AVAILABLE" => Lng("Availability", 1, 0), "STOCK" => Lng("Stock", 1, 0), "PERCENTGIVE" => Lng("PRICE_OPTION_PERCENTGIVE", 1, 0), "SET" => Lng("PRICE_OPTION_SET", 1, 0), "WEIGHT" => Lng("Weight_gr", 1, 0), "USED" => Lng("PRICE_OPTION_USED", 1, 0), "RESTORED" => Lng("PRICE_OPTION_RESTORED", 1, 0), "DAMAGED" => Lng("PRICE_OPTION_DAMAGED", 1, 0), "NORETURN" => Lng("PRICE_OPTION_NORETURN", 1, 0), "MINIMUM" => Lng("PRICE_OPTION_MINIMUM", 1, 0), "LITERS" => Lng("PRICE_OPTION_LITERS", 1, 0), "COPY" => Lng("PRICE_OPTION_COPY", 1, 0), "HOT" => Lng("PRICE_OPTION_HOT", 1, 0));
	if (0 < $CID) {
		$resDB->Select("TDM_IM_COLUMNS", array("NUM" => "ASC"), array("SUPID" => $CID));
		while ($arRes = $resDB->Fetch()) {
			if ($_POST["delem"] == "DELCOL" . $arRes["ID"]) {
				$rsDelDB = new TDMQuery();
				$DResCnt = $rsDelDB->Delete("TDM_IM_COLUMNS", array("ID" => $arRes["ID"]));
				if (!(0 < $DResCnt)) {
					continue;
				}
				NtAdd(Lng("Record_deleted") . ": " . $arRes["NUM"] . " - " . $arRes["FIELD"]);
				$_POST["delete"] = "N";
				$_POST["delem"] = "";
				continue;
			}
			$arCols[] = $arRes;
		}
	}
}
?>
<head><title>ТекДок: Импорт Прайсов</title>
<link rel="stylesheet" href="/autoparts/media/js/jquery-ui-1.10.4.custom/custom.css" />

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="/catalog/view/javascript/jquery/ui/jquery-ui.min.js"></script>
</head>
<?php 

if($_GET['multi']==1) {
	$class="imsupdiv full"; 
	$box_start="\t\t\t<input type=\"checkbox\" value=\"";
	$box_end="\">\n\t\t\t<a href=\"?ID=";
	$width=50; 
	?>
	<div id="run_multi"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDE2IDE2IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxNiAxNjsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSIyNHB4IiBoZWlnaHQ9IjI0cHgiPgo8Zz4KCTxwYXRoIGQ9Ik04LDBDMy41ODIsMCwwLDMuNTgyLDAsOHMzLjU4Miw4LDgsOHM4LTMuNTgyLDgtOFMxMi40MTgsMCw4LDB6IE01LDEyVjRsNyw0TDUsMTJ6IiBmaWxsPSIjMGQ4N2RlIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" />Старт</div>
	<script>
		jQuery('#run_multi').on('click',function() {
			var url='';
			jQuery('.imsupdiv.full input[type="checkbox"]:checked').each(function() {
				if(url=='') 
					url='/autoparts/admin/import/run.php?ID='+jQuery(this).val()+'&nextstep=';
				else url+=jQuery(this).val()+',';
			});
			if(jQuery('.imsupdiv.full input[type="checkbox"]:checked').size()>1)
				url=url.substring(0, url.length - 1)
			if(url!='')
				document.location.href=url;
		});
	</script>
	
	<?php
}
else {
	$class="imsupdiv";
	$box_start="\t\t\t<a href=\"run.php?ID=";
	$box_end="\" class=\"imstart\" title=\"Start import\"></a>\n\t\t\t<a href=\"?ID=";
	$width=90;
}
echo("\n<div class=\"apanel_cont\">");
require_once(TDM_PATH . "/admin/apanel.php");
echo("</div>\n<div class=\"tdm_acontent\">\n\t");

echo("\t");
jsLinkFormStyler();
echo("\t<script>AddFSlyler('input, checkbox, radio, select, button');</script>\n\t<h1>");
echo(Lng("Import_master"));
echo("</h1><div class=\"tclear\"></div>\n\t<hr>\n\t<table class=\"colstab\"><tr><td>\n\t<div class=\"".$class."\">\n\t\t<div class=\"suptitleb\">");
echo(Lng("Suppliers"));
echo(": <a href=\"?ID=NEW\" class=\"newsuplb\" title=\"");
echo(Lng("Add_new", 1, 0));
echo("\"></a></div>\n\t\t");
foreach ($arASupps as $arASup) {
	echo($box_start);
	echo($arASup["ID"]);
	echo($box_end);
	echo($arASup["ID"]);
	echo("\" class=\"supplier name\">");
	echo($arASup["ID"]);
	echo(". <b>");
	echo($arASup["NAME"]);
	echo("</b></a>\n\t\t\t<div onclick=\"");
	jsDelConfirm("DELSUP" . $arASup["ID"], Lng("Really_delete_record", 0, 0) . ": " . $arASup["NAME"]);
	echo("\" class=\"trashws\"></div>\n\t\t");
}
echo("\t</div>\n\t<br>\n\t<br>\n\t\n\t");
if (0 < $arCSupp["ID"]) {
	echo("\t\t<div class=\"informlay\">\n\t\t\t<div class=\"informhead\"><b>");
	echo($arCSupp["NAME"]);
	echo("</b><br>");
	echo(Tip("Supplier_DB_records"));
	echo(":</div>\n\t\t\t<table class=\"informtab\">\n\t\t\t\t<tr><td class=\"tarig\">Prices: </td><td class=\"");
	echo($Clr1);
	echo("\">");
	echo($PricesCount);
	echo("</td><td>\n\t\t\t\t\t<div onclick=\"");
	jsDelConfirm("EMPTY_PRICES", Tip("Really_clear_all_DB_records"));
	echo("\" class=\"trashbut\"></div>\n\t\t\t\t</td></tr>\n\t\t\t\t<tr><td class=\"tarig\">Links: </td><td class=\"");
	echo($Clr2);
	echo("\">");
	echo($LinksCount);
	echo("</td><td>\n\t\t\t\t\t<div onclick=\"");
	jsDelConfirm("EMPTY_LINKS", Tip("Really_clear_all_DB_records"));
	echo("\" class=\"trashbut\"></div>\n\t\t\t\t</td></tr>\n\t\t\t</table>\n\t\t</div>\n\t\t<br><br>\n\t\t");
	if ($TDMCore->arSettings["CRON_KEY"] != "") {
		echo("\t\t\t<div class=\"informlay\">\n\t\t\t\t<div class=\"informhead\"><b>CRON</b> auto import script file:</div>\n\t\t\t\t<table class=\"informtab\"><tr><td style=\"padding:10px;\">\n\t\t\t\t/");
		echo(TDM_ROOT_DIR);
		echo("/import/");
		echo($TDMCore->arSettings["CRON_KEY"]);
		echo("/");
		echo($arCSupp["ID"]);
		echo(".php\n\t\t\t\t</table>\n\t\t\t</div>\n\t\t");
	}
	echo("\t");
}
echo("\n\t</td><td width=\"".$width."%\">\n\t\t");
if ($DoEdit == "Y") {
	echo("\t\t<form action=\"\" id=\"editform\" method=\"post\">\n\t\t\t<input type=\"hidden\" name=\"edit\" value=\"Y\"/>\n\t\t\t<table class=\"formtab\">\n\t\t\t\t<tr><td class=\"fname\"></td><td class=\"ftext\">\n\t\t\t\t\t<b>");
	if ($_REQUEST["ID"] == "NEW") {
		echo(Lng("Add_new"));
	}
	else {
		echo(Lng("Edit"));
	}
	echo(" ");
	echo(Tip("Price_of_supplier"));
	echo("</b>\n\t\t\t\t\t<div class=\"tclear\"></div>\n\t\t\t\t\t");
	ErShow();
	echo("\t\t\t\t</td></tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Name"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"NAME\" value=\"");
	echo($_POST["NAME"]);
	echo("\" maxlength=\"32\" style=\"width:250px;\" /></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Code"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"CODE\" id=\"codefield\" value=\"");
	echo($_POST["CODE"]);
	echo("\" onkeyup=\"this.value=this.value.replace(/[^a-zA-Z0-9]/g,'');\" ");
	if (0 < $CID) {
		echo("disabled");
	}
	echo(" maxlength=\"32\" style=\"width:100px;\" /> <span class=\"tiptext\">");
	echo(Lng("Any_name"));
	echo(" (Eng.)</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Column_separator"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"COLUMN_SEP\" value=\"");
	echo($_POST["COLUMN_SEP"]);
	echo("\" maxlength=\"3\" style=\"width:70px;\" />  <span class=\"tiptext\">");
	echo(Tip("Default_in_CSV"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Encode"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"ENCODE\" style=\"width:150px;\">\n\t\t\t\t\t\t");
	FShowSelectOptions(array("CP1251", "UTF-8"), $_POST["ENCODE"]);
	echo("\t\t\t\t\t</select> <span class=\"tiptext\">of CSV file</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("File_path"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"FILE_PATH\" value=\"");
	echo($_POST["FILE_PATH"]);
	echo("\" maxlength=\"128\" style=\"width:350px;\" /> <span class=\"tiptext\">csv, xls, xlsx, txt (zip, rar)</span><br>\n\t\t\t\t\t<span class=\"tiptext\">");
	echo(Tip("Descr_IM_file_path"));
	echo("</span>\n\t\t\t\t</td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("File_name"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"FILE_NAME\" value=\"");
	echo($_POST["FILE_NAME"]);
	echo("\" maxlength=\"32\" style=\"width:183px;\" /> <span class=\"tiptext\">");
	echo(Tip("If_price_in_format_zip"));
	echo("</span>\n\t\t\t\t</td>\n\t\t\t\t<tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Archive_password"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"FILE_PASSW\" value=\"");
	echo($_POST["FILE_PASSW"]);
	echo("\" maxlength=\"32\" style=\"width:183px;\" /> <span class=\"tiptext\">");
	echo(Tip("If_price_in_format_zip"));
	echo("</span>\n\t\t\t\t</td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Start_from_line"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"START_FROM\" value=\"");
	echo($_POST["START_FROM"]);
	echo("\" maxlength=\"12\" style=\"width:80px;\" /> ");
	echo(Lng("to_the"));
	echo(" \n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"STOP_BEFORE\" value=\"");
	echo($_POST["STOP_BEFORE"]);
	echo("\" maxlength=\"12\" style=\"width:80px;\" />\n\t\t\t\t\t<span class=\"tiptext\">");
	echo(Tip("If_price_includes_headings"));
	echo("</span>\n\t\t\t\t</td>\n\t\t\t\t</tr>");
	//print_r($arASupps[$CID]);
	echo "<tr><td class=\"fname\">Текущий курс: ",$arASupps[$CID]["CURR"],"</td><td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"CURR_CURSE\" value=\"",$arASupps['CURR'],"\"></td></tr>";
	echo ("<tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Delete_old_prices"));
	echo(": </td>\n\t\t\t\t");
	echo ("<td class=\"ftext\"><input type=\"checkbox\" name=\"DELETE_ON_START\" value=\"1\" ");
	if ($_POST["DELETE_ON_START"] == 1) {
		echo(" checked ");
	}
	echo(" > <span class=\"tiptext\">");
	echo(Tip("Before_import_start_delete"));
	echo("</span></td>\n\t\t\t\t</tr>\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\n\t\t\t\t<tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Separator_brand_article"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"ARTBRA_SEP\" value=\"");
	echo($_POST["ARTBRA_SEP"]);
	echo("\" maxlength=\"3\" style=\"width:70px;\" /> <span class=\"tiptext\">");
	echo(Tip("If_brand_&_article_located"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Article_is_located"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"ARTBRA_SIDE\" style=\"width:150px;\">\n\t\t\t\t\t\t");
	FShowSelectOptionsK(array(1 => Lng("SLeft", 1, 0), 2 => Lng("SRight", 1, 0)), $_POST["ARTBRA_SIDE"]);
	echo("\t\t\t\t\t</select></td>\n\t\t\t\t</tr>\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\n\t\t\t\t\n\t\t\t\t<tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Tip("Columns_relations"));
	echo(" CSV:");
	if (2 < count($arCols)) {
		echo("<br><br><a href=\"run.php?ID=");
		echo($CID);
		echo("&TEST=Y\" target=\"_blank\" class=\"imtest\"><b>TEST it</b>");
	}
	echo("\t\t\t\t</td>\n\t\t\t\t<td class=\"fvalues\" >\n\t\t\t\t\t<div id=\"cols\">\n\t\t\t\t\t\t");
	if (0 < count($arCols)) {
		$Wn = 1;
		foreach ($arCols as $arCol) {
			echo("\t\t\t\t\t\t\t\t<select name=\"NUM[");
			echo($arCol["ID"]);
			echo("]\" style=\"width:76px;\">\n\t\t\t\t\t\t\t\t\t");
			FShowSelectOptions($arNums, $arCol["NUM"]);
			echo("\t\t\t\t\t\t\t\t</select><span style=\"font-family:Arial; font-size:22px; color:#6B6B6B;\">&#8680;</span><select name=\"FIELD[");
			echo($arCol["ID"]);
			echo("]\" style=\"width:240px;\">\n\t\t\t\t\t\t\t\t\t");
			FShowSelectOptionsK($arFields, $arCol["FIELD"]);
			echo("\t\t\t\t\t\t\t\t</select> \n\t\t\t\t\t\t\t\t<div onclick=\"");
			jsDelConfirm("DELCOL" . $arCol["ID"], Lng("Really_delete_record", 0, 0) . ": " . $arFields[$arCol["FIELD"]]);
			echo("\" class=\"trashbut\" style=\"display:inline-block; margin-left:5px;\"></div>\n\t\t\t\t\t\t\t\t<div class=\"tclear\"></div>\n\t\t\t\t\t\t\t");
		}
	}
	else {
		$Wn = 4;
	}
	echo("\t\t\t\t\t\t<select name=\"NEW_NUM[]\" style=\"width:76px;\" id=\"newnum\">\n\t\t\t\t\t\t\t");
	FShowSelectOptions($arNums, "");
	echo("\t\t\t\t\t\t</select><span style=\"font-family:Arial; font-size:22px; color:#6B6B6B;\" id=\"newarr\">&#8680;</span><select name=\"NEW_FIELD[]\" style=\"width:240px;\" id=\"newfield\">\n\t\t\t\t\t\t\t");
	FShowSelectOptionsK($arFields, "");
	echo("\t\t\t\t\t\t</select>\n\t\t\t\t\t\t<div class=\"tclear\" id=\"newln\"></div>\n\t\t\t\t\t</div>\n\t\t\t\t\t<input type=\"button\" class=\"styler\" name=\"addcolumn\" id=\"AddCol\" value=\"");
	echo(Lng("Add_new", 1, 0));
	echo("\" style=\"margin-top:10px;\"/> \n\t\t\t\t\t<script>\$(function(){\n\t\t\t\t\t\t\$('#AddCol').click(function(){\n\t\t\t\t\t\t\t\$('select#newnum').clone().attr('id','').appendTo('#cols').styler();\n\t\t\t\t\t\t\t\$('#newarr').clone().appendTo('#cols');\n\t\t\t\t\t\t\t\$('select#newfield').clone().attr('id','').appendTo('#cols').styler();\n\t\t\t\t\t\t\t\$('#newln').clone().appendTo('#cols');\n\t\t\t\t\t\t\treturn false;\n\t\t\t\t\t\t});\n\t\t\t\t\t});</script>\n\t\t\t\t\t<span class=\"tiptext\" style=\"color:#A33702;\">");
	echo(Tip("Required_three_columns"));
	echo("</span>\n\t\t\t\t</tr>\n\t\t\t\t\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\n\t\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Add_price_extra"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"PRICE_EXTRA\" value=\"");
	echo($_POST["PRICE_EXTRA"]);
	echo("\" maxlength=\"6\" style=\"width:45px;\" />% <span class=\"tiptext\">(+/-)</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Hot_prices_without_discount"));
	echo(": </td>\n\t\t\t\t<td class=\"ftext\"><input type=\"checkbox\" name=\"CONSIDER_HOT\" value=\"1\" ");
	if ($_POST["CONSIDER_HOT"] == 1) {
		echo(" checked ");
	}
	echo(" > <span class=\"tiptext\">");
	echo(Tip("If_price_includes_option_hot"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Add_to_price"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"PRICE_ADD\" value=\"");
	echo($_POST["PRICE_ADD"]);
	echo("\" maxlength=\"12\" style=\"width:100px;\" /> <span class=\"tiptext\">");
	echo(Tip("Add_fixed_amount"));
	echo(" (+/-)</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Price_type"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"PRICE_TYPE\" style=\"width:200px;\">\n\t\t\t\t\t\t");
	FShowSelectOptionsK($TDMCore->arPriceType, $_POST["PRICE_TYPE"]);
	echo("\t\t\t\t\t</select></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Add_days"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"DAY_ADD\" value=\"");
	echo($_POST["DAY_ADD"]);
	echo("\" maxlength=\"2\" style=\"width:50px;\" /> <span class=\"tiptext\">");
	echo(Tip("Add_days_webservices"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Min_avail"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"MIN_AVAIL\" value=\"");
	echo($_POST["MIN_AVAIL"]);
	echo("\" maxlength=\"4\" style=\"width:50px;\" /> <span class=\"tiptext\">");
	echo(Tip("Min_avail_limit"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Max_days"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"MAX_DAY\" value=\"");
	echo($_POST["MAX_DAY"]);
	echo("\" maxlength=\"4\" style=\"width:50px;\" /> <span class=\"tiptext\">");
	echo(Tip("Max_days_limit"));
	echo("</span></td>\n\t\t\t\t</tr>\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\n\t\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Currency"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"DEF_CURRENCY\" style=\"width:100px;\">\n\t\t\t\t\t\t");
	FShowSelectOptions($arCurs, $_POST["DEF_CURRENCY"]);
	echo("\t\t\t\t\t</select> <span class=\"tiptext\">");
	echo(Tip("As_default"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Brand"));
	echo(" (");
	echo(Lng("Manufacturer"));
	echo("): </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"DEF_BRAND\" value=\"");
	echo($_POST["DEF_BRAND"]);
	echo("\" maxlength=\"32\" style=\"width:200px;\" /> <span class=\"tiptext\">");
	echo(Tip("As_default"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Stock"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"DEF_STOCK\" value=\"");
	echo($_POST["DEF_STOCK"]);
	echo("\" maxlength=\"32\" style=\"width:100px;\" /> <span class=\"tiptext\">");
	echo(Tip("As_default"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Availability"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"DEF_AVAILABLE\" value=\"");
	echo($_POST["DEF_AVAILABLE"]);
	echo("\" maxlength=\"4\" style=\"width:40px;\" /> <span class=\"tiptext\">");
	echo(Tip("As_default"));
	echo("</span></td>\n\t\t\t\t</tr>\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\n\t\t\t\t\n\t\t\t\t<td class=\"fname\"></td>\n\t\t\t\t<td class=\"fvalues\"><div class=\"bluebut\" onclick=\"\$('#editform').submit();\">");
	echo(Lng("Save", 0, 0));
	echo("</div></td></tr>\n\t\t\t</table>\n\t\t\t<div class=\"tclear\"></div>\n\t\t</form>\n\t\t");
}
else {
	echo("\t\t\t\n\t\t");
}
echo("\t</table>\n</div>\n");

?>
<script>
jQuery(document).ready(function() {
	var c;
	if(jQuery('input[name="FILE_PATH"]').val()) {
		c = jQuery('input[name="FILE_PATH"]').val().split('/')[2].split('.')[0].split(' ');
		if((c[1]=="евро"||c[1]=="долл")&&c[2])
			jQuery('input[name="CURR_CURSE"]').val(c[2].replace(",", "."));
	}
	jQuery('input[name="FILE_PATH"]').change(function() { 
		if(jQuery('input[name="FILE_PATH"]').val()) {
			c = jQuery('input[name="FILE_PATH"]').val().split('/')[2].split('.')[0].split(' ');
			if((c[1]=="евро"||c[1]=="долл")&&c[2])
				jQuery('input[name="CURR_CURSE"]').val(c[2].replace(",", "."));
		}
	});
});
</script>
<?php

