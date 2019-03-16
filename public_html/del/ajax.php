<?php
require_once('config.php');
$db = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
mysql_select_db(DB_DATABASE, $db) or die(mysql_error());
mysql_query('SET NAMES utf8');
if(isset($_POST['action'])) {
	if($_POST['action'] == 'year') {
		$sql = mysql_query('SELECT `start_production_year`, `end_production_year`  FROM `car_modification` WHERE `id_car_model` = '.$_POST['model']);

		if(mysql_num_rows($sql) > 0) {
			$mass = array();
			echo '<option value="">-</option>';
			while($res = mysql_fetch_array($sql)) {
				$ys = 1980;
				$ye = 2015;
				if(strlen($res['start_production_year'])) {
						$ys = $res['start_production_year'];
				}
				if(strlen($res['end_production_year'])) {
						$ye = $res['end_production_year'];
				}
				for($i = $ys; $i <= $ye; $i++) {
					if(!in_array($i, $mass)) {
						$mass[] = $i;
					}
				}
			}
		sort($mass);
		foreach($mass as $i) {
		echo '<option value="'.$i.'">'.$i.'</option>';
		}

		};
	}
	if($_POST['action'] == 'model') {
		$sql = mysql_query('SELECT `id_car_model`, `name` FROM `car_model` WHERE `id_car_mark` = '.intval($_POST['mark']));
		if(mysql_num_rows($sql)) {
			echo '<option value="">-</option>';
			while($res = mysql_fetch_array($sql)) {
				echo '<option value="'.$res['id_car_model'].'">'.$res['name'].'</option>';
			}
		}
	}
	if($_POST['action'] == 'model-home') {
		$sql = mysql_query('SELECT `id_car_model`, `name` FROM `car_model` WHERE `id_car_mark` = '.intval($_POST['mark']));
		if(mysql_num_rows($sql)) {
			echo '<div><h3>Выбирите модель</h3>';
			while($res = mysql_fetch_array($sql)) {
				echo '<div class="mhcb" data-id="'.$res['id_car_model'].'">'.$res['name'].'</div>';
			}
			echo '</div>';
		}
	}
	if($_POST['action'] == 'motor-home') {
		$sql = mysql_query('SELECT id_car_modification, name FROM car_modification WHERE 
		id_car_model = '.$_POST['model'].' GROUP BY name ORDER BY name ASC');
		if(mysql_num_rows($sql)) {
			echo '<div><h3>Выбирите двигатель</h3>';
			while($res = mysql_fetch_array($sql)) {
				echo '<div class="mohcb" data-idm="'.$_POST['model'].'" data-id="'.$res['id_car_modification'].'">'.$res['name'].'</div>';
			}
			echo '</div>';
		}
	}
	if($_POST['action'] == 'motor') {
		$sql = mysql_query('SELECT id_car_modification, name FROM car_modification WHERE 
		id_car_model = '.$_POST['model'].' AND  start_production_year <= '.$_POST['year'].' AND (end_production_year >= '.$_POST['year'].' OR end_production_year IS NULL) GROUP BY name ORDER BY name ASC');
		if(mysql_num_rows($sql)) {
			echo '<option value="">-</option>';
			while($res = mysql_fetch_array($sql)) {
				echo '<option value="'.$res['id_car_modification'].'">'.$res['name'].'</option>';
			}
		}
	}
	if($_POST['action'] == 'go') {
		setcookie('motor', $_POST['motor'], time()+3600, '/');
		setcookie('year', $_POST['year'], time()+3600, '/');
		setcookie('model', $_POST['model'], time()+3600, '/');
		setcookie('mark', $_POST['mark'], time()+3600, '/');
	}
	if($_POST['action'] == 'unset') {
		setcookie('motor', '', time()-3600, '/');
		setcookie('year', '', time()-3600, '/');
		setcookie('model', '', time()-3600, '/');
		setcookie('mark', '', time()-3600, '/');
	}
	
}
?>