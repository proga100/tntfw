<?php

add_shortcode( 'fees_calc', 'fees_calc_shortcode' );

function fees_calc_shortcode() {


    wp_register_script ('fees_sctp_script', get_stylesheet_directory_uri() . '/fees_calc_page/accounting.js', array( 'jquery' ),'1.0.0',true);
    wp_register_style ('fees_sctp_style', get_stylesheet_directory_uri() . '/fees_calc_page/system.css', array(),'1.0.0','all');

    wp_enqueue_script('fees_sctp_script');
    wp_enqueue_style( 'fees_sctp_style');
	
	

    
	
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

					
			


    ob_start();     ?>


    <form name="fees" target="main" action="/reg/processing/" method="get">
        <input type="hidden" name="pid" value="11527">
        <input type="hidden" name="peid" value="14382">
        <input type="hidden" name="fct" value="">
        <input type="hidden" name="SSF_price" class="SSF_price" value="0">
        <input type="hidden" name="TNTWF_price" class="TNTWF_price" value="0">
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tbody><tr>
                <td style="height:27;" class="title" width="100%">&nbsp;SCTP Team Fee Summary for <?php echo $team ?>
				as  of   <?php echo  date(' m/d/Y '); ?>&nbsp;&nbsp;&nbsp;<font color="yellow"></font></td>
            </tr>
            </tbody></table>
        <table border="0" width="700" cellspacing="0" cellpadding="1">
            <tbody><tr height="0">
                <td width="300"></td>
                <td width="400"></td>
            </tr>
            <tr>
                <td>
                    &nbsp;<b>Scholastic Clay Target Program (SCTP)</b><br>
                    &nbsp;165 Bay Ridge Lane<br>
                    &nbsp;Burlington, WI 53105<br>
                    &nbsp;<i>www.sssfonline.com</i>
                </td>
                <td align="right"><img height="70" class="logos" src="<?php echo get_stylesheet_directory_uri(); ?>/fees_calc_page/sctp.png" border="0"></td>
            </tr>
            <tr>
                <td class="title" style="border-right:none;">&nbsp;Shooting Year 2019 Invoice</td>
                <td class="title" style="border-left:none;" align="right">
                    <?php echo  date(' m/d/Y '); ?>&nbsp;&nbsp;
                    &nbsp;<input type="submit" class="button_pay" onclick="submitFees(this.form);" value="Pay Now">&nbsp;
                    &nbsp;<input type="button" class="button_print" onclick="window.print();" value="Print">&nbsp;
                </td>
            </tr>
            <tr>
                <td class="column">&nbsp;Bill To</td>
                <td class="column">&nbsp;Instructions</td>
            </tr>

            <tr>
                <td valign="top">
                    &nbsp;<b><?php echo $team ?></b><br>
                    &nbsp;ATTN:&nbsp;Andrew Peercy<br>
                    &nbsp;508 ONeil Lane<br>
                    &nbsp;Franklin, TN 37067
                </td>
                <td valign="top">
                    &nbsp;<font color="red"><b>Credit Card Limits May Apply!</b></font><br>
                    &nbsp;This invoice defines annual fees dealing with membership.<br>
                    &nbsp;If you prefer payment by check, make payable to the SSSF National<br>
                    &nbsp;Office at the address listed above.
                </td>
            </tr>

            </tbody></table>
        <table border="0" width="700" cellspacing="0" cellpadding="1">
            <tbody><tr height="0">
                <td width="240"></td>
                <td width="80"></td>
                <td width="80"></td>
                <td width="80"></td>
                <td width="80"></td>
                <td width="80"></td>
                <td width="80"></td>
                <td width="80"></td>
            </tr>
            <tr>
                <td colspan="8" class="title">&nbsp;ATHLETES</td>
            </tr>
            <tr>
                <td class="column">&nbsp;Name</td>
                <td class="column">&nbsp;SCTP</td>
                <td class="column">&nbsp;ATA</td>
                <td class="sysmenusel">&nbsp;NSSA</td>
                <td class="sysmenusel">&nbsp;NSCA</td>
                <td class="column">&nbsp;JS Mag</td>
                <td class="column">&nbsp;TWF</td>
                <td class="column" align="center">Total</td>
            </tr>
            <?php
                    foreach($users as $user_id) {

                       $user = get_user_meta($user_id->ID);
              ?>
            <tr>
                <td class="row_even">&nbsp;<?php echo $user['last_name'][0].", ".$user['first_name'][0] ;?> </td>

                <td class="row_even"><input id="fpa_<?php echo $user_id->ID;?>" name="fpa_<?php echo $user_id->ID;?>" type="checkbox" onclick="toggleIndAthlete(this.form, this,'tpy_<?php echo $user_id->ID;?>', 20,'f');"></td>
                <input type="hidden" name="faid_<?php echo $user_id->ID;?>" value="<?php echo $user_id->ID;?>">

                <td class="row_even"><input id="apa_<?php echo $user_id->ID;?>" name="apa_<?php echo $user_id->ID;?>" type="checkbox" onclick="toggleIndAthlete(this.form, this, 'tpy_<?php echo $user_id->ID;?>', 12,'a');"></td>
                <input type="hidden" name="aaid_<?php echo $user_id->ID;?>" value="<?php echo $user_id->ID;?>">

                <td class="row_even"><input id="sspa_<?php echo $user_id->ID;?>" name="sspa_<?php echo $user_id->ID;?>" type="checkbox" onclick="toggleNSAAthlete(this.form, this,'tpy_<?php echo $user_id->ID;?>', 10,'ss', this.form.scpa_<?php echo $user_id->ID;?>);"></td>
                <input type="hidden" name="ssaid_<?php echo $user_id->ID;?>" value="<?php echo $user_id->ID;?>">

                <td class="row_even"><input id="scpa_<?php echo $user_id->ID;?>" name="scpa_<?php echo $user_id->ID;?>" type="checkbox" onclick="toggleNSAAthlete(this.form, this,'tpy_<?php echo $user_id->ID;?>', 10,'sc', this.form.sspa_<?php echo $user_id->ID;?>);"></td>
                <input type="hidden" name="scaid_<?php echo $user_id->ID;?>" value="<?php echo $user_id->ID;?>">

                <td class="row_even"><input id="jpa_<?php echo $user_id->ID;?>" name="jpa_<?php echo $user_id->ID;?>" type="checkbox" onclick="toggleIndAthlete(this.form, this,'tpy_<?php echo $user_id->ID;?>', 10,'j');"></td>
                <input type="hidden" name="jaid_<?php echo $user_id->ID;?>" value="<?php echo $user_id->ID;?>">

                <td class="row_even"><input id="twf_<?php echo $user_id->ID;?>" name="twf_<?php echo $user_id->ID;?>" type="checkbox" onclick="toggleIndAthlete(this.form, this,'tpy_<?php echo $user_id->ID;?>', 50,'tw');"></td>
                <input type="hidden" name="twfaid_<?php echo $user_id->ID;?>" value="<?php echo $user_id->ID;?>">

                <td class="row_even" align="right"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:70;" id="tpy_<?php echo $user_id->ID;?>" name="tpy_<?php echo $user_id->ID;?>" value="$0.00">&nbsp;</td>
            </tr>
             <?php
                          }
             ?>
            <input type="hidden" name="fcnt" value="14">
            <input type="hidden" name="acnt" value="14">
            <input type="hidden" name="jcnt" value="14">
            <input type="hidden" name="sscnt" value="14">
            <input type="hidden" name="sccnt" value="14">
            </tbody></table>
        <?php 
		if( is_user_logged_in() ) {
				$user = wp_get_current_user();
				$role = ( array ) $user->roles;
		
			  
			  
			  if(in_array('admins', $role)){
					$users = get_users( array( 'fields' => array( 'ID' ),'role' => 'coache', ) );
			  }elseif(in_array('coache', $role)){
				  $team = xprofile_get_field_data( 'Team', $user->ID );  
				  $users = get_users( array( 'fields' => array( 'ID' ),'role' => 'coache', ) );
				  foreach ($users as $us){
					 $team_athlete= xprofile_get_field_data( 'Team', $us->ID ); 
					 if ($team_athlete == $team ){
						 
						 $users_coaches[] = $us;
					 }
					  
				  }
				$users=$users_coaches;
				  
				
			  }
			 			 
			}
		
         ?>
        <table border="0" width="700" cellspacing="0" cellpadding="1">
            <tbody><tr height="0">
                <td width="240"></td>
                <td width="80"></td>
                <td width="80"></td>
                <td width="80"></td>
                <td width="80"></td>
                <td width="80"></td>
                <td width="80"></td>
            </tr>
            <tr>
                <td colspan="8" class="title">&nbsp;COACHES</td>
            </tr>
            <tr>
                <td class="column">&nbsp;Name</td>
                <td class="column">&nbsp;SCTP</td>
                <td class="column">&nbsp;ATA</td>
                <td class="sysmenusel">&nbsp;NSSA</td>
                <td class="sysmenusel">&nbsp;NSCA</td>
                <td class="column">&nbsp;TWF</td>
                <td class="column">&nbsp;</td>
                <td class="column" align="center">Total</td>
            </tr>

            <?php
			
			
            foreach($users as $user_id) {

                $user = get_user_meta($user_id->ID);
				
				  $fname = xprofile_get_field_data( 'FirstName', $user_id->ID ); 
				  $lname = xprofile_get_field_data( 'LastName', $user_id->ID ); 
				  
				  if ($fname)  $user['first_name'][0] = $fname;
					 if ($lname)  $user['last_name'][0] = $lname;
                ?>

            <tr>
                <td class="row_even">&nbsp;<?php echo $user['last_name'][0].", ".$user['first_name'][0] ;?></td>

                <td class="row_even"><input id="pv_<?php echo $user_id->ID;?>" name="pv_<?php echo $user_id->ID;?>" type="checkbox" onclick="toggleIndVolunteer(this.form, this,'pvy_<?php echo $user_id->ID;?>', 30,'v');"></td>
                <input type="hidden" name="vaid_<?php echo $user_id->ID;?>" value="<?php echo $user_id->ID;?>">

                <td class="row_even"><input id="pva_1" name="pva_<?php echo $user_id->ID;?>" type="checkbox" onclick="toggleIndVolunteer(this.form, this,'pvy_<?php echo $user_id->ID;?>', 20,'va');"></td>
                <input type="hidden" name="vaida_<?php echo $user_id->ID;?>" value="<?php echo $user_id->ID;?>">

                <td class="row_even"><input id="sspv_<?php echo $user_id->ID;?>" name="sspv_<?php echo $user_id->ID;?>" type="checkbox" onclick="toggleNSAPosition(this.form, this,'pvy_<?php echo $user_id->ID;?>', 30,'ss', this.form.scpv_<?php echo $user_id->ID;?>);"></td>
                <input type="hidden" name="ssvid_<?php echo $user_id->ID;?>" value="<?php echo $user_id->ID;?>">

                <td class="row_even"><input id="scpv_<?php echo $user_id->ID;?>" name="scpv_<?php echo $user_id->ID;?>" type="checkbox" onclick="toggleNSAPosition(this.form, this, 'pvy_<?php echo $user_id->ID;?>', 30, 'sc', this.form.sspv_<?php echo $user_id->ID;?>);"></td>
                <input type="hidden" name="scvid_<?php echo $user_id->ID;?>" value="<?php echo $user_id->ID;?>">

                <td class="row_even"><input id="twf_<?php echo $user_id->ID;?>" name="twf_<?php echo $user_id->ID;?>" type="checkbox" onclick="toggleIndVolunteer(this.form, this,'pvy_<?php echo $user_id->ID;?>', 50,'tw');"></td>
                <input type="hidden" name="twfaid_<?php echo $user_id->ID;?>" value="<?php echo $user_id->ID;?>">

                <td class="row_even">&nbsp;</td>
                <td class="row_even" align="right">
                    <input readonly="" style="border:0; text-align:right; background-color:transparent; width:70;" id="pvy_<?php echo $user_id->ID;?>" name="pvy_<?php echo $user_id->ID;?>" value="$0.00">&nbsp;</td>
            </tr>
            <?php } ?>

            <input type="hidden" name="vcnt" value="3">
            <input type="hidden" name="vacnt" value="3">
            <input type="hidden" name="vscnt" value="3">
            <input type="hidden" name="vccnt" value="3">
            </tbody></table>
        <table border="0" width="700" cellspacing="0" cellpadding="1">
            <tbody><tr height="0">
                <td width="50"></td>
                <td width="570"></td>
                <td width="80"></td>
            </tr>
            <tr>
                <td colspan="3" class="title">&nbsp;TOTAL PAYABLES</td>
            </tr>
            <tr>
                <td class="column" align="center">Qty.</td>
                <td class="column">&nbsp;Type</td>
                <td class="column" align="right">Sub-Totals&nbsp;</td>
            </tr>
            <tr>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:35;" id="ta" name="ta" value="0"></td>
                <td class="row_even">&nbsp;Annual Athlete SCTP Fee Payment ($20.00 / Athlete)</td>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:75;" id="tap" name="tap" value="$0.00"></td>
            </tr>
            <tr>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:35;" id="taa" name="taa" value="0"></td>
                <td class="row_even">&nbsp;Annual Athlete ATA Membership ($12.00 / ATA Membership)</td>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:75;" id="taap" name="taap" value="$0.00"></td>
            </tr>
            <tr>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:35;" id="tass" name="tass" value="0"></td>
                <td class="row_even">&nbsp;Annual Athlete NSSA Membership ($10.00 / NSSA Membership)</td>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:75;" id="tassp" name="tassp" value="$0.00"></td>
            </tr>
            <tr>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:35;" id="tasc" name="tasc" value="0"></td>
                <td class="row_even">&nbsp;Annual Athlete NSCA Membership ($10.00 / NSCA Membership)</td>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:75;" id="tascp" name="tascp" value="$0.00"></td>
            </tr>
            <tr>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:35;" id="taj" name="taj" value="0"></td>
                <td class="row_even">&nbsp;Annual Junior Shooter Subscriptions ($10.00 / Subscription)</td>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:75;" id="tajp" name="tajp" value="$0.00"></td>
            </tr>
            <tr>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:35;" id="tv" name="tv" value="0"></td>
                <td class="row_even">&nbsp;Annual Volunteer SCTP Fee Payment ($30.00 / Volunteer)</td>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:75;" id="tvp" name="tvp" value="$0.00"></td>
            </tr>
            <tr>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:35;" id="tva" name="tva" value="0"></td>
                <td class="row_even">&nbsp;Annual Volunteer ATA Membership ($20.00 / ATA Coach Membership)</td>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:75;" id="tvap" name="tvap" value="$0.00"></td>
            </tr>
            <tr>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:35;" id="tvss" name="tvss" value="0"></td>
                <td class="row_even">&nbsp;Annual Volunteer NSSA Membership ($30.00 / NSSA Membership)</td>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:75;" id="tvssp" name="tvssp" value="$0.00"></td>
            </tr>
            <tr>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:35;" id="tvsc" name="tvsc" value="0"></td>
                <td class="row_even">&nbsp;Annual Volunteer NSCA Membership ($30.00 / NSCA Membership)</td>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:75;" id="tvscp" name="tvscp" value="$0.00"></td>
            </tr>
            <tr>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:35;" id="twftot" name="twftot" value="0"></td>
                <td class="row_even">&nbsp;Annual TWF Membership ($50.00 / TWF Membership)</td>
                <td class="row_even"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:75;" id="twftotp" name="twftotp" value="$0.00"></td>
            </tr>
            <tr>
                <td colspan="2" class="column">&nbsp;TOTAL DUE</td>
                <td class="column"><input readonly="" style="border:0; text-align:right; background-color:transparent; width:75;" id="tdue" name="tdue" value="$0.00"></td>
            </tr>
            </tbody></table>
    </form>




    <?php     return ob_get_clean();
}



function add_script(){





}







