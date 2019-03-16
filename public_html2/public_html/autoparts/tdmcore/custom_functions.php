<?php 
function getPrice($prices) {
	if(!is_array($prices)) 
		return $prices; 
	else {
		$i=$summ_price=0;
		foreach($prices as $price) {
			$i++;
			$summ_price+=$price;
		}
		 
		
		if($i!=0)
			$price=$summ_price/$i;
		else $price=0;
		
		
		if($price>=10000) $price+=0.15*$price; else
		if($price>=5000) $price+=0.22*$price; else
		if($price>=2000) $price+=0.22*$price; else
		if($price>=1500) $price+=0.25*$price; else
		if($price>=1000) $price+=0.25*$price; else
		if($price>=500) $price+=0.30*$price; else
		if($price>=100) $price+=0.30*$price; else
			$price+=0.4*$price;
		
			
			
			
		return round($price);
	}
}
function imageLoader($image,$server_path='http://77.120.224.229/') {
	
	if($image=='/autoparts/media/images/nopic.jpg') 
		return $image;
	
	$image_path_preg = str_replace('/','\/',$server_path.'images/');
	$local=preg_replace('/^'.$image_path_preg.'/', '', $image);
	$url='/image/products/'.$local;
	if(!file_exists($_SERVER['DOCUMENT_ROOT'].$url)) {
		$content = file_get_contents($image);
		file_put_contents($_SERVER['DOCUMENT_ROOT'].$url, $content);
	}
//	return $_SERVER['DOCUMENT_ROOT'].'image/products/'.$path.'/';


	return $url;
}
?>