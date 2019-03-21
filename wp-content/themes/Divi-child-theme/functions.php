<?php




function tatwerat_startSession() {
    if(!session_id()) {
        session_start();
    }
}

add_action('init', 'tatwerat_startSession', 1);

//error_reporting( E_ALL );        ini_set('display_errors', 1);
function my_theme_enqueue_styles() {

    $parent_style = 'divi-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
    //echo get_template_directory_uri();
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

function eo_get_usermeta($meta_key)
{
    $current_user = wp_get_current_user();
    $ret = (($current_user instanceof WP_User) && (0 != $current_user->ID)) ?
        $current_user->__get($meta_key) : '';

    return $ret;
}


add_filter('gform_field_value_first_name', 'eo_populate_name');
add_filter('gform_field_value_last_name',  'eo_populate_name');



function eo_populate_name($value)
{



    // extract the parameter name from the current filter name
    $param = str_replace('gform_field_value_', '', current_filter());

    // we are interested only in the first_name and last_name parameters
    if ( !in_array($param, array('first_name', 'last_name')) )
        return $value;

    // incidentally, the user meta keys for the first and last name are
    // 'first_name' and 'last_name', the same as the parameter names
    $value = eo_get_usermeta($param);

    return $value;
}

function gform_column_splits($content, $field, $value, $lead_id, $form_id) {





    if(!is_admin()) { // only perform on the front end
        if($field['type'] == 'section') {
            $form = RGFormsModel::get_form_meta($form_id, true);

            // check for the presence of multi-column form classes
            $form_class = explode(' ', $form['cssClass']);
            $form_class_matches = array_intersect($form_class, array('two-column', 'three-column'));

            // check for the presence of section break column classes
            $field_class = explode(' ', $field['cssClass']);
            $field_class_matches = array_intersect($field_class, array('gform_column'));
         
            // if field is a column break in a multi-column form, perform the list split
            if(!empty($form_class_matches) && !empty($field_class_matches)) { // make sure to target only multi-column forms

                // retrieve the form's field list classes for consistency
                $form = RGFormsModel::add_default_properties($form);
                $description_class = rgar($form, 'descriptionPlacement') == 'above' ? 'description_above' : 'description_below';

                // close current field's li and ul and begin a new list with the same form field list classes
                return '</li></ul><ul class="gform_fields '.$form['labelPlacement'].' '.$description_class.' '.$field['cssClass'].'"><li class="gfield gsection empty">';

            }
        }
    }

    return $content;
}

add_filter('gform_field_content', 'gform_column_splits', 100, 5);


function wpa_content_filter( $content ) {
    // run your code on $content and
    $html =  $content;


    $dom = new DOMDocument;
    $dom->loadHTML($html);
    $xpath = new DOMXPath($dom);
    $nodes = $xpath->query('//a/@href');

    foreach($nodes as $href) {
         if ($href->nodeValue){
            $parsed_url = parse_url($href->nodeValue);

            if (in_array($parsed_url['scheme'],array('http','https'))){

                if (($parsed_url['path'])){

                    if($parsed_url['query']){
                        $content .= do_shortcode('[wonderplugin_pdf  src="'.$href->nodeValue.'" width="100%" height="1505px"  style="border:0;"]');

                    }else {

                        $path_parts = pathinfo($parsed_url['path']);
                        //  print_r ($path_parts['basename']);
                        if ($path_parts['extension'] == 'pdf') {
                            $content .= do_shortcode('[wonderplugin_pdf  src="' . $href->nodeValue . '" width="100%" height="1505px"  style="border:0;"]');

                        } else {
                            $content .= do_shortcode('[wonderplugin_pdf  src="http://tntwf.org/reg/wp-content/uploads/2018/12/Athlete-Release-Form.pdf" width="100%" height="1505px"  style="border:0;"]');
                            $content .= ' <style type="text/css">


                            label.gfield_label {

                            display: inline-block;
                            margin-right: 10px;
                            }
                            }
                            </style>';
                        }
                    }

                }else{

                    $content .= do_shortcode('[wonderplugin_pdf  src="http://tntwf.org/reg/wp-content/uploads/2018/12/Athlete-Release-Form.pdf" width="100%" height="1505px"  style="border:0;"]');
                    $content .= ' <style type="text/css">
                           label.gfield_label {

                            display: inline-block;
                            margin-right: 10px;
                            }
                            }
                            </style>';
                }

                $content .= ' <style type="text/css">


                    label.gfield_label {

                    display: inline-block;
                    margin-right: 10px;
                }
                }
                </style>';
            }

        }

        // create the new element

    }

    return $content;
}

// high priority, run early
add_filter( 'the_content', 'wpa_content_filter' );



include('fees_calc_page.php');


add_filter( 'ajax_query_attachments_args', 'wpb_show_current_user_attachments' );

function wpb_show_current_user_attachments( $query ) {
    $user_id = get_current_user_id();
    if ( $user_id && !current_user_can('activate_plugins') && !current_user_can('edit_others_posts
') ) {
        $query['author'] = $user_id;
    }
    return $query;
}
	
	 
 
//add_action( 'bp_ready', 'get_update_all_athltes' );

// add_action( 'bp_ready', 'get_update_all_athltes_edit_url' );

// adding edit url
function get_update_all_athltes_edit_url(){

    $users = get_users( $args );
    $i=1;


    foreach(   $users as $user ){


        $i++;
        if( function_exists( 'xprofile_get_field_data' ) ) {

            $u = new WP_User( $user->ID );

            // Get the user object.
            $user = get_userdata( $user->ID  );

// Get all the user roles as an array.
            $user_roles = $user->roles;

// Check if the role you're interested in, is present in the array.
            if ( in_array( 'athlete', $user_roles, true ) ) {


                if (xprofile_get_field_data( 'MemberTypeText', $user->ID ) == 'athlete') {
                    echo "==". $user->ID."   ==".xprofile_get_field_data( 'MemberTypeText', $user->ID );
                    xprofile_set_field_data( 111, $user->ID, get_site_url().'/athlete-update-form/?user_id='.$user->ID );

                }
            }







        }else{
            echo "NO";
        }

    }

    exit;

}


// add_action( 'bp_ready', 'get_update_all_athltes_team' );
function get_update_all_athltes_team(){

    $users = get_users( $args );
    $i=1;


    foreach(   $users as $user ){


        $i++;
        if( function_exists( 'xprofile_get_field_data' ) ) {

            $u = new WP_User( $user->ID );

            // Get the user object.
            $user = get_userdata( $user->ID  );

// Get all the user roles as an array.
            $user_roles = $user->roles;

// Check if the role you're interested in, is present in the array.
            if ( in_array( 'athlete', $user_roles, true ) ) {


                if (xprofile_get_field_data( 'MemberTypeText', $user->ID ) == 'athlete') {

                   $team =  xprofile_get_field_data( 'Team', $user->ID ) ;

                    print_r ($team);
                    echo "==". $user->ID."   ==". $team."<br/>" ;
                    if(is_array($team)) xprofile_set_field_data( 3, $user->ID, $team[0] );

                }
            }







        }else{
            echo "NO";
        }

    }

   // exit;

}



function get_update_all_athltes(){

    $users = get_users( $args );
    $i=1;


    foreach(   $users as $user ){


        $i++;
        if( function_exists( 'xprofile_get_field_data' ) ) {

            $u = new WP_User( $user->ID );

            // Get the user object.
            $user = get_userdata( $user->ID  );

// Get all the user roles as an array.
            $user_roles = $user->roles;

// Check if the role you're interested in, is present in the array.
            if ( in_array( 'subscriber', $user_roles, true ) ) {
                print_r ( $user_roles);
                echo "==". $user->ID."   ==".xprofile_get_field_data( 'MemberTypeText', $user->ID );
                if (xprofile_get_field_data( 'MemberTypeText', $user->ID ) == 'athlete') {


                   // echo xprofile_get_field_data('MemberTypeText', $user->ID);
                    bp_set_member_type($user->ID, 'athlete');
                   // echo	bp_get_member_type($user->ID );
                    $u->remove_role( 'subscriber' );
                    $u->add_role( 'athlete' );
                }
            }
          /*  if( $u->has_cap('athlete') ){
                echo $i."  ";
                echo "test";
                $i++;



                if (xprofile_get_field_data( 'MemberTypeText', $user->ID ) == 'athlete') {
                    echo xprofile_get_field_data('MemberTypeText', $user->ID);
                    bp_set_member_type($user->ID, 'athlete');
                    echo	bp_get_member_type($user->ID );
                    $u->remove_role( 'subscriber' );
                    $u->add_role( 'athlete' );
                }


                //    bp_set_member_type($user->ID, 'coache');
                // 	echo	bp_get_member_type($user->ID );
                //   $u = new WP_User( $user->ID );
                // Remove role
                //   $u->remove_role( 'athlete' );
                //     echo $user->ID;
                // Add role
                //    	$u->add_role( 'Coache' );
                //	$user_athlete =$user_athlete;

                //	$Gender = xprofile_set_field_data( 111, $user->ID, get_site_url().'/athlete-update-form/?user_id='.$user->ID );


                //  }

            }

          */
        }else{
            echo "NO";
        }

    }

    exit;

}




function get_del_all_athltes(){
    require_once(ABSPATH.'wp-admin/includes/user.php' );
    require_once(ABSPATH.'wp-admin/includes/ms.php' );

	$users = get_users( $args );
	$i=1;
        global $wpdb;
    $user_search = $wpdb->get_results("SELECT ID, display_name, user_email FROM ".$wpdb->base_prefix."users");
		foreach(  $user_search as $user ){

            echo $i."  ".$user->ID."<br />";
            $i++;
			 if( function_exists( 'xprofile_get_field_data' ) ) {
				 
				 $u = new WP_User( $user->ID );

                 // Get the user object.
                 $user = get_userdata( $user->ID  );

// Get all the user roles as an array.
                 $user_roles = $user->roles;
                    print_r ($user_roles);
// Check if the role you're interested in, is present in the array.
                 if ( !in_array( 'coache', $user_roles, true ) ) {
                     // Do something.
                     if (wpmu_delete_user($user->ID)) {
                         echo 'User deleted' . $user->ID;
                         echo '<br>';

                     }
                 }
				if( $u->has_cap('athlete') ){
					echo $i."  ";
                    echo "test";
					$i++;


						
			        if (xprofile_get_field_data( 'MemberTypeText', $user->ID ) == 'athlete') {
                        echo xprofile_get_field_data('MemberTypeText', $user->ID);


                        if (wp_delete_user($user->ID)) {


                            if (wpmu_delete_user($user->ID)) {
                                echo 'User deleted' . $user->ID;
                                echo '<br>';

                            }

                        }
                    }


                    //    bp_set_member_type($user->ID, 'coache');
                    // 	echo	bp_get_member_type($user->ID );
                    //   $u = new WP_User( $user->ID );
                        // Remove role
                   //   $u->remove_role( 'athlete' );
                   //     echo $user->ID;
                        // Add role
                  //    	$u->add_role( 'Coache' );
                        //	$user_athlete =$user_athlete;

                        //	$Gender = xprofile_set_field_data( 111, $user->ID, get_site_url().'/athlete-update-form/?user_id='.$user->ID );


                  //  }
	
			    	}
				}else{
					echo "NO";
				}
		
		}

            exit;

}





include('curl_requets_ata.php');


// admin dashboard shortcodes
include('admin_panel.php');

//exit;


function header_widgets_init() {

    register_sidebar( array(

        'name' => 'Header Sidebar',

        'id' => 'header_sidebar',

        'before_widget' => '<aside class="widget %2$s">',

        'after_widget' => '</aside>',

        'before_title' => '<h2 class="widget-title">',

        'after_title' => '</h2>',

    ) );

}

add_action( 'widgets_init', 'header_widgets_init' );

include('widgets/team_selection.php');

    ?>