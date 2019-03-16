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
		
		$title 		= apply_filters('widget_title', $instance['title']); // the widget title
		$number 	= $instance['number']; 
		$role 	= $instance['role'];


		$user_query = new WP_User_Query(array( 'role' =>$role,'number'=>$number ));
		?>
			  <?php echo $before_widget; ?>
				  <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
						<ul class="ulist">
							<?php  foreach ( $user_query->results as $user ) {
                                $id=$user->ID;
                               $user_info =  get_userdata($id);

							?>
								<li> <a <?php if ($role == 'coache')  {echo 'href="coache-update-form?user_id='.$id;
                                    }elseif($role == 'athlete') {
                                        echo 'href="athlete-update-form?user_id='.$id;
                                    }?>" ><h3><?php
                                        echo $user_info->last_name .  "  " . $user_info->first_name
                                             ?></h3></a></li>
							<?php } ?>
						</ul>
			  <?php echo $after_widget; ?>
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
?>
