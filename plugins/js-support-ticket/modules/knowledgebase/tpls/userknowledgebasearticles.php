<?php
if (jssupportticket::$_config['offline'] == 2) {
    ?>
    <?php JSSTmessage::getMessage(); ?>
    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
    <h1 class="js-ticket-heading"><?php echo __('Knowledge Base', 'js-support-ticket') ?></h1>
    <div class="js-col-md-12 js-ticket-head margintopbottom" id="js-ticket-categoryimage">
        <?php
        if (isset(jssupportticket::$_data[0]['categoryname']->logo) AND jssupportticket::$_data[0]['categoryname']->logo != '') {
            $datadirectory = jssupportticket::$_config['data_directory'];
            $maindir = wp_upload_dir();
            $path = $maindir['baseurl'];                                

            $path = $path .'/' . $datadirectory;
            $path .= "/knowledgebasedata/categories/category_" . jssupportticket::$_data[0]['categoryname']->id . "/" . jssupportticket::$_data[0]['categoryname']->logo;
        } else {
            $path = jssupportticket::$_pluginpath . 'includes/images/kb_default_icon.png';
        }
        ?>
        <div class="js-ticket-head-category-image">
            <img width="70px" height="70px" src="<?php echo $path; ?>"> 
        </div>
        <span class="js-ticket-head-text">
        <?php 
            $name = isset(jssupportticket::$_data[0]['categoryname']->name) ? jssupportticket::$_data[0]['categoryname']->name : '';
        ?>
            <?php echo __($name, 'js-support-ticket'); ?>
        </span>
    </div>
    <div class="js-col-md-12">
        <div class="js-col-md-12 js-ticket-body">
            <?php
            $counter = 1;
            if (jssupportticket::$_data[0]['categories']) {
                foreach (jssupportticket::$_data[0]['categories'] as $category) {
                    ?>
                    <div class="js-col-md-4 js-ticket-body-data">	
                        <a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=knowledgebase&jstlay=userknowledgebasearticles&jssupportticketid=" . $category->id); ?>">
                            <div class="js-col-md-12 js-ticket-body-border">
                                <span class="js-ticket-body-text">
            <?php echo $counter . ".  " . $category->name; ?>
                                </span>
                                <div class="js-ticket-body-icon">
                                    <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/arrowicon.png" />
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                    $counter ++;
                }
            }
            ?>
        </div>		
    </div>
    <div class="js-col-md-12 js-ticket-head">
        <span class="js-ticket-head-text">
    <?php echo __('Knowledge Base', 'js-support-ticket'); ?>
        </span>
    </div>
    <div class="js-col-md-12">			
        <?php
        $per_id = null;
        if (jssupportticket::$_data[0]['articles']) {
            foreach (jssupportticket::$_data[0]['articles'] as $article) {
                $canshow = false;
                if($per_id == null){
                    $per_id = $article->articleid;
                    $canshow = true;
                }
                if($per_id != $article->articleid){
                    $per_id = $article->articleid;
                    $canshow = true;
                }
                if($canshow){
                ?>
                <div class="js-col-md-12 js-ticket-body-row">
                    <div class="js-col-md-10 js-ticket-body-padding">
                        <span class="js-ticket-body-row-text">
                            <a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=knowledgebase&jstlay=articledetails&jssupportticketid=" . $article->articleid); ?>"> <?php echo $article->subject; ?></a>
                        </span>
                    </div>
                </div>
                <?php
                }
            }
            if (jssupportticket::$_data[1]) {
                echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
            }
        } else {
            JSSTlayout::getNoRecordFound();
        }
        ?>
    </div>
    <?php
} else {
    JSSTlayout::getSystemOffline();
} ?>