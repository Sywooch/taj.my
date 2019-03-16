<?php
$json=array(
    "modelName"=> "AddressGeneral",
    "calledMethod"=> "getWarehouses",
    "methodProperties"=> array("CityName" => $_GET['city']),
    "apiKey"=> "dbfce779abd3fe9044306e3a058d29dc"
);


$url='https://api.novaposhta.ua/v2.0/json/';


$options = array(
  'http' => array(
    'method'  => 'POST',
    'content' => json_encode( $json ),
    'header'=>  "Content-Type: application/json\r\n" .
                "Accept: application/json\r\n"
    )
);
$context  = stream_context_create( $options );
$result = file_get_contents( $url, false, $context );
$response = json_decode	( $result,true );
if($response['success']==1&&$_GET['test']!=1) {
	$res="<select>";
	foreach($response['data'] as $obj) {
		$res.= "<option value=\"".$obj["DescriptionRu"]."\">".$obj["DescriptionRu"]."</option>";
	}
	$res.="</select>";
} else {
	var_dump($response['data'][0]);
}
echo $res;
?>
