<?php

?>


    <div class="components coaches_statistics">
	
	     <div  class="fl_left">
            <div  class=" boxes boxes_green" >


                <div  class="boxes_title " >

                    <div class="title title_1" >
                        <label style="height: 30px; line-height: 30px;">Total Payments</label>

                    </div>
                </div>
                <div class="box_text" >

					 <?php echo do_shortcode('[progressbar id="1" dimen="100" text="'.$percent.'%" info="" width="10" fontsize="25" percent="'.$percent.'" fgcolor="blue" bgcolor="red" fillcolor="#facf4e" type="full" border="inline"]'); ?>
                            
                    
                    <div class="clear"></div>


                </div>
                <div  class="boxes_title " >

                    <div class="title title_1 boxes_title_bottom" >
                        <label style="height: 30px; line-height: 30px;"></label>

                    </div>
                </div>


            </div>
        </div>
        <div  class="fl_left">
            <div  class=" boxes boxes_green" >


                <div  class="boxes_title " >

                    <div class="title title_1" >
                        <label style="height: 30px; line-height: 30px;">Coaches Status</label>

                    </div>
                </div>
                <div class="box_text" >


                    <div class="box_text_left"> Background Check Done:</div>  <div class="box_text_rigth"> <?php echo $backgr; ?></div>
                    <div class="clear"></div>
                    <div class="box_text_left">  Forms Received:</div>  <div class="box_text_rigth"> <?php echo $coaches_entries_count; ?></div>
                    <div class="clear"></div>
                    <div class="box_text_left">  Payment Received:</div>  <div class="box_text_rigth">  <?php echo $payments_coaches; ?></div>
                    <div class="clear"></div>


                </div>
                <div  class="boxes_title " >

                    <div class="title title_1 boxes_title_bottom" >
                        <label style="height: 30px; line-height: 30px;"></label>

                    </div>
                </div>


            </div>
        </div>
		
		
		<div  class="fl_left">
                     <div  class=" boxes boxes" >


                                <div  class="boxes_title " >

                                    <div class="title title_1" >
                                        <label style="height: 30px; line-height: 30px;">Athletes</label>

                                         </div>
                                </div>
                                 <div class="box_text" >
                                    <div class="box_text_left"> Forms Received:</div>  <div class="box_text_rigth"><?php echo $athletes_entries_count; ?></div>
                                    <div class="clear"></div>
                                     

                                 </div>
                                  <div  class="boxes_title " >

                                         <div class="title title_1 boxes_title_bottom" >
                                             <label style="height: 30px; line-height: 30px;"></label>

                                         </div>
                                     </div>


                    </div>
         </div>
          
    </div>



<?php

?>

