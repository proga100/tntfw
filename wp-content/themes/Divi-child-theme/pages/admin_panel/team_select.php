
<?php
$team_sel = $_REQUEST['team_selection'];

if ( isset( $team_sel ) ){

    $_SESSION['team_sel'] = $team_sel;

}

$team_sel = $_SESSION['team_sel'];

$teams = array('All','3 @ 8',
    "Haywood Young Guns",
    "William Blount Shooting Team",
    "Heritage Shooting Team",
    "Zion Eagle Eyes",
    "Bartlett Trap Team",
    "APSU",
    "Arlington Trappers",
    "EAST TENNESSEE STRAIGHT SHOOTERS",
    "Henderson Co. 4-H Trap Team",
    "BGA",
    "Warrior Shooting Team",
    "N2Dust Shotgun Sports",
    "Bethel Wildcats",
    "Dyer County Clay Target Team",
    "FHS Rebel Clays",
    "Harpeth Crush",
    "Briarcrest Trap Club",
    "T-County Clay Busters",
    "Monroe County Shooters",
    "Cumberland County Youth Shooting Sports",
    "McKENZIE SHOOTING SPORTS",
    "Clarksville Clay Target Association",
    "Henry County No Fly Zone",
    "Shelbyville Trap Team/ Bedford County Crush",
    "CBHS Brothers in Arms",
    "Cannon County HS Trap",
    "Clarksville Christian School",
    "Cedar View shooters",
    "Unaka Shooters",
    "Clay County 4-H Trap",
    "Centennial Clay Target Team",
    "Marshall County Youth Trap Team",
    "Clay Commanders",
    "Str8 Shooters Clay Team",
    "Southern Shooting Sports",
    "CPA Minutemen",
    "South Carroll Scholastic Shooting Team",
    "Clarksville Academy",
    "Cocke County Claybusters",
    "Coffee County Claybusters",
    "Coffee County Middle Claybusters",
    "Lead Shot Legends",
    "Collierville HS Trap Team",
    "Columbia Academy GunDawgs",
    "Columbia Central High School Clay Target Team",
    "Cornfield Shooting Team",
    "Covington Trap",
    "Jefferson Co 4-H Patriot Shooters",
    "Weakley County Top Guns",
    "Eagleville Clay Target Team",
    "ECS Trap Team",
    "Houston County Lucky Shots",
    "Giles County Wide",
    "Lawrence County Trap Team",
    "Fayette Academy Vikings",
    "FBA Eagles",
    "FACS SCTP",
    "GCA Lions",
    "Germantown Trap Team",
    "Gibson County Pioneers",
    "Goodpasture Shooting Team",
    "Hampshire Trap Team",
    "Hardin County HITMEN",
    "Tri-State Gun Club",
    "Harding Lion Shooters",
    "MBA Big Red",
    "HFA Clay Target Team",
    "Spring Hill Clay Target Team",
    "Obion County Shooting Sports",
    "Oakland High School Patriots",
    "Rossville Christian Academy",
    "Trousdale Trap Team",
    "Houston High School Trap Team",
    "Hutchison",
    "Independence Trap Team",
    "Three Rivers Clay Commanders",
    "Lewis County Trap",
    "Perry Co Trap Team",
    "Macon County Tigers",
    "SGC Shooting Sports Highschool",
    "MTCS",
    "SGC Shooting Sports Middleschool",
    "MUS Owls",
    "Nashville Christian",
    "NCS Trap Team",
    "Page High Clay Target Team",
    "JP II Knights",
    "Roane State Raiders",
    "Santa Fe SharpShooters",
    "Silverdale Baptist Academy",
    "Summit High School",
    "St. Agnes Shooting Stars",
    "St. Mary's Trap Team",
    "St. Benedict Eagles",
    "St. George's Gryphon Shooters",
    "Summertown Blastin' Crew",
    "Webb Feet",
    "UT Martin Clay Target Team",
    "Wayne County Shooting Sports"
);


	
if( is_user_logged_in() ) {
				$user = wp_get_current_user();
				$role = ( array ) $user->roles;
				
				if(in_array('admins', $role)){
				
			  }elseif(in_array('coache', $role)){
				  $team = xprofile_get_field_data( 'Team', $user->ID );  
				  
				$teams = array('All',$team );
				
			  }elseif(in_array('athlete', $role)){
				$teams  =null; 
			  }
		
}

if (isset($teams)):
?>


<div class="team_sel"><label >Team Selection</label>

    <form action="" id="team_form" method="get">

    <select name="team_selection" id="team_selection" class="medium gfield_select" aria-invalid="false">

        <?php
            foreach ($teams as $team){
                $selected =null;
                if ($team_sel==$team) $selected = 'selected';
              echo ' <option value="'.$team.'"  '.$selected.' >'.$team.'</option>' ;

            }

        ?>
        </select>


</div>

</form>


<script type="text/javascript">

    jQuery(function() {
        jQuery('#team_selection').change(function() {
            this.form.submit();
        });
    });
</script>

<?php endif; ?>

