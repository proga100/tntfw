<?php
$var1=$athletes_male_entries_count;
$var2=$athletes_female_entries_count;

for($x=$var2;$x>1;$x--) {
  if(($var1%$x)==0 && ($var2 % $x)==0) {
    $var1 = $var1/$x;
    $var2 = $var2/$x;
    $var1 = $var1/$var2;
    $var1 = round($var1,1);
    $var2 = 1;

  }
  $fm_ratio1 = "$var1:$var2";
}

?>

     <div class="components">
         <div  class="fl_left">
                     <div  class=" boxes boxes_light_blue" >


                                <div  class="boxes_title " >

                                    <div class="title title_1" >
                                        <label style="height: 30px; line-height: 30px;">Athletes</label>

                                         </div>
                                </div>
                                 <div class="box_text" >
                                    <div class="box_text_left"> Forms Received:</div>  <div class="box_text_rigth"><?php echo $athletes_entries_count; ?></div>
                                    <div class="clear"></div>
                                      <div class="box_text_left"> Payment Received:</div>  <div class="box_text_rigth"> <?php echo $payments_athletes;  ?></div>
                                      <div class="clear"></div>
                                      <div class="box_text_left"> Male:</div>  <div class="box_text_rigth"><?php echo $athletes_male_entries_count; ?></div>
                                      <div class="clear"></div>
                                       <div class="box_text_left"> Female:</div>  <div class="box_text_rigth"><?php echo $athletes_female_entries_count; ?></div>
                                       <div class="clear"></div>
                                       <div class="box_text_left"> M:F Ratio:</div>  <div class="box_text_rigth"> <?php echo $fm_ratio1; ?></div>
                                       <div class="clear"></div>

                                 </div>
                                  <div  class="boxes_title " >

                                         <div class="title title_1 boxes_title_bottom" >
                                             <label style="height: 30px; line-height: 30px;"></label>

                                         </div>
                                     </div>


                    </div>
         </div>
           <div class="fl_left">
              <div  class=" boxes boxes_orange" >


                        <div  class="boxes_title" >

                            <div class="title title_1" >
                                <label style="height: 30px; line-height: 30px;">Reports</label>

                                 </div>
                        </div>
                         <div class="box_text" >
                    <div class="box_text_left box_report">
                        <div style="width: 24px; height: 24px;  border: none; position:">
                         <div class="check_icon"></div>
                         </div>
                    </div>  <div class="box_text_rigth box_text_rigth_report"> Payment by Teams</div>
                            <div class="clear"></div>
                              <div class="box_text_left box_report">
                                  <div style="width: 24px; height: 24px;  border: none; position:">
                                      <div class="check_icon"></div>
                                  </div>
                              </div>  <div class="box_text_rigth box_text_rigth_report">Athletes with Missing Paperwork</div>
                              <div class="clear"></div>
                              <div class="box_text_left box_report">
                                  <div style="width: 24px; height: 24px;  border: none; position:">
                                      <div class="check_icon"></div>
                                  </div>
                              </div>  <div class="box_text_rigth box_text_rigth_report"> Regional Athlete Status</div>
                              <div class="clear"></div>
                               <div class="box_text_left box_report">
                                   <div style="width: 24px; height: 24px;  border: none; position:">
                                       <div class="check_icon"></div>
                                   </div>
                               </div>
                             <div class="box_text_rigth box_text_rigth_report"> Upcoming Events  </div>
                               <div class="clear"></div>

                         </div>
                          <div  class="boxes_title  " >

                                 <div class="title title_1 boxes_title_bottom" >
                                     <label style="height: 30px; line-height: 30px;"></label>

                                 </div>
                             </div>

                        </div>
             </div>

    </div>



<?php

?>