<?php
if (jssupportticket::$_config['offline'] == 2) {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $("div#js-ticket-border-box-kb").mouseover(function () {
                $(this).find("div#js-ticket-subcat-data").show();
                $(this).addClass("js-ticket-border-box-kb-jsenabled");
                /*  				$(this).css('box-shadow','0 0 12px 1px #909090');
                 $(this).css('border','1px solid #418AC9');
                 $(this).css('color','#418AC9');
                 */  			});
            $("div#js-ticket-border-box-kb").mouseout(function () {
                $(this).find("div#js-ticket-subcat-data").hide();
                $(this).removeClass("js-ticket-border-box-kb-jsenabled");
                /*  				$(this).css('box-shadow','none');
                 $(this).css('border','1px solid #dadada');
                 $(this).css('color','#666666');
                 */  			});
        });
    </script>
    <script type="text/javascript">
        function resetFrom() {
            document.getElementById('jsst-search').value = '';
            return true;
        }
        function addSpaces() {
            document.getElementById('jsst-search').value = fillSpaces(document.getElementById('jsst-search').value);
            return true;
        }
    </script>

    <?php JSSTmessage::getMessage(); ?>
    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

    <h1 class="js-ticket-heading"><?php echo __('Knowledge Base', 'js-support-ticket') ?></h1>
    <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="GET" action="">
        <?php echo "<input type='hidden' name='page_id' value='" . jssupportticket::getPageId() . "'/>"; ?>
        <?php echo "<input type='hidden' name='jstmod' value='knowledgebase'/>"; ?>
        <?php echo "<input type='hidden' name='jstlay' value='userknowledgebase'/>"; ?>
        <div class="row js-filter-wrapper">
            <div class="js-col-md-12">
                <div class="js-col-md-12 js-filter-title">
                    <?php echo __('Search Knowledge Base', 'js-support-ticket'); ?>
                </div>
                <div class="js-col-md-12 js-filter-value">
                    <?php echo JSSTformfield::text('jsst-search', jssupportticket::parseSpaces(JSSTrequest::getVar('jsst-search')), array('placeholder' => __('Search', 'js-support-ticket'))); ?>
                </div>
            </div>
            <div class="js-col-md-12 js-filter-wrapper">
                <div class="js-filter-button">
                    <?php echo JSSTformfield::submitbutton('jsst-go', __('Search', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'return addSpaces();')); ?>
                    <?php echo JSSTformfield::submitbutton('jsst-reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'return resetFrom();')); ?>
                </div>
            </div>
        </div>
    </form>
    <?php
    if (jssupportticket::$_data[0]['categories']) {
        ?>
        <div class="js-col-md-12 js-ticket-head">
            <span class="js-ticket-head-text">
                <?php echo __('Categories', 'js-support-ticket'); ?>
            </span>
        </div>
        <div class="js-col-md-12 js-nullpadding">
            <?php foreach (jssupportticket::$_data[0]['categories'] as $category) { ?>
                <div class="js-col-md-4">
                    <div id="js-ticket-border-box-kb" class="js-col-md-12 js-ticket-border-box-kb js-ticket-border-box js-nullpadding">
                        <div class="js-col-md-4 js-col-xs-4 js-ticket-logo js-nullpadding">
                            <?php
                            if ($category->logo != '') {
                                $datadirectory = jssupportticket::$_config['data_directory'];
                                $maindir = wp_upload_dir();
                                $path = $maindir['baseurl'];                                
                                $path = $path.'/' . $datadirectory;
                                $path .= "/knowledgebasedata/categories/category_" . $category->id . "/" . $category->logo;
                            } else {
                                $path = jssupportticket::$_pluginpath . 'includes/images/kb_default_icon.png';
                            }
                            ?>
                            <img width="60px;" height="60px" src="<?php echo $path; ?>">
                        </div>
                        <div class="js-col-md-8 js-col-xs-8 js-rightnullpadding">
                            <div class="js-ticket-categoryheadlink js-ticket-body-data-elipses"><a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=knowledgebase&jstlay=userknowledgebasearticles&jssupportticketid=" . $category->id); ?>"><?php echo $category->name; ?> </a> </div>
            <?php if (!empty($category->subcategory)) { ?>
                                <div id="js-ticket-subcat-data" class="js-ticket-subcat-data" style="display:none;">
                                <?php
                                $counter = 1;
                                foreach ($category->subcategory as $subcategory) {
                                    ?>

                                        <div class="js-col-md-6 js-ticket-body-data-kb-text js-ticket-body-data-elipses"><a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=knowledgebase&jstlay=userknowledgebasearticles&jssupportticketid=" . $category->id); ?>"> <?php echo $counter . '. ' . $subcategory->name; ?>   </a> </div>

                                        <?php
                                        $counter ++;
                                    }
                                    ?>
                                </div>		
                            <?php } ?>
                        </div>
                    </div>				
                </div>
                <?php
            } ?>
    </div>
    <?php
        }
        ?>

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
