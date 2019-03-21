<?php

function adminpanel_shortcode() {
    wp_enqueue_style('adminfonts', get_stylesheet_directory_uri() . '/pages/admin_panel/fonts.css', array(), '0.1.0', 'all');
    wp_enqueue_style('adminstyle', get_stylesheet_directory_uri() . '/pages/admin_panel/admin_style.css', array(), '0.1.0', 'all');
    ob_start();
    require('pages/admin_panel/dashboard.php');
    return ob_get_clean();

}
add_shortcode('adminpanel', 'adminpanel_shortcode');

function adminpanel_shortcode_bottom() {
    wp_enqueue_style('adminfonts', get_stylesheet_directory_uri() . '/pages/admin_panel/fonts.css', array(), '0.1.0', 'all');
    wp_enqueue_style('adminstyle', get_stylesheet_directory_uri() . '/pages/admin_panel/admin_style.css', array(), '0.1.0', 'all');
    ob_start();
    require('pages/admin_panel/dashboard_bottom.php');
    return ob_get_clean();

}
add_shortcode('adminpanel_coach_links', 'adminpanel_coach_links');

function adminpanel_coach_links() {
    wp_enqueue_style('adminfonts', get_stylesheet_directory_uri() . '/pages/admin_panel/fonts.css', array(), '0.1.0', 'all');
    wp_enqueue_style('adminstyle', get_stylesheet_directory_uri() . '/pages/admin_panel/admin_style.css', array(), '0.1.0', 'all');
    ob_start();
    require('pages/admin_panel/dashboard_coach_links.php');
    return ob_get_clean();

}
add_shortcode('adminpanel_bottom', 'adminpanel_shortcode_bottom');

function adminpanel_dashboard_coaches_athletes_report() {

    wp_enqueue_style('adminfonts', get_stylesheet_directory_uri() . '/pages/admin_panel/fonts.css', array(), '0.1.0', 'all');
    wp_enqueue_style('adminstyle', get_stylesheet_directory_uri() . '/pages/admin_panel/admin_style.css', array(), '0.1.0', 'all');
    ob_start();
    require('pages/admin_panel/dashboard_coaches_athletes_report.php');
    return ob_get_clean();

}
add_shortcode('adminpanel_coaches_athletes_report', 'adminpanel_dashboard_coaches_athletes_report');

add_shortcode('adminpanel_athletes_report', 'adminpanel_athletes_report');
function adminpanel_athletes_report() {
	$form_id = 11;
	// $athletes_entries_count= GFAPI::count_entries( $form_id, $search_criteria );
	$athletes_entries_count=  count(user_athletes());
	
	// $search_criteria['field_filters'][] = array( 'key' => '14', 'value' => 'M' );
	
	// $athletes_male_entries_count= GFAPI::count_entries( $form_id, $search_criteria );

		
	
	
		foreach (user_athletes()  as $user_athlete){
					$Gender = xprofile_get_field_data( 'Gender', $user_athlete->ID );  
				  
					 if ($Gender == 'M' ){
						 
						 $users_athltes_male[] = $user_athlete;
					 }elseif($Gender == 'F' ){
						 $users_athltes_female[] = $user_athlete;  
					 }
					 $SCTPFormReceived = xprofile_get_field_data( 'SCTPFormReceived', $user_athlete->ID ); 
					
					if ($SCTPFormReceived){
					$athlete_payments[]= $user_athlete->ID;						
					}
		
		}
		
		
	
		
	
	$payments_athletes 	= count($athlete_payments);

	
	
	$athletes_male_entries_count= count($users_athltes_male);
	
	//$search_criteria_f['field_filters'][] = array( 'key' => '14', 'value' => 'F' );
	
	
	// $athletes_female_entries_count = GFAPI::count_entries( $form_id, $search_criteria_f );
	$athletes_female_entries_count = count($users_athltes_female);
	
	$fm_ratio = $athletes_male_entries_count.":".$athletes_female_entries_count ;
	//print_r ($athletes_male_entries_count);
    wp_enqueue_style('adminfonts', get_stylesheet_directory_uri() . '/pages/admin_panel/fonts.css', array(), '0.1.0', 'all');
    wp_enqueue_style('adminstyle', get_stylesheet_directory_uri() . '/pages/admin_panel/admin_style.css', array(), '0.1.0', 'all');
    ob_start();
    require('pages/admin_panel/dashboard_athletes_report.php');
    return ob_get_clean();

}

function adminpanel_coaches_communiactions() {
	//$form_id = 4;
	//$coaches_entries_count= GFAPI::count_entries( $form_id, $search_criteria );
	$coaches_entries_count = count(user_coaches());
		foreach (user_coaches() as $user_coaches){
					$Payment    = xprofile_get_field_data( 'Payment', $user_coaches->ID );
					$background = xprofile_get_field_data( 'Background', $user_coaches->ID ); 
					if ($Payment){
					$coaches_payments[]= $user_coaches->ID;	
					}
					
					if($background){
						$coaches_background[]= $user_coaches->ID;	
					}
					
		}
	
	$payments_coaches 	= count($coaches_payments);
	$backgr = count($coaches_background);
	
	
	
    wp_enqueue_style('adminfonts', get_stylesheet_directory_uri() . '/pages/admin_panel/fonts.css', array(), '0.1.0', 'all');
    wp_enqueue_style('adminstyle', get_stylesheet_directory_uri() . '/pages/admin_panel/admin_style.css', array(), '0.1.0', 'all');
    ob_start();
    require('pages/admin_panel/dashboard_coaches_communiactions.php');
    return ob_get_clean();

}



add_shortcode('adminpanel_coaches_communiactions', 'adminpanel_coaches_communiactions');
add_shortcode('dashboard_coaches_athletes_report', 'dashboard_coaches_athletes_report');

function dashboard_coaches_athletes_report() {
	
	
    wp_enqueue_style('adminfonts', get_stylesheet_directory_uri() . '/pages/admin_panel/fonts.css', array(), '0.1.0', 'all');
    wp_enqueue_style('adminstyle', get_stylesheet_directory_uri() . '/pages/admin_panel/admin_style.css', array(), '0.1.0', 'all');
    ob_start();
    require('pages/admin_panel/dashboard_coaches_athletes_report.php');
    return ob_get_clean();

}


function dashboard_coaches__athlete_communiactions() {
		
    wp_enqueue_style('adminfonts', get_stylesheet_directory_uri() . '/pages/admin_panel/fonts.css', array(), '0.1.0', 'all');
    wp_enqueue_style('adminstyle', get_stylesheet_directory_uri() . '/pages/admin_panel/admin_style.css', array(), '0.1.0', 'all');
    ob_start();
    require('pages/admin_panel/dashboard_coaches__athlete_communiactions.php');
    return ob_get_clean();

}



add_shortcode('dashboard_coaches__athlete_communiactions', 'dashboard_coaches__athlete_communiactions');

add_shortcode('dashboard_coaches_statistics', 'dashboard_coaches_statistics');


function dashboard_coaches_statistics() {
	//$form_id = 4;
	//$coaches_entries_count= GFAPI::count_entries( $form_id, $search_criteria );
	$coaches_entries_count = count(user_coaches());
		foreach (user_coaches() as $user_coaches){
					$Payment    = xprofile_get_field_data( 'Payment', $user_coaches->ID );
					$background = xprofile_get_field_data( 'Background', $user_coaches->ID ); 
					if ($Payment){
					$coaches_payments[]= $user_coaches->ID;	
					}
					
					if($background){
						$coaches_background[]= $user_coaches->ID;	
					}
					
		}
		
		$athletes_entries_count=  count(user_athletes());
	
	
	$total_forms = $coaches_entries_count+$athletes_entries_count;
	foreach (user_athletes() as $user_athlete){
					$SCTPFormReceived = xprofile_get_field_data( 'SCTPFormReceived', $user_athlete->ID ); 
					
					if ($SCTPFormReceived){
					$athlete_payments[]= $user_athlete->ID;	
					
					}
					
	}
	
	
	
	$payments_coaches 	= count($coaches_payments);
	$payments_athletes 	= count($athlete_payments);
	$backgr = count($coaches_background);
	
	$payments = $payments_coaches+$payments_athletes;
	$percent = ($payments*100)/$total_forms;
	
	$percent = number_format(round($percent ,1));
		
	
    wp_enqueue_style('adminfonts', get_stylesheet_directory_uri() . '/pages/admin_panel/fonts.css', array(), '0.1.0', 'all');
    wp_enqueue_style('adminstyle', get_stylesheet_directory_uri() . '/pages/admin_panel/admin_style.css', array(), '0.1.0', 'all');
    ob_start();
    require('pages/admin_panel/dashboard_coaches_statistics.php');
    return ob_get_clean();

}




function adminpanel_graphics() {
	
	// $form_id = 4;	$coaches_entries_count= GFAPI::count_entries( $form_id, $search_criteria );
	
	
	
	// $form_id = 11; 	$athletes_entries_count= GFAPI::count_entries( $form_id, $search_criteria );
	
	$athletes_entries_count=  count(user_athletes());
	$coaches_entries_count = count(user_coaches());
	
	$total_forms = $coaches_entries_count+$athletes_entries_count;
	foreach (user_athletes() as $user_athlete){
					$SCTPFormReceived = xprofile_get_field_data( 'SCTPFormReceived', $user_athlete->ID ); 
					
					if ($SCTPFormReceived){
					$athlete_payments[]= $user_athlete->ID;	
					
					}
					
	}
	
	foreach (user_coaches() as $user_coaches){
					$Payment    = xprofile_get_field_data( 'Payment', $user_coaches->ID );
					$background = xprofile_get_field_data( 'Background', $user_coaches->ID ); 
					if ($Payment){
					$coaches_payments[]= $user_coaches->ID;	
					}
					
					if($background){
						$coaches_background[]= $user_coaches->ID;	
					}
					
	}
	
	$payments_coaches 	= count($coaches_payments);
	$payments_athletes 	= count($athlete_payments);
	$backgr = count($coaches_background);
	
	$payments = $payments_coaches+$payments_athletes;
	$percent = ($payments*100)/$total_forms;
	
	$percent = number_format(round($percent ,1));
    wp_enqueue_style('adminfonts', get_stylesheet_directory_uri() . '/pages/admin_panel/fonts.css', array(), '0.1.0', 'all');
    wp_enqueue_style('adminstyle', get_stylesheet_directory_uri() . '/pages/admin_panel/admin_style.css', array(), '0.1.0', 'all');
    ob_start();
   require('pages/admin_panel/adminpanel_graphics.php');
    return ob_get_clean();

}
add_shortcode('adminpanel_graphics', 'adminpanel_graphics');

function user_athletes(){
// rusty code start
			if( is_user_logged_in() ) {
				$user = wp_get_current_user();
				$role = ( array ) $user->roles;

			  
			  if(in_array('admins', $role)){
					$users = get_users( array( 'fields' => array( 'ID' ),'role' => 'athlete' ) );
			  }elseif(in_array('coache', $role)){
				  $team = xprofile_get_field_data( 'Team', $user->ID );  
				  $users = get_users( array( 'fields' => array( 'ID' ),'role' => 'athlete', ) );
				  foreach ($users as $us){
					 $team_athlete= xprofile_get_field_data( 'Team', $us->ID ); 
					 if ($team_athlete == $team ){
						 
						 $users_athltes[] = $us;
					 }
					  
				  }
				$users=$users_athltes;
				  
				
			  }
			 			 
			}
			
		$team_sel = $_REQUEST['team_selection'];

        if ( isset( $team_sel ) ){

            $_SESSION['team_sel'] = $team_sel;

        }

        $team_sel = $_SESSION['team_sel'];

		
	foreach ($users as $athl){
		
			
		   if (xprofile_get_field_data( 'Team', $athl->ID ) == $team_sel ) {
                                       

				$athletes[]=$athl;
                                      
			}
			
			 if($team_sel == 'All'  || $team_sel == '') $athletes[]=$athl;
		
	}
	
	return 	$athletes;	
}


function user_coaches(){
// rusty code start
			if( is_user_logged_in() ) {
				$user = wp_get_current_user();
				$role = ( array ) $user->roles;
		
			  
			  
			  if(in_array('admins', $role)){
					$users = get_users( array( 'fields' => array( 'ID' ),'role' => 'coache' ) );
			  }elseif(in_array('coache', $role)){
				  $team = xprofile_get_field_data( 'Team', $user->ID );  
				  $users = get_users( array( 'fields' => array( 'ID' ),'role' => 'coache', ) );
				  foreach ($users as $us){
					 $team_athlete= xprofile_get_field_data( 'Team', $us->ID ); 
					 if ($team_athlete == $team ){
						 
						 $users_athltes[] = $us;
					 }
					  
				  }
				$users=$users_athltes;
				  
				
			  }
			 			 
			}
				$team_sel = $_REQUEST['team_selection'];

        if ( isset( $team_sel ) ){

            $_SESSION['team_sel'] = $team_sel;

        }

        $team_sel = $_SESSION['team_sel'];

		
	foreach ($users as $coach){
		
			
		   if (xprofile_get_field_data( 'Team', $coach->ID ) == $team_sel ) {
                                       

				$coaches[]=$coach;
                                      
			}
			
			 if($team_sel == 'All'  || $team_sel == '') $coaches[]=$coach;
		
	}
	
	return 	$coaches;		
			
			
	
}




    add_action( 'wp_footer', 'user_idt_id' );

        function user_idt_id(){




            ?>

            <script type="text/javascript">

                jQuery(document).ready(function() {

                  jQuery('.wpDataTable').find('.column-edituser').find('a').addClass('cheese-style');
                  var col =   jQuery('.wpDataTable').find('.column-edituser').find('a');
                    console.log(col);
                    jQuery.each( col, function( key, value ) {
                       console.log(value);
                    });

                    jQuery('a').each(function (index, value){
                        console.log( jQuery(this).attr('href'));
                    });


                });
                </script>

        <?php



        }


function team_selection_shortcode() {

    wp_enqueue_style('team_select', get_stylesheet_directory_uri() . '/pages/admin_panel/team_select_style.css', array(), '0.1.0', 'all');
    ob_start();
    require('pages/admin_panel/team_select.php');
    return ob_get_clean();

}
add_shortcode('team_selection', 'team_selection_shortcode');