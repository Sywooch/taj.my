
<?php

set_time_limit(0);

$filename = dirname(__FILE__) . '/category.json';

$host = 'http://opencart.local/old/';
$token = 'secreturkmodainua1111';
$languages = array('ru','en'); // ???????????? ?????????????????? ?? ???????????? name_ru or name_en - ?????????????? ?????????? ?? ????????????, ?????????????? ?? ????????????????. ?????????? ???????????? ???????????? - ?????? ???? ?????????? ???????????? ??????????????????. ???????? ???????????? - ????????????!!!!

print_r ($host);

$track = 'catalog/onebox/';

if (file_exists($filename)) {

    $log = fopen(dirname(__FILE__) . '/log.txt', 'a');
    $mytext = date(DATE_RFC2822) . "; \r\n";
    fwrite($log, $mytext);
    
//***********************************************
//    echo('UPDATE CATEGORY:');
//***********************************************
    $filename = 'category.json';
    $json_url = $track . $filename;
    $languages = json_encode($languages);
    $post = array ('json_url' => $json_url, 'languages' => $languages);
    $curl = curl_init( $host .'index.php?route=feed/rest_api/updateCategory&key=' . $token );
    curl_setopt_array( $curl, array(CURLOPT_RETURNTRANSFER=> TRUE, CURLOPT_POSTFIELDS => $post ) );

    $response = (curl_exec( $curl ));
    curl_close($curl);

    $filename1 = dirname(__FILE__) . '/' . $filename;
    fwrite($log,  'UPDATE CATEGORY: ' . $response . "\r\n");
    print_r  ( $response );
//    unlink($filename1);


//**********************************************
    //   echo('UPDATE PRODUCT:');
//**********************************************
    $filename = 'product.json';
    $json_url = $track . $filename;
 //   $languages = json_encode($languages);
    $post = array ('json_url' => $json_url, 'languages' => $languages);
    $curl = curl_init( $host .'index.php?route=feed/rest_api/updateProduct&key=' . $token );
    curl_setopt_array( $curl, array(CURLOPT_RETURNTRANSFER=> TRUE, CURLOPT_POSTFIELDS => $post ) );
    $response = (curl_exec( $curl ));
    curl_close($curl);
    $filename1 = dirname(__FILE__) . '/' . $filename;
    fwrite($log, 'UPDATE PRODUCT: ' . $response . "\r\n");
    print_r  ( 'UPDATE PRODUCT: ' . $response . "\r\n" );
  //  unlink($filename1);


    //**********************************************
    //   echo('UPDATE STATUS:');
    //***********************************************

//*********************************************************
//NOVY STATUS - ORDER!!!!
    /*
        $order_id = '1';
        $status_id = '3';

        $post = array ('order_id' => $order_id, 'status_id' => $status_id);
        $curl = curl_init( $host .'index.php?route=api/oneboxsync/updateOrder/&token=' . $token );
        curl_setopt_array( $curl, array(CURLOPT_RETURNTRANSFER=> TRUE, CURLOPT_POSTFIELDS => $post ) );
        $response = json_decode(curl_exec( $curl ));
        curl_close($curl);
        print_r ($response);
    */
//*******************************************


//*******************************************
//   echo('UPDATE FIlTRENAME:');
//********************************************
    $filename = 'filtername.json';
    $json_url = $track . $filename;
    $post = array ('json_url' => $json_url, 'languages' => $languages);
    $curl = curl_init( $host .'index.php?route=feed/rest_api/updateFiltreName&key=' . $token );
    curl_setopt_array( $curl, array(CURLOPT_RETURNTRANSFER=> TRUE, CURLOPT_POSTFIELDS => $post ) );
    $response = (curl_exec( $curl ));
    curl_close($curl);
    $filename1 = dirname(__FILE__) . '/' . $filename;
    fwrite($log, 'UPDATE FIlTRENAME: ' . $response . "\r\n");
    print_r  ( 'UPDATE FIlTRENAME: ' . $response . "\r\n" );

//   unlink($filename1);


//*****************************************
//    echo('UPDATE ORDER VALUE:');
//*****************************************
    /*
        $filename = 'filtervalue.json';
        $json_url = $track . $filename;
        $post = array ('json_url' => $json_url);
        $curl = curl_init( $host .'index.php?route=api/oneboxsync/updateOrderValue/&token=' . $token );
        curl_setopt_array( $curl, array(CURLOPT_RETURNTRANSFER=> TRUE, CURLOPT_POSTFIELDS => $post ) );
        $response = json_decode(curl_exec( $curl ));
        curl_close($curl);
    //    print_r ($response);
        fwrite($log, 'UPDATE ORDER VALUE: ' . $response . "</br>");
        unlink($filename);

    */

//*********************************************
//    echo('UPDATE FILTRE PRODUCT VALUE:');
//***********************************************
 /*   fwrite($log, 'UPDATE FILTRE PRODUCT VALUE: ');
    $filename = 'filtervalue.json';
    $json_url = $track . $filename;
    $post = array ('json_url' => $json_url);
    $curl = curl_init( $host .'index.php?route=feed/rest_api/updateFiltreProductValue&key=' . $token );
    curl_setopt_array( $curl, array(CURLOPT_RETURNTRANSFER=> TRUE, CURLOPT_POSTFIELDS => $post ) );
    $response = json_decode(curl_exec( $curl ));
    curl_close($curl);
//    print_r ($response . "</br>");

    fwrite($log, $response . "\r\n");
    $filename1 = dirname(__FILE__) . '/' . $filename;
  //  unlink($filename1);

    fclose($log);
*/
}
?>
