<?php
/*
Plugin Name: shootdata-parser
Plugin URI: http://flance.info
Description: shootdata-parser  parces shootdata  site
Version: 0.1
Author: Rusty
Author URI: http://flance.info
License: A "Slug" license name e.g. GPL2
/*  Copyright 2014  
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// No direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

function shoodata_users() {

	$users = get_users( $args );
	
	$user_id = $_REQUEST['user_id'];
	if ($user_id){
		
	$user_id = $user_id;	
	}else{
	$user = wp_get_current_user();

	$user_id	 = $user->ID;
		
	}
  

  
	//	foreach( $users as $user ){
		//	$user_id	 = $user->ID;
			 if( function_exists( 'xprofile_get_field_data' ) ) {
				
				 $u = new WP_User( $user_id);
				if( $u ->has_cap('athlete') ){
						// echo $user->ID." <br />  ";

					$i++;					
						
		
				
				if (xprofile_get_field_data( 'ATAId', $user_id ) ){
					$ata_number	= xprofile_get_field_data( 'ATAId', $user_id ); 
				//	echo $user_id."=".$ata_number.	" <br />  ";
					
					$data = shootdata_parce($ata_number);
					// ata averag id 47 
					xprofile_set_field_data( 47, $user_id , $data['yardage']  );
					
					// ata memebership due  id 46
			xprofile_set_field_data( 46, $user_id , $data['membership']  );
				
				//	print_r ($data);
				}
	
				}
				}else{
					echo "NO";
				}
		
//	 }
		 
//exit;
	
}

function shootdata_parce($ata_number){
	
	$url = 'https://shootata.com/ShootetInformationCenter/tabid/118/userID/'.$ata_number.'/Default.aspx';
	
//	echo $url;
	  $curl_connection =         curl_init(	$url );
	//set options

    curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($curl_connection, CURLOPT_USERAGENT,
        "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
    curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);

//perform our request
    $result = curl_exec($curl_connection);
 
 $data = parser_shoot_curl($result);
//show information regarding the request
  
      //   echo curl_errno($curl_connection) . '-' . curl_error($curl_connection);

//close the connection
   curl_close($curl_connection);
	return $data;
}

function parser_shoot_curl($content){
	    $html =  $content;


    $dom = new DOMDocument;
    $dom->loadHTML($html);
      $container = $dom->getElementById("dnn_ctr976_View_ctl00_reportHeader");
		$textcont = $container->textContent;
		
		$yardage = explode("Yardage:", $textcont );
		
		$data['yardage'] = $yardage[1];
		$membership= explode("Name:", $textcont );
		$membership= explode("Membership:", $membership[0] );
		
		$data['membership'] = $membership[1];
		
		return $data;
	
}

add_action( 'bp_ready', 'shoodata_users' );


?>