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

    <div class="js-col-md-12 js-ticket-head" style="background:<?php echo jssupportticket::$_data['sanitized_args']['background_color']; ?>">
        <span class="js-ticket-head-text" style="color:<?php echo jssupportticket::$_data['sanitized_args']['text_color']; ?>">
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
                // echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
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