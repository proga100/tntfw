<?php
/*
Plugin Name: WP Users List
Plugin URI: http://renuwp.wordpress.com
Description: A simple widget to show list of registerd users you can filter then by selcting filters
Version: 0.1
Author: Renu Sharma
Author URI: http://renuwp.wordpress.com
License: A "Slug" license name e.g. GPL2
/*  Copyright 2014  WP Users List - Renu Sharma (email : renusharma7@gmail.com)
 
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

class WP_users_widget extends WP_Widget {
	/** constructor -- name this the same as the class above */
    function WP_users_widget() {
        parent::WP_Widget(false, $name = 'WP Users');
    }
	function widget($args, $instance) {
		global $wp_roles;
		global $wp_user_roles;
		extract( $args );
     //   error_reporting( E_ALL );        ini_set('display_errors', 1);
       $user_role= restrictly_get_current_user_role();

       
		$title 		= apply_filters('widget_title', $instance['title']); // the widget title
		$number 	= $instance['number']; 
		$role 	= $instance['role'];


		$user_query = new WP_User_Query(
            array( 'role' =>$role,
                'number'=>$number,
                 'order'   => 'ASC'
            ));
    //    s25_member_loop($role);
        $cuser = wp_get_current_user();

        $team_sel = $_REQUEST['team_selection'];

        if ( isset( $team_sel ) ){

            $_SESSION['team_sel'] = $team_sel;

        }

        $team_sel = $_SESSION['team_sel'];

       if (!empty($user_role)):


		?>
			  <?php echo $before_widget; ?>
				  <?php if ( $title ) { echo $before_title . $title . $after_title; } 
				 ?>

						<ul class="ulist" style="height:1800px;overflow-y:scroll">
							<?php
                            foreach ( $user_query->results as $user ) {
                                if ('athlete' == $user_role ){

                                    if ($cuser->id == $user->id){
                                        $id = $user->ID;
                                        $user_info = get_userdata($id);
                                        $user_infos[] = $user_info;

                                    }

                                }else{
                                    $id = $user->ID;
                                    $user_info = get_userdata($id);
                                    $user_infos[] = $user_info;
                                }

                            }



                            uasort( $user_infos, function ( $a, $b ) {


                                $a->first_name = strtolower( $a->first_name );
                                $a->last_name = strtolower( $a->last_name );
                                $b->first_name = strtolower( $b->first_name );
                                $b->last_name = strtolower( $b->last_name );
                                // echo $a->last_name;
                                if ( $a->last_name == $b->last_name ) {
                                    if( $a->first_name < $b->first_name ) {
                                        return -1;
                                    }
                                    else if ($a->first_name > $b->first_name ) {
                                        return 1;
                                    }
                                    //last name and first name are the same
                                    else {
                                        return 0;
                                    }
                                }
                                return ( $a->last_name < $b->last_name ) ? -1 : 1;

                            });

                            $i=1;

                            foreach ( $user_infos as $user ) {
                                $id=$user->ID;

                                    if (xprofile_get_field_data( 'Team', $user->ID ) == $team_sel ) {
                                        ?>

                                        <li>
                                            <a <?php if ($role == 'coache') {
                                                echo 'href="coache-update-form?user_id=' . $id;
                                            } elseif ($role == 'athlete') {
                                                echo 'href="athlete-update-form?user_id=' . $id;
                                            }?>" ><h3><?php
                                                echo ucfirst($user->last_name) . "  " . ucfirst($user->first_name);
                                                ?></h3></a></li>
                                    <?php


                                        $i++;
                                    }


                                if($team_sel == 'All'){
                                        ?>

                                        <li>
                                            <a <?php if ($role == 'coache') {
                                                echo 'href="coache-update-form?user_id=' . $id;
                                            } elseif ($role == 'athlete') {
                                                echo 'href="athlete-update-form?user_id=' . $id;
                                            }?>" ><h3><?php
                                                echo ucfirst($user->last_name) . "  " . ucfirst($user->first_name);
                                                ?></h3>
                                            </a>
                                        </li>
                                    <?php

                                        $i++;
                                    }

                                }
                            ?>
						</ul>
			  <?php



        echo $after_widget;

       endif;

        if ($i<56){

         echo ' <style>
                .ulist{
                    height: auto !important;
                }

            </style>';

        }

        ?>
		<?php
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = strip_tags($new_instance['number']);
		$instance['role'] = strip_tags($new_instance['role']);
		return $instance;
	}
	
	function form($instance) {
		global $wp_roles;
        $title 		= esc_attr($instance['title']);
        $number		= esc_attr($instance['number']);
        $role	= esc_attr($instance['role']);
		 
		 
		global $wp_user_roles;
		$result = count_users();
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of User to display'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
        </p>
		<p>	
			<label for="<?php echo $this->get_field_id('role'); ?>"><?php _e('Choose the Role to display'); ?></label> 
			<select name="<?php echo $this->get_field_name('role'); ?>" id="<?php echo $this->get_field_id('role'); ?>" >
			<?php
			 foreach($result['avail_roles'] as $role2 => $count) {
					echo '<option id="' . $role2  . '"', $role2 == $role ? ' selected="selected"' : '', '>', $role2, '</option>';
				}
			?>
			</select>		
		</p>
        <?php
    }
}

//Add users Stylesheet
function wpusers_widgets_scripts(){
     if(!is_admin()){
        wp_register_style('userlist-style',plugins_url('/css/style.css', __FILE__ ));
        wp_enqueue_style('userlist-style');	
    }   
}
add_action( 'init', 'wpusers_widgets_scripts' );


//close11
add_action('widgets_init', create_function('', 'return register_widget("WP_users_widget");'));

function restrictly_get_current_user_role() {
    if( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $role = ( array ) $user->roles;
        return $role[0];
    } else {
        return false;
    }
}

function s25_member_loop($role) {


    $args = array(
        'role' => $role, // the role we're targeting
        'exclude' => '1', // exclude admin
        'fields' => 'all_with_meta',
        'meta_key' => 'last_name', //query on the last_name key
        'meta_key' => 'first_name', // also the first_name key
    );
    $membersquery = new WP_User_Query( $args );
    $members = $membersquery->results();
    foreach ($members as $user) {
        $id = $user->ID;
        $user_info[$id] = get_userdata($id);
    }
 // echo "<pre>";  print_r($user_info);

    // Sort $members by last name; if last name is the same, sort by first name
    uasort( $user_info, function ( $a, $b ){


        $a->first_name = strtolower( $a->first_name );
        $a->last_name = strtolower( $a->last_name );
        $b->first_name = strtolower( $b->first_name );
        $b->last_name = strtolower( $b->last_name );
        echo $a->last_name;
        if ( $a->last_name == $b->last_name ) {
            if( $a->first_name < $b->first_name ) {
                return -1;
            }
            else if ($a->first_name > $b->first_name ) {
                return 1;
            }
            //last name and first name are the same
            else {
                return 0;
            }
        }
        return ( $a->last_name < $b->last_name ) ? -1 : 1;
    });

    echo '<div id="my_members">';

    foreach ($user_info as $member) :

       print_r ($member->last_name);
        // Do Something with the returned array of users

    endforeach;



    echo '</div>';
}
?>
