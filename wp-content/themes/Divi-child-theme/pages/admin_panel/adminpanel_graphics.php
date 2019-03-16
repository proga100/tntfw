<?php

?>




    <div class="components adminpanel_graphics">

            <div class=" boxes boxes_light_orange">


                <div class="boxes_title ">

                    <div class="title title_1">
                        <label style="height: 30px; line-height: 30px;">Payment</label>

                    </div>
                </div>
                <div class="box_text">

                    <div class="dash_full">
                        <div class="dash_left">


                            <?php


							echo do_shortcode('[progressbar id="1" dimen="100" text="'.$percent.'%" info="" width="10" fontsize="25" percent="'.$percent.'" fgcolor="blue" bgcolor="red" fillcolor="#facf4e" type="full" border="inline"]'); ?>
                            </div>
                        <div class="dash_left_2">
                            <h1>TWF</h1>
                            <div class="dash_text">$ <?php echo $payments ?></div>
                        </div>
                        <div class="dash_left">
                            <div class="pieContainer">
                                <div class="pieBackground"></div>
                                <div id="pieSlice1" class="hold"><div class="pie"></div></div>

                            </div>
                            <span class="pie_title">Green Paid   Blue Pending</span>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="dash_full dash_bottom">
                        <div class="dash_left">

                            <label style="white-space: nowrap; text-align: left; font-size: 20px; font-weight: 700; font-style: normal; text-decoration: none; font-family: &quot;Segoe UI&quot;; color: rgb(255, 0, 0);">Total <?php echo $percent ?>% of Payments</label>

                        </div>
                        <div class="dash_left"><label style="white-space: nowrap; text-align: left; font-size: 20px; font-weight: 700; font-style: normal; text-decoration: none; font-family: &quot;Segoe UI&quot;; color: rgb(255, 0, 0);">Total Income 2019</label></div>
                        <div class="dash_left">
                            <label style="white-space: nowrap; text-align: left; font-size: 20px; font-weight: 700; font-style: normal; text-decoration: none; font-family: &quot;Segoe UI&quot;; color: rgb(255, 0, 0);">Paid vs, Pending Athletes</label></div>
                    </div>


                </div>
                <div class="boxes_title ">

                    <div class="title title_1 boxes_title_bottom">
                        <label style="height: 30px; line-height: 30px;"></label>

                    </div>
                </div>


            </div>



    </div>



<div class="clear"></div>

<?php

?>
