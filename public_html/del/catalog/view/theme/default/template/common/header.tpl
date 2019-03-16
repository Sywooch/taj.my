<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; if (isset($_GET['page'])) { echo " - ". ((int) $_GET['page'])." ".$text_page;} ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; if (isset($_GET['page'])) { echo " - ". ((int) $_GET['page'])." ".$text_page;} ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<meta property="og:title" content="<?php echo $title; if (isset($_GET['page'])) { echo " - ". ((int) $_GET['page'])." ".$text_page;} ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo $og_url; ?>" />
<?php if ($og_image) { ?>
<meta property="og:image" content="<?php echo $og_image; ?>" />
<?php } else { ?>
<meta property="og:image" content="<?php echo $logo; ?>" />
<?php } ?>
<meta property="og:site_name" content="<?php echo $name; ?>" />
<meta name="viewport" content="width=device-width">
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
	<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" />
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css' media="none" onload="if(media!='all')media='all'">
	<link rel="stylesheet" type="text/css" media="none" onload="if(media!='all')media='all'" href="catalog/view/theme/default/stylesheet/responsive.css" />
<?php foreach ($styles as $style) { ?>
	<link rel="<?php echo $style['rel']; ?>"  type="text/css" href="<?php echo $style['href']; ?>" media="none" onload="if(media!='all')media='all'" />
<?php } 
if (!isset($this->request->get['route']) || isset($this->request->get['route']) && $this->request->get['route'] == 'common/home') {?>
	<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/home.css" />
<?php }?>
	<noscript>
		<?php foreach ($styles as $style) { ?>
		<link rel="<?php echo $style['rel']; ?>"  type="text/css" href="<?php echo $style['href']; ?>"/>
		<?php } ?>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,cyrillic-ext,cyrillic">
		<link rel="stylesheet" type="text/css" async href="catalog/view/theme/default/stylesheet/responsive.css" />
	</noscript>
 <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TNHXDF');</script>
<!-- End Google Tag Manager -->

<script type="text/javascript" src="catalog/view/javascript/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui.min.js"></script>
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){
z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='https://v2.zopim.com/?4cx5Hy9vpKriCWiglWUgTbEiTe8c4fiK';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
</head>
<body>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TNHXDF"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager -->
<div id="top">
	<div class="links">
		 <ul>
			<li><a title="Главая" href="/">Главная</a></li>
			<li><a title="каталог автозапчастей" href="/autoparts">Каталог</a></li>
			<li><a title="про IbexShop" href="/o-nas">О Нас</a></li>
			<li><a title="Доставка и Оплата" href="/dostavla-i-oplata">Доставка и Оплата</a></li>
			<li><a title="Гарантия возврата" href="/garantia">Гарантия возврата</a></li>
			<li><a title="Контакты" href="/contact">Контакты</a></li>
		</ul>
	</div>
	<?php /* 
	 <div id="welcome">
    <?php if (!$logged) { ?>
    <?php echo $text_welcome; ?>
    <?php } else { ?>
    <?php echo $text_logged; ?>
    <?php } ?>
  </div>
  */?>
</div>
<div id="container">
   <div class="header-center clearfix">
	   <div class="col-4">
		  <?php if ($logo) { ?>
			<div id="logo">
			<?php if ($home == $og_url) { ?>
			  <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" />
			  <?php } else { ?>
			  <a href="/"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a>
			  <?php } ?>
			  </div>
			  <?php } ?>
	  </div>
	  <div class="col-4">
		<div class="phone-top">
			<ul class="clearfix">
				<li>(067) <b>851-25-02</b></li>
				<li>(073) <b>003-26-23</b></li>
				<li>(066) <b>913-80-83</b></li>
			</ul>
		</div>
		  <div id="search">
			<div class="button-search tdsbut" onclick="TDMArtSearch()">искать</div>
			<input type="text" name="TDMArtSearch" id="artnum" value="" maxlength="40" class="tdsform" placeholder="артикул запчасти, например: CT637"/>
		</div>
		
	  </div>
	   <div class="col-2">
		  <div class="time">
			<div class="time-top">
				<span>график работы</span>
			</div>
			<div class="time-content">
				<ul>
					<li>Пн-Пт<br/>9:30 - 18:00</li>
					<li>Сб<br/>9:30 - 15:00</li>
				</ul>	
			</div>
		  </div>
	  </div>
	  
	   <div class="col-2">
		 <?php echo $cart; ?>
	  </div>
	</div>
 
<div id="menu">
	<div class="menu-toggle" style="display: none;">Категории</div>
	<?php if(
	/*(!isset($_COOKIE['cars'])&&$_COOKIE['cars']=='')&&*/
	!$_COOKIE['admin']=='2') { ?>
		<ul>
			<li>
				<a href="#engine" title="Двигатель" attr-section_id="10102">Двигатель и КПП</a> 
				<ul class="submenu row3">
					<li><a href="#engine" title="Двигатель" attr-section_id="10102">Двигатель</a></li>
					<li><a href="#transmission" title="Коробка передач" attr-section_id="10338">Коробка передач</a></li>
					<li><a href="#belt-drive" title="Ременный привод" attr-section_id="10116">Ременный привод</a></li>
					<li><a href="#wheel-drive" title="Привод колеса" attr-section_id="10114">Привод колеса</a></li>
					<li><a href="#axle-drive" title="Главая передача" attr-section_id="10500">Главная передача</a></li>
					<li><a href="#fuel-mixture" title="Подвеска топливной смеси" attr-section_id="10354">Подготовка топливной смеси</a></li>
					<li><a href="#fuel-supply" title="Система подачи топлива" attr-section_id="10314">Система подачи топлива</a></li>
					<li><a href="#glow-ignition" title="Система зажигания" attr-section_id="10108">Система зажигания</a></li>
					<li><a href="#cooling" title="Система охлождения" attr-section_id="10107">Система охлождения</a></li>
					<li><a href="#exhaust" title="Система выпуска" attr-section_id="10104">Система выпуска</a></li>
				</ul>
			</li>
			<li>	<a attr-section_id="10106" href="#brake">Фильтр</a></li>
			<li>
				<a attr-section_id="10104" href="#axle-mounting">Электрика</a>
				<ul class="submenu row2">
					<li><a attr-section_id="10104" href="#axle-mounting">Электрика</a></li>
					<li><a href="#transmission" title="Коробка передач" attr-section_id="10338">Кондиционер</a></li>
					<li><a href="#belt-drive" title="Ременный привод" attr-section_id="10116">Отопление и вентиляция</a></li>
					<li><a href="#wheel-drive" title="Привод колеса" attr-section_id="10114">Система безопасности</a></li>
					<li><a href="#axle-drive" title="Главая передача" attr-section_id="10500">Система очистки окон</a></li>
				</ul>
			</li>
			<li>	<a attr-section_id="10106" href="#brake">Тормозная система</a></li>
			<li>	<a attr-section_id="10113" href="#steering">Система сцепления</a></li>
			<li>
				<a attr-section_id="10112" href="#axle-mounting">Подвеска</a>
				<ul class="submenu row1">
					<li><a attr-section_id="10104" href="#axle-mounting">Рулевое управление</a></li>
					<li><a href="#transmission" title="Коробка передач" attr-section_id="10338">Подвеска амортизация</a></li>
					<li><a href="#belt-drive" title="Ременный привод" attr-section_id="10116">Подвеска оси</a></li>
				</ul>
			</li>
			<li>	<a attr-section_id="10338" href="#transmission">Кузов</a></li>
		</ul>
	<?php } else { 
		$jsonData=stripslashes(html_entity_decode($_COOKIE['cars']));
		$cars=json_decode($jsonData,TRUE );
		$carSelectedUrl=explode('?', $cars['url']);
	?>
		<div class="SavedCarSelect">
			<div class="img">
				<img src="<?php
					if(file_exists($_SERVER['DOCUMENT_ROOT']."/autoparts/media/models/".strtolower(trim($cars['brand']))."/".strtoupper(trim($cars['model'])).".jpg"))
						echo "/autoparts/media/models/".strtolower(trim($cars['brand']))."/".strtoupper(trim($cars['model'])).".jpg";
					else echo $_SERVER['DOCUMENT_ROOT']."/autoparts/media/models/nocar.jpg";
				?>" alt="">
			</div>
			<div class="info">
				<span class="mark"><?php echo $cars['brand'];?></span>
				<span class="model"><?php echo $cars['submodel'];?></span>
				<span class="motor"><?php echo $cars['motor'];?></span>
			</div>
			<div class="select"></div>
			<div class="SavedCarsOther">
			
			</div>
		</div>
		<ul class="SavedCarIndent">
			<li>
				<a href="#engine" title="Двигатель" attr-section_id="10102">Двигатель<br> и КПП</a> 
				<ul class="submenu row3">
					<li><a href="#engine" title="Двигатель" attr-section_id="10102">Двигатель</a></li>
					<li><a href="#transmission" title="Коробка передач" attr-section_id="10338">Коробка передач</a></li>
					<li><a href="#belt-drive" title="Ременный привод" attr-section_id="10116">Ременный привод</a></li>
					<li><a href="#wheel-drive" title="Привод колеса" attr-section_id="10114">Привод колеса</a></li>
					<li><a href="#axle-drive" title="Главая передача" attr-section_id="10500">Главная передача</a></li>
					<li><a href="#fuel-mixture" title="Подвеска топливной смеси" attr-section_id="10354">Подготовка топливной смеси</a></li>
					<li><a href="#fuel-supply" title="Система подачи топлива" attr-section_id="10314">Система подачи топлива</a></li>
					<li><a href="#glow-ignition" title="Система зажигания" attr-section_id="10108">Система зажигания</a></li>
					<li><a href="#cooling" title="Система охлождения" attr-section_id="10107">Система охлождения</a></li>
					<li><a href="#exhaust" title="Система выпуска" attr-section_id="10104">Система выпуска</a></li>
				</ul>
			</li>
			<li>	<a attr-section_id="10106" href="#brake">Фильтр</a></li>
			<li>
				<a attr-section_id="10104" href="#axle-mounting">Электрика</a>
				<ul class="submenu row2">
					<li><a attr-section_id="10104" href="#axle-mounting">Электрика</a></li>
					<li><a href="#transmission" title="Коробка передач" attr-section_id="10338">Кондиционер</a></li>
					<li><a href="#belt-drive" title="Ременный привод" attr-section_id="10116">Отопление и вентиляция</a></li>
					<li><a href="#wheel-drive" title="Привод колеса" attr-section_id="10114">Система безопасности</a></li>
					<li><a href="#axle-drive" title="Главая передача" attr-section_id="10500">Система очистки окон</a></li>
				</ul>
			</li>
			<li>	<a attr-section_id="10106" href="#brake">Тормозная система</a></li>
			<li>	<a attr-section_id="10113" href="#steering">Система сцепления</a></li>
			<li>
				<a attr-section_id="10112" href="#axle-mounting">Подвеска</a>
				<ul class="submenu row1">
					<li><a attr-section_id="10104" href="#axle-mounting">Рулевое управление</a></li>
					<li><a href="#transmission" title="Коробка передач" attr-section_id="10338">Подвеска амортизация</a></li>
					<li><a href="#belt-drive" title="Ременный привод" attr-section_id="10116">Подвеска оси</a></li>
				</ul>
			</li>
			<li>	<a attr-section_id="10338" href="#transmission">Кузов</a></li>
		</ul>
		<?php } ?>
</div>
<div class="clear"></div>
<div id="notification"></div>


<script type="text/javascript" async src="catalog/view/javascript/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/common.js?new=19032017"></script>
<?php foreach($scripts as $script) {
 echo '<script type="text/javascript" async src="',$script,'"></script>';
}
 ?>
<script type="text/javascript">
	function TDMArtSearch(){
		var art = $('#artnum').val();
		if(art!=''){
			art = art.replace(/[^a-zA-Z0-9.-]+/g, '');
			location = '/autoparts/search/'+art+'/';
		}
	}

	$('#artnum').keypress(function (e){
		if(e.which == 13){ TDMArtSearch(); return false;}
	});
</script>