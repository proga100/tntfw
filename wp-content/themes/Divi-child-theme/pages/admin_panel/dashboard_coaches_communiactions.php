<?php

?>


<?php

?>

    <div class="components">
        <div  class="fl_left">
            <div  class=" boxes boxes_green" >


                <div  class="boxes_title " >

                    <div class="title title_1" >
                        <label style="height: 30px; line-height: 30px;">Coaches</label>

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
        <div class="fl_left">
            <div  class=" boxes boxes_blue" >


                <div  class="boxes_title" >

                    <div class="title title_1" >
                        <label style="height: 30px; line-height: 30px;">Communications</label>

                    </div>
                </div>
                <form name="box_coach_form" id="box_coach_form">
                <div class="box_text" >
                    <div class="box_text_left box_coach">
                        <div style=" height: 24px;  border: none; position:">
                            <div class="">Email a Coach</div>
                        </div>
                    </div>
                    <div class="box_text_rigth box_rigth_coach">
                    <select name="email_coach" id="email_coach" class="email_coach">
                        <option value="1">Bobby</option>
                        <option value="2">Rusty</option>
                    </select>

                    </div>
                    <div class="clear"></div>
                    <div class="box_text_left box_coach">
                        <div style=" height: 24px;  border: none; position:">
                            <div class="">Subject</div>
                        </div>
                    </div>  <div class="box_text_rigth box_rigth_coach">
                        <input type="text" name="email_coach_subject" id="email_coach_subject" > </div>
                    <div class="clear"></div>
                    <div class="box_text_area"><textarea name="email_coach_message" id="email_coach_message" placeholder="Enter Message Here" ></textarea></div>
                    <div class="clear"></div>


                </div>

                    <input type="submit" value="submit"/>
                    </form>
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

