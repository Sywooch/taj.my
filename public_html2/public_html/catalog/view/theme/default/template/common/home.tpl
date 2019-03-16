<?php echo $header; ?>

<div class="home-filter-block clearfix">
	<div class="filter-left">
	<?php if(!isset($motor)) { ?>
<?php 
		/*include_once($_SERVER['DOCUMENT_ROOT'].'/autoparts/tdmcore/components/manufacturers/settings.php');
		
			$TdocMarkOptionQuery='';
			foreach($arComSets["SELECTED_ITEMS"] as $TdocMarkOptions)
				$TdocMarkOptionQuery.='`MFA_ID` = '.$TdocMarkOptions.' OR ';

			include_once($_SERVER['DOCUMENT_ROOT'].'/autoparts/config.php');
					
			$LocalTDocConnect = mysqli_connect($arTDMConfig['MODULE_DB_SERVER'], $arTDMConfig["MODULE_DB_LOGIN"], $arTDMConfig["MODULE_DB_PASS"], $arTDMConfig[ "MODULE_DB_NAME"]);

			$sql=	"SELECT `FIELD`, `VALUE` FROM `TDM_SETTINGS` WHERE (
				`FIELD` = \"TECDOC_DB_SERVER\" OR 
				`FIELD` = \"TECDOC_DB_LOGIN\" OR 
				`FIELD` = \"TECDOC_DB_PASS\" OR
				`FIELD` = \"TECDOC_DB_NAME\"
				
			)";

											
			if (!$result=mysqli_query($LocalTDocConnect,$sql)) die();
			  $i=0;
			  $TDocDBServerConnOptions= [];
			  while($obj = $result->fetch_object()){ 
				 $TDocDBServerConnOptions[$i]=$obj->VALUE;
				 $i++;
			  }
			mysqli_close($LocalTDocConnect);

			$TDocDBServerConnect = mysqli_connect($TDocDBServerConnOptions[3],$TDocDBServerConnOptions[0],$TDocDBServerConnOptions[2],$TDocDBServerConnOptions[1]);
				
			$sql=	"SELECT `MFA_BRAND` FROM `MANUFACTURERS` WHERE (".$TdocMarkOptionQuery." false) ORDER BY `MFA_ID`"; 
			
			if (!$result=mysqli_query($TDocDBServerConnect,$sql)) die();
			
			$filterMark='';
			while($obj = $result->fetch_object()){ 
				$filterMark .= '<option value="'.str_replace(' ', '-',strtolower($obj->MFA_BRAND)).'">'.$obj->MFA_BRAND.'</option>';
			}*/
?>
	<?php 		
	$categs=array(					
		"alfa-romeo"=>"ALFA ROMEO",
		"audi"=>"AUDI",
		"bmw"=>"BMW",
		"chrysler"=>"CHRYSLER",
		"citroen"=>"CITROEN",
		"daihatsu"=>"DAIHATSU",
		"daimler"=>"DAIMLER",
		"dodge"=>"DODGE",
		"fiat"=>"FIAT",
		"ford"=>"FORD",
		"gmc"=>"GMC",
		"honda"=>"HONDA",
		"isuzu"=>"ISUZU",
		"iveco"=>"IVECO",
		"jaguar"=>"JAGUAR",
		"lada"=>"LADA",
		"lancia"=>"LANCIA",
		"mazda"=>"MAZDA",
		"mercedes-benz"=>"MERCEDES-BENZ",
		"mg"=>"MG",
		"mitsubishi"=>"MITSUBISHI",
		"nissan"=>"NISSAN",
		"opel"=>"OPEL",
		"peugeot"=>"PEUGEOT",
		"porsche"=>"PORSCHE",
		"renault"=>"RENAULT",
		"rover"=>"ROVER",
		"saab"=>"SAAB",
		"seat"=>"SEAT",
		"skoda"=>"SKODA",
		"subaru"=>"SUBARU",
		"suzuki"=>"SUZUKI",
		"toyota"=>"TOYOTA",
		"volvo"=>"VOLVO",
		"vw"=>"VW",
		"chevrolet"=>"CHEVROLET",
		"dacia"=>"DACIA",
		"ssangyong"=>"SSANGYONG",
		"hyundai"=>"HYUNDAI",
		"kia"=>"KIA",
		"daewoo"=>"DAEWOO",
		"ferrari"=>"FERRARI",
		"rolls-royce"=>"ROLLS-ROYCE",
		"maserati"=>"MASERATI",
		"pontiac"=>"PONTIAC",
		"buick"=>"BUICK",
		"cadillac"=>"CADILLAC",
		"lexus"=>"LEXUS",
		"jeep"=>"JEEP",
		"lincoln"=>"LINCOLN",
		"acura"=>"ACURA",
		"hummer"=>"HUMMER",
		"mini"=>"MINI",
		"infiniti"=>"INFINITI",
		"land-rover"=>"LAND ROVER",
		"geely"=>"GEELY",
		"chery"=>"CHERY",
		"great-wall"=>"GREAT WALL",
		"samsung"=>"SAMSUNG"
	);
	asort($categs);
	if(!isset($_COOKIE['cars'])&&$_COOKIE['cars']=='') {
	?>
		
	<div class="filter-title">Начните с выбора автомобиля</div>
	<div class="filter-content">	
		<div class="filters">
				<div class="filter-item active">
					<div class="helparrow left"></div>
					<select id="filter-model" placeholder="Выберите марку" name="filter-mark" class="filter-select" ><?php 
						while (list($key, $val) = each($categs)) { echo "
							<option value=\"$key\">$val</option>";
						}
						?>
					</select>
				</div>
				
				<div class="filter-item">
					<div class="helparrow right"></div>
					<select id="filter-year" disabled placeholder="Выберите год" name="filter-year" class="filter-select" >
						<option>Выберите год</option><?php 
						for($i=2016; $i>1989; $i--) echo '
						<option>',$i,'</option>';
						?>
					</select>
				</div>
				
				<div class="filter-item" >
					<div class="helparrow left"></div>
					<select id="filter-model" disabled placeholder="Выберите модель" name="filter-model" class="filter-select" >
						<option>Выберите модель</option>
					</select>
				</div>

				<div class="filter-item" >
					<div class="helparrow right"></div>
					<select id="filter-submodel" disabled placeholder="Выберите двигатель" name="filter-submodel" class="filter-select" >
						<option>Выберите подмодель</option>
					</select>
				</div> 

				<div class="filter-item">
					<div class="helparrow left"></div>
					<select id="filter-motorv" disabled placeholder="Выберите объем двигатель" name="filter-motorV" class="filter-select" >
						<option>Выберите объем двигателя</option>
					</select>
				</div> 

				<div id="filter-motor" class="filter-item">
					<div class="helparrow right"></div>
					<select disabled placeholder="Выберите двигатель" name="filter-motor" class="filter-select" >
						<option>Выберите двигатель</option>
					</select>
				</div> 
				<div id="ajax-preloader">
				
				</div>
				
		</div>
		<div class="filter-botton">Подобрать запчасти</div>
	</div>
	<div class="filter-text">
	Выбор автомобиля позволяет отобразить только те запчасти, которые подходят к вашему автомобилю.
	</div>
				<?php 
	} else {
				$jsonData=stripslashes(html_entity_decode($_COOKIE['cars']));
				$cars=json_decode($jsonData,TRUE );
			?>
	<div class="filter-title">Ваш последний выбранный автомобиль</div>
	<div class="filter-content">
		<div class="filters">
			
				<div class="filter-item active">
					<div class="helparrow left"></div>
					<select id="filter-model" disabled placeholder="Выберите марку" name="filter-mark" class="filter-select selectedBlock" >
						<option selected class="HistoryCar" value="<?php echo $cars['brand']; ?>"><?php echo $cars['brand']; ?> </option><?php 
						while (list($key, $val) = each($categs)) { echo "
							<option value=\"$key\">$val</option>";
						}
						?>
					</select>
					<div class="ShowMarkIMG" style="background: url(/autoparts/media/brands/90/<?php echo $cars['brand']; ?>.png)"></div>
				</div>
				
				<div class="filter-item">
					<div class="helparrow right"></div>
					<select id="filter-year" disabled placeholder="Выберите год" name="filter-year" class="filter-select selectedBlock" >
						<?php 
						echo '<option selected class="HistoryCar">',$cars['year'],'</option>';
						for($i=2016; $i>1989; $i--)  {
							echo '<option> ',$i,'</option>';
						} ?>
					</select>
				</div>
				
				<div class="filter-item" >
					<div class="helparrow left"></div>
					<select id="filter-model" disabled placeholder="Выберите модель" name="filter-model" class="filter-select selectedBlock" >
						<option>Выберите модель</option>
						<option class="HistoryCar" selected ><?php echo $cars['model']; ?></option>
					</select>
					<div class="ShowModelIMG"></div>
				</div>

				<div class="filter-item" >
					<div class="helparrow right"></div>
					<select id="filter-submodel" disabled placeholder="Выберите двигатель" name="filter-submodel" class="filter-select selectedBlock" >
						<option>Выберите подмодель</option>
						<option class="HistoryCar" selected ><?php echo $cars['submodel']; ?></option>
					</select>
				</div> 

				<div class="filter-item">
					<div class="helparrow left"></div>
					<select id="filter-motorv" disabled placeholder="Выберите объем двигатель" name="filter-motorV" class="filter-select selectedBlock" >
						<option>Выберите объем двигателя</option>
						<option class="HistoryCar" selected ><?php echo $cars['motorV']; ?></option>
					</select>
				</div> 

				<div id="filter-motor" class="filter-item">
					<div class="helparrow right"></div>
					<select disabled placeholder="Выберите двигатель" name="filter-motor" class="filter-select selectedBlock" >
						<option>Выберите двигатель</option>
						<option class="HistoryCar" selected value="<?php echo $cars['url']; ?>" ><?php echo $cars['motor']; ?></option>
					</select>
				</div> 
				<div id="ajax-preloader">
				</div>
			
			</div>
			<div class="filter-botton2">Сбросить выбор</div>
			<div class="filter-botton active double" style="background-color: rgb(62, 138, 87);">Подобрать запчасти</div>
		</div>
		<div class="filter-text">
			Отобажен последний выбранный. Для выбора другого автомобиля нажмите на соотв. кнопку.
		</div>
	<?php
	}
			?>
	<?php } else { ?>
	
	<div class="filter-content">
		
		<div class="selected-filter"><?php echo $mark.'<br/>'.$model.'<br/>'.$year.'<br/>'.$motor; ?></div>
		<div class="filter-botton filter-cancel">Отменить фильтр</div>
	</div>
	<?php } ?>

	<img src="/image/mini-cars.png" />
	</div>
	<div class="filter-right">
		<img src="catalog/view/theme/default/image/bigcar.png" />
	</div>
</div>
<div class="home-catalog">
	<h4 class="home-catalog-title">Каталог запчастей</h4>
	<ul class="clearfix">
		<li>
			<div class="hcg" data-id="10">
				<a href="/autoparts/audi/" title="Запчасти для Audi">
					<div class="home-mark-img">
						<img src="image/data/marks/10.png" alt="Запчасти для Audi">
					</div>
					<h5>Audi</h5>
				</a>
			</div>
		</li>
		<li>
			<div class="hcg" data-id="63">
			<a href="/autoparts/ford/" title="Запчасти для Ford">
					<div class="home-mark-img">
						<img src="image/data/marks/63.png" alt="Запчасти для Ford">
					</div>
					<h5>Ford</h5>
				</a>
			</div>
		</li>
		<li>
			<div class="hcg" data-id="116">
				<a href="/autoparts/mercedes-benz/" title="Запчасти для Mersedes">
					<div class="home-mark-img">
						<img src="image/data/marks/116.png" alt="Запчасти для Mersedes">
					</div>
					<h5>Mercedes</h5>
				</a>
			</div>
		</li>
		<li>
			<div class="hcg" data-id="147">
				<a href="/autoparts/renault/" title="Запчасти для Renault">
					<div class="home-mark-img">
						<img src="image/data/marks/147.png" alt="Запчасти для Renault">
					</div>
					<h5>Renault</h5>
				</a>
			</div>
		</li>
		<li>
			<div class="hcg" data-id="184">
				<a href="/autoparts/vw/" title="Запчасти для Volkswagen">
					<div class="home-mark-img">
						<img src="image/data/marks/184.png" alt="Запчасти для Volkswagen">
					</div>
					<h5>Volkswagen</h5>
				</a>
			</div>
		</li>
		<li>
			<div class="hcg" data-id="79">
				<a href="/autoparts/hyundai/" title="Запчасти для Hyundai">
					<div class="home-mark-img">
						<img src="image/data/marks/79.png" alt="Запчасти для Hyundai">
					</div>
					<h5>Hyundai</h5>
				</a>
			</div>
		</li>
		<li>
			<div class="hcg" data-id="18">
				<a href="/autoparts/bmw/" title="Запчасти для BMW">
					<div class="home-mark-img">
						<img src="image/data/marks/18.png" alt="Запчасти для BMW">
					</div>
					<h5>BMW</h5>
				</a>
			</div>
		</li>
		<li>
			<div class="hcg" data-id="42">
				<a href="/autoparts/daewoo/" title="Запчасти для Daewoo">
					<div class="home-mark-img">
						<img src="image/data/marks/42.png" alt="Запчасти для Daewoo">
					</div>
					<h5>Daewoo</h5>
				</a>
			</div>
		</li>
		<li>
			<div class="hcg" data-id="123">
				<a href="/autoparts/mitsubishi/" title="Запчасти для Mitsubishi">
					<div class="home-mark-img">
						<img src="image/data/marks/123.png" alt="Запчасти для Mitsubishi">
					</div>
					<h5>Mitsubishi</h5>
				</a>
			</div>
		</li>
		<li>
			<div class="hcg" data-id="176">
				<a href="/autoparts/toyota/" title="Запчасти для Toyota">
					<div class="home-mark-img">
						<img src="image/data/marks/176.png" alt="Запчасти для Toyota">
					</div>
					<h5>Toyota</h5>
				</a>
			</div>
		</li>
		<li>
			<div class="hcg" data-id="130">
				<a href="/autoparts/opel/" title="Запчасти для Opel">
					<div class="home-mark-img">
						<img src="image/data/marks/130.png" alt="Запчасти для Opel">
					</div>
					<h5>Opel</h5>
				</a>
			</div>
		</li>
		<li>
			<div class="hcg" data-id="35">
				<a href="/autoparts/chevrolet/" title="Запчасти для Chevrolet">
					<div class="home-mark-img">
						<img src="image/data/marks/35.png" alt="Запчасти для Chevrolet">
					</div>
					<h5>Chevrolet</h5>
				</a>
			</div>
		</li>
	</ul>
	<div class="for-bg-a"><a href="/autoparts/" class="home-catalog-btn">Смотреть весь каталог</a></div>
</div>
<div class="hcr">

</div>
<?php /*<div class="why-buy">
	<h4 class="why-buy-title">Почему покупают у нас?</h4>
	<ul class="clearfix">
		<li>
			<img src="/image/data/home/b1.png" alt="Запчасти для home"/>
			<h3>Большой  ассортимент</h3>
			<p>В ассортименте более 800 запчастей к 500 видам автомобилейй</p>
		</li>
		<li>
			<img src="/image/data/home/b2.png" alt="home"/>
			<h3>Наличие товара</h3>
			<p>В ассортименте более 800 запчастей к 500 видам автомобилейй</p>
		</li>
		<li>
			<img src="/image/data/home/b3.png" alt="home"/>
			<h3>Оперативная  доставка</h3>
			<p>В ассортименте более 800 запчастей к 500 видам автомобилейй</p>
		</li>
		<li>
			<img src="/image/data/home/b4.png" alt="home"/>
			<h3>консультация мастера</h3>
			<p>В ассортименте более 800 запчастей к 500 видам автомобилейй</p>
		</li>
	</ul>
</div>*/ ?>
<div class="home">
<?php // echo $content_top; 
?>
<?php //echo $content_bottom; 
?>
</div>

<script type="text/javascript" src="catalog/view/javascript/homepage.js?2505" async></script>
<?php echo $footer; 
?>