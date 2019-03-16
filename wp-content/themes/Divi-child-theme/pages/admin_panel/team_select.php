
<?php
$team_sel = $_REQUEST['team_selection'];

if ( isset( $team_sel ) ){

    $_SESSION['team_sel'] = $team_sel;

}

$team_sel = $_SESSION['team_sel'];

$teams = array('','3 @ 8','Arlington Trappers','Bethel University','BGA','Briarcrest Trap Club',
    'Cannon County HS Trap','Carroll County Claybusters','CBHS Brothers In Arms','CCTA - NO OPTION',
    'Cedar City Straights','Cedar View Shooters','Centennial Clay Target Team','Clarksville Academy',
    'Clarksville Christian School','Clay County Trap','Claygunners Skeet & Trap Team','Cocke County Clay Busters',
    'Coffee County Middle Claybusters','Coffee County Claybusters','Collierville High School Trap Team','Columbia Academy GunDawgs','Columbia Central High School','Cornfield Shooting Team',
    'CPA Minutemen','CTC-Tennessee','Cumberland County Youth Shooting Sports','Dickson Clay Commanders',
    'Dyer County Clay Target Team','Dylan Prince','Eagleville Clay Target Team',
    'East Tennessee Straight Shooters','ECS Trap','FACS Trap','Fayette Academy Vikings',
    'FBA Eagles','Franklin High School','Germantown High School','Gibson County Pioneers',
    'Giles County High School Trap Team','Giles County Clay Dusters','Goodpasture Shooting Team',
    'Grace Christian Academy','Greene County Trap','Hampshire Trap Team','Hardin County HITMEN',
    'Harding Academy of Memphis','Haywood Young Guns','Henderson Co. 4-H Trap Team','Henry Co. No Fly Zone',
    'Heritage Shooting Team','HFA Clay Target Team','Hoodlum Alley Claybusters','Houston County Lucky Shots',
    'Houston High School Trap Team','HSSC Crush','Hutchison','Independence High School Talons','Independence Trap Team','Jefferson County 4-H Patriot Shooters',
    'Bartlett Trap Team');
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