<?php



// curl_reg();
//exit;

function curl_reg(){


    $data = array(
        'userID' => 1518979
     );


    $post_data = $data;
   // print_r ($data);

//traverse array and prepare data for posting (key1=value1)
   /* foreach ( $post_data as $key => $value) {
        $post_items[] = $key . '=' . $value;
    }
   */

//create the final string to be posted using implode()
    $post_string = implode ('&', $post_items);

//create cURL connection
   $curl_connection =         curl_init('https://shootata.com/ShooterInformationCenter/tabid/118/userID/1518979/year/2016/Default.aspx');

//set options
//set options
    curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($curl_connection, CURLOPT_USERAGENT,
        "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
    curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);

//set data to be posted
 //   curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);



//perform our request
    $result = curl_exec($curl_connection);
    //  print_r ($result);

 //   $xid= $this->parser_curl($result);
//show information regarding the request
    //   print_r(curl_getinfo($curl_connection));
         echo curl_errno($curl_connection) . '-' . curl_error($curl_connection);

//close the connection
   curl_close($curl_connection);

    return  $xid;
}


function parser_curl($content){
    preg_match_all('#parent.submenu.document.location="(.*?)"#is', $content, $matches);
    foreach ($matches as $value) {
        $js[]= $value;
    }

    $str =$js[1][0];

    parse_str($str, $arr);
    //   print_r ($matches);
    return $arr['xid'];

}




?>