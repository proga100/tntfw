<div class="wrap moove-activity-plugin-wrap" id="uat-settings-cnt">
    <h1><?php _e('Global content activity tracking', 'user-activity-tracking-and-log'); ?></h1>
    <?php
    if (isset($_GET['tab'])) {
        $active_tab = $_GET['tab'];
    } else {
        $active_tab = "post_type_activity";
    } // end if
    ?>
    <br />
    <div class="uat-tab-section-cnt">
        <h2 class="nav-tab-wrapper">

            <?php do_action('moove-activity-tab-extensions', $active_tab); ?>

            <a href="?page=moove-activity&tab=plugin_documentation" class="nav-tab <?php echo $active_tab == 'plugin_documentation' ? 'nav-tab-active' : ''; ?>">
                <?php _e('Documentation', 'user-activity-tracking-and-log'); ?>
            </a>
            
        </h2>
        <div class="moove-form-container <?php echo $active_tab; ?>">
            <a href="http://mooveagency.com" target="blank" title="WordPress agency"><span class="moove-logo"></span></a>

            <?php
            $content = array(
                'tab' => $active_tab,
                'data' => $data
            );
            do_action('moove-activity-tab-content', $content);
            ?>

        </div>
        <!-- moove-form-container -->

    </div>
    <!--  .uat-tab-section-cnt -->

    <?php 
        $view_cnt = new Moove_Activity_View();
        echo $view_cnt->load( 'moove.admin.settings.plugin_boxes', array() );
    ?>
</div>
<!-- wrap -->