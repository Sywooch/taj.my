<?define('TDM_PROLOG_INCLUDED',true); 
require_once("../tdmcore/init.php"); 
if($_SESSION['TDM_ISADMIN']=="Y"){define('TDM_ADMIN_SIDE',true);}
if($_REQUEST['logout']=="Y"){$_SESSION['TDM_ISADMIN']="N"; header('Location: /'.TDM_ROOT_DIR.'/admin/'); die();}
if($_POST['authme']=="Y" AND $_SESSION['TDM_ISADMIN']!="Y" AND strlen($_POST['kpass'])>0){
	if($_POST['kpass']==$TDMCore->arConfig['MODULE_ADMIN_PASSW']){
		$_SESSION['TDM_ISADMIN'] = "Y";
		header('Location: /'.TDM_ROOT_DIR.'/admin/'); die();
	}else{
		$ERROR = "Wrong password...";
	}
}
?>
<head>
	<title>ТекДок: АдминПанель</title>
</head>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" src="/catalog/view/javascript/jquery/ui/jquery-ui.min.js"></script>
<?if($_SESSION['TDM_ISADMIN']!="Y"){?>
	<div class="tdm_acontent">
		<link rel="stylesheet" href="/<?=TDM_ROOT_DIR?>/admin/styles.css" type="text/css">
		<link rel="stylesheet" href="/<?=TDM_ROOT_DIR?>/styles.css" type="text/css">
		<h1><?=Lng('Please_login')?>:</h1><div class="tclear"></div>
		<?if($ERROR!=''){?><div class="tderror"><?echo $ERROR?></div><?}?>
		<form name="aform" id="aform" action="" method="post">
			<input type="hidden" name="authme" value="Y"/>
			<input type="password" name="kpass" value="" size="20" class="keyinp" maxlength="30"/>
			<div class="goinp"><input type="submit" value="Login" class="abutton"/></div>
		</form>
		<a href="/<?=TDM_ROOT_DIR?>/" class="nolink"><?=Lng('Return_to_module_catalog')?> &#9658;</a>
	</div>
<?}else{?>
	<div class="apanel_cont"><?require_once("apanel.php");?></div>
	<div class="tdm_acontent">
		<h1><?=Tip('Tecdoc_module')?></h1>
		<hr>
		PHP <?=phpversion()?>
	</div>
<?}?>
