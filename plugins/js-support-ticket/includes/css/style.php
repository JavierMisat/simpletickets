<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
$color1 = "#343538";
$color2 = "#428bca";
$color3 = "#fdfdfd";
$color4 = "#373435";
$color5 = "#b8b8b8";
$color6 = "#e7e7e7";
$color7 = "#ffffff";
$color8 = "#2DA1CB";
$color9 = "#000000";

$result = "
	form#loginform-custom{border:1px solid $color5;}
	form#loginform-custom p.login-username{}
	form#loginform-custom p.login-password{}
	form#loginform-custom p.login-submit{border-top:1px solid $color5;}

	h1.js-ticket-heading{border-bottom:2px solid $color2;}
	h1.js-ticket-heading a{background-color: $color6;border: 1px solid $color5;color: $color4;}
	h1.js-ticket-heading a:hover{background-color: $color2;color: $color7;}
	h1.js-ticket-sub-heading{background:$color1;color:$color7;}
	div.js-ticket-body-data-elipses a{color:$color2;text-decoration:none;}
	form.js-ticket-form{background: $color3;border:1px solid $color5;}
	div.js-ticket-cp-wrapper a.js-ticket-vl-left{background: $color3;border:1px solid $color5;}
	div.js-ticket-cp-wrapper a.js-ticket-vl-right{background: $color3;border:1px solid $color5;}
	div.js-ticket-cp-wrapper a.js-ticket-vl-left:hover{background: $color2; color: $color7;}
	div.js-ticket-cp-wrapper a.js-ticket-vl-right:hover{background: $color2; color: $color7;}
	div.js-ticket-cp-wrapper a.js-ticket-vl-right:hover h3.js-ticket-h3{color:$color7;}
	div.js-ticket-cp-wrapper a.js-ticket-vl-left:hover h3.js-ticket-h3{color:$color7;}
	div.js-form-button{border-top: 2px solid $color5;}
	div.js-form-button input.button:hover{background: $color2; color: $color7;}
	div.js-form-button input.tk_dft_btn:hover{background: $color2; color: $color7;}
	div.js-form-wrapper div.js-form-border{border:1px solid $color5;}
	div.js-form-wrapper div.js-form-value-signature{border:1px solid $color5;}
	div.js-ticket-head{background: $color1;}
	div.js-ticket-head span{color: $color7;}
	div.js-ticket-body{border: 1px solid $color5; background: $color3;}
	div.js-ticket-body-data div.js-ticket-body-border {border-bottom: 1px solid $color5;}
	div.js-ticket-body-border div.js-ticket-body-icon{background:$color2;}
	div.js-ticket-body-row{border: 1px solid $color5;}
	div.js-ticket-body-row-button{border-left: 1px solid $color5;}
	div.js-ticket-body-row-button input {background:$color6;}
	div.js-ticket-body-row-button input.button:hover{background: $color2;color:$color7;}
	div.js-form-wrapper div.js-form-value-box{border:1px solid $color5;}
	div.js-form-head{background: #343538;color: $color7;}
	div.js-form-data-column {border: 1px solid $color5;}
	div.js-form-head{background-color: $color1;color:$color7;}
	form.js-filter-form{background: $color3;border:1px solid $color5;}
	div.js-filter-wrapper div.js-filter-button{border-top: 1px solid $color5;}
	div.js-filter-wrapper div.js-filter-button input.button:hover{background: $color2; color:$color7;}
	div.js-filter-wrapper div.js-filter-button input.button{text-shadow: none;}
	div.js-filter-wrapper div.js-filter-button input.js-ticket-filter-button{text-shadow: none;}
	div.js-filter-wrapper div.js-filter-button input.js-ticket-filter-button:hover{background: $color2; color:$color7;}
	div.js-filter-form-head{background: $color1;color:$color7;}
	div.js-filter-form-data{border: 1px solid $color5;background: $color3;}
	div.js-filter-form-head div{border-right: 1px solid $color3;}
	div.js-filter-form-data div{border-right: 1px solid $color5;}
	div.js-myticket-link a.js-myticket-link{color:$color4;}
	div.js-myticket-link a.js-myticket-link.active{color:$color7;background:$color2;}
	div.js-myticket-link a.js-myticket-link{border:1px solid $color5;}
	div.js-myticket-link a.js-myticket-link:hover{background: $color2;color:$color7;}
	div.js-ticket-sorting span.js-ticket-sorting-link a{background:$color1;color:$color7;}
	div.js-ticket-sorting span.js-ticket-sorting-link a.selected,
	div.js-ticket-sorting span.js-ticket-sorting-link a:hover{background: $color2;}
	div#js-ticket-border-box-kb.js-ticket-border-box-kb-jsenabled{border:1px solid $color2;background:$color3;}
	div.js-ticket-wrapper{border:1px solid $color5;background:$color3;}
	div.js-ticket-wrapper:hover{border:1px solid $color2;}
	div.js-ticket-wrapper:hover div.js-ticket-pic{border-right:1px solid $color2;}
	div.js-ticket-wrapper:hover div.js-ticket-data1{border-left:1px solid $color2;}
	div.js-ticket-wrapper:hover div.js-ticket-bottom-line{background:$color2;}
	div.js-ticket-wrapper div.js-ticket-pic{border-right:1px solid $color5;}
	div.js-ticket-wrapper div.js-ticket-data span.js-ticket-status{color:#FFFFFF;}
	div.js-ticket-wrapper div.js-ticket-data1{border-left:1px solid $color5;}
	div.js-ticket-wrapper div.js-ticket-data span.js-ticket-title{color:$color4;}
	div.js-ticket-wrapper div.js-ticket-data span.js-ticket-value{color:$color4;}
	div.js-ticket-wrapper div.js-ticket-bottom-line{background:$color2;}
	div.js-ticket-detail-wrapper{background: $color3;border:1px solid $color5;}
	div.js-ticket-detail-wrapper div.js-ticket-openclosed{background:$color6;color:$color4;border-right:1px solid $color5;}
	div.js-ticket-detail-wrapper div.js-ticket-topbar{border-bottom: 1px solid $color5;}
	div.js-ticket-detail-wrapper div.js-ticket-topbar div.js-openclosed{border-right: 1px solid $color5;}
	div.js-ticket-detail-wrapper div.js-ticket-topbar div.js-last-left{border-left: 1px solid $color5;}
	div.js-ticket-detail-wrapper div.js-ticket-moredetail div.js-ticket-data-value{border:1px solid $color5;}
	div.js-ticket-detail-wrapper div.js-border-box{border: 1px solid $color5;}
	div.js-ticket-detail-wrapper div.js-ticket-requester{color:$color2;border-bottom: 1px solid $color2;}
	div.js-ticket-thread-wrapper.colored div.js-ticket-thread-upperpart{border-bottom: 1px solid $color2;}
	div.js-ticket-thread-wrapper div.js-ticket-thread-upperpart{border-bottom: 1px solid $color2;}
	div.js-ticket-thread-wrapper.colored div.js-ticket-thread-upperpart span.js-ticket-thread-replied{color:$color2;}
	div.js-ticket-thread-wrapper.colored div.js-ticket-thread-upperpart span.js-ticket-thread-person{color:$color2;}
	div.js-ticket-thread-wrapper div.js_ticketattachment{border: 1px solid $color5;}
	span.tk_attachments_addform{border: 1px solid $color5;background:$color2;color:$color7}
	div.js-ticket-mainhead-details{border: 1px solid $color5;background: $color3;}
	div.js-ticket-head-details{border: 1px solid $color5;background: $color3;}
	div.js-ticket-details{border: 1px solid $color5;}
	div.js-ticket-border-box{border: 1px solid $color5;}
	div.js-ticket-body-row-detail{border: 1px solid $color5;}
	div.js-ticket-body-row-button-detail{border-left: 1px solid $color5;}
	div.js-ticket-body-padding-detail{padding-top: 7px;padding-bottom: 7px;}
	div.js-ticket-body-row-button-detail input {padding: 5px 15px;}
	div.js-ticket-body-row-button-detail input.button:hover{background:$color2; color:$color7;}
	div.js-ticket-head-details{border: 1px solid $color5;background: $color3;}
	div.js-ticket-head-category-image{background:#FFFFFF; border: 1px solid $color5;}
	div.tk_attachment_value_wrapperform{border: 1px solid $color5;background: $color3;}
	div.tk_attachment_value_wrapperform{border: 1px solid $color5;background:$color3;}
	div.signatureCheckbox{border:1px solid $color5;}
	div.replyFormStatus{border:1px solid $color5;}
	div.replySubmit input[type='submit']{color:$color7;background: $color6;}
	span.tk_attachment_value_text{border: 1px solid $color5;}
	div.js-filter-add-button a{background: $color6;border: 1px solid $color5;color: $color4;}
	div.js-filter-add-button a:hover{background: $color2;color: $color7;}
	div.js-filter-add-button a.active{background: $color2;color: $color7;}
	div.js_job_error_messages_wrapper div.js_job_messages_data_wrapper a.button-not-login{background: $color6; color:$color4;}
	div.js_job_error_messages_wrapper div.js_job_messages_data_wrapper a.button-not-login:hover{background: $color2; color:$color7;}
	div#userpopup{background: $color3;border: 1px solid $color5;}
	div.js-title{background: $color5;}
	div.js-value{border-bottom:1px solid $color5;background: $color3;}
	form#userpopupsearch div.search-center{}
	form#userpopupsearch div.search-center div.search-center-heading{background:$color1;color:$color7;}
	div.js-ticket-detail-wrapper a.button{background: $color6;border: 1px solid $color5;}
	div#action-div{border-top: 1px solid $color5;}
	div#action-div div.js-row{border-top: 1px solid $color5;}
	div#records{background:$color3;}
	div#records div.js-popup-row-wrapper {border-bottom: 1px solid $color5;}
	div#records div.js-popup-row-wrapper span{background:$color3;border-right: 1px solid $color5;}
	div.tablenav div.tablenav-pages{border:1px solid #f1f1fc;width:100%;}
	div.tablenav div.tablenav-pages span.page-numbers.current{background: $color2;color: $color7;padding:11px 20px;}
	div.tablenav div.tablenav-pages a.page-numbers:hover{background:$color2;color:$color7;border:1px solid $color2;}
	div.tablenav div.tablenav-pages a.page-numbers{background: #ffffff; /* Old browsers */background: -moz-linear-gradient(top,  #ffffff 0%, #f2f2f2 100%); /* FF3.6+ */background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#f2f2f2)); /* Chrome,Safari4+ */background: -webkit-linear-gradient(top,  #ffffff 0%,#f2f2f2 100%); /* Chrome10+,Safari5.1+ */background: -o-linear-gradient(top,  #ffffff 0%,#f2f2f2 100%); /* Opera 11.10+ */background: -ms-linear-gradient(top,  #ffffff 0%,#f2f2f2 100%); /* IE10+ */background: linear-gradient(to bottom,  #ffffff 0%,#f2f2f2 100%); /* W3C */filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#f2f2f2',GradientType=0 ); /* IE6-9 */color: $color4;border:1px solid $color5;}
	div#js-ticket-main-popup{background: $color3;}
	span#js-ticket-popup-title{color: $color7;background: $color1; }
	div#js-ticket-popup-head{background:$color1;}
	div.js-ticket-popup-desctiption{padding: 5px 15px; font-size: 12px;}
	div.js-ticket-popup-download-row{border: 1px solid $color5;}
	div.js-ticket-popup-row-button{background: $color3; border: 1px solid $color5;}
	div.js-ticket-popup-row-button-all{background: $color3; border: 1px solid $color5;}
	div.js-ticket-popup-row-downloadall-button{background: $color3; border: 1px solid $color5;}
	img.profile-image{background: $color6;}
	div.js-profile-rightbox{border: 1px solid $color5;}
	div#jsst-header{background:$color1;border-bottom:4px solid $color2;}
	div#jsst-header.border-thin{border-bottom:1px solid $color2;}
	div#jsst-header span.jsst-header-tab a{color:$color7;}
	div#jsst-header span.jsst-header-tab a:hover{background:$color1;color:$color2;}
	div#jsst-header span.jsst-header-tab.active a{background:$color2;color:$color7;}
	div#jsst-header-2{background:$color2;}
	div#jsst-header-2 span.jsst-header-2-tab a{color:$color7;}
	div#jsst-header-2 span.jsst-header-2-tab a:hover{color:$color2;background:#FFFFFF;}
	div#jsst-header-2 span.jsst-header-2-tab.active a{}
	.tabs ul li.ui-tabs-active, .tabs ul li.ui-state-hover {background-color: #FCFCFC; color: $color2; border-top: 3px solid $color2;}
	.tabs ul li.ui-tabs-active a, .tabs ul li.ui-state-hover a { color: $color2;}
	.tabs ul li {background-color: #DFDFDF; color: $color2; border: 1px solid #C4C4C4;}
	a.js-ticket-frontend-manu{border: 1px solid #F3F3F3 !important;}
	a.js-ticket-frontend-manu:hover{box-shadow: 0 0 7px 1px #3D5463;background-color: $color2;}
	a.js-ticket-frontend-manu div.js-ticket-frontend-manu-circle{background-color: #FFFFFF; border: 1px solid #F3F3F3;}
	a.js-ticket-frontend-manu:hover span.js-ticket-frontend-manu-text{color: $color7;}
	a.js-ticket-frontend-manu:hover div.js-ticket-frontend-manu-circle{box-shadow: 0 0 7px 1px $color2;}
	div#jsst_breadcrumbs_parent div.home{background-color:$color2;}
	div#jsst_breadcrumbs_parent div.links a.links{color:$color2;}
	a.js-ticket-popup-row-button-a{background-color: $color6;}
	a.js-ticket-popup-row-button-a:hover{background-color: $color2;color:$color7;}
	div.js-form-title-position-border{border: 1px solid $color5;}
	/******** Widgets ***********/
	div#jsst-widget-myticket-wrapper{background: $color3;border:1px solid $color5;}
	div#jsst-widget-myticket-wrapper div.jsst-widget-myticket-topbar{border-bottom: 1px solid $color5;}
	div#jsst-widget-myticket-wrapper div.jsst-widget-myticket-topbar span.jsst-widget-myticket-subject a{color:$color2;}
	div#jsst-widget-myticket-wrapper div.jsst-widget-myticket-topbar span.jsst-widget-myticket-status{color:#FFFFFF;}
	div#jsst-widget-myticket-wrapper div.jsst-widget-myticket-bottombar span.jsst-widget-myticket-priority{color: #FFFFFF;}
	div#jsst-widget-myticket-wrapper div.jsst-widget-myticket-bottombar span.jsst-widget-myticket-from span.widget-from{color:$color4;}
	div#jsst-widget-myticket-wrapper div.jsst-widget-myticket-bottombar span.jsst-widget-myticket-from span.widget-fromname{color:$color4;}
	div#jsst-widget-mailnotification-wrapper{background:$color3;border:1px solid $color5;}
	div#jsst-widget-mailnotification-wrapper img{}
	div#jsst-widget-mailnotification-wrapper span.jsst-widget-mailnotification-upper{color:$color4;}
	div#jsst-widget-mailnotification-wrapper span.jsst-widget-mailnotification-upper span.jsst-widget-mailnotification-created{color:$color4;}	
	div#jsst-widget-mailnotification-wrapper span.jsst-widget-mailnotification-upper span.jsst-widget-mailnotification-new{color:#0752AD;}	
	div#jsst-widget-mailnotification-wrapper span.jsst-widget-mailnotification-upper span.jsst-widget-mailnotification-replied{color:#ED6B6D;}	
";
if ( is_rtl() ) {
    $result .= "div.js-ticket-wrapper:hover div.js-ticket-pic{border-right:0px;border-left:1px solid $color2;}"
            . "div.js-ticket-wrapper:hover div.js-ticket-data1{border-left:0px;border-right:1px solid $color2;}"
            . "div.js-ticket-wrapper div.js-ticket-pic{border:0px;border-left:1px solid $color5;float:right;}"
            . "div.js-ticket-wrapper div.js-ticket-data1{border-left:0px;border-right:1px solid $color5;}"
            . "div.js-ticket-detail-wrapper div.js-ticket-topbar div.js-openclosed{float:right;border:0px;border-left: 1px solid $color5;}"
            . "div.js-ticket-detail-wrapper div.js-ticket-openclosed{border-right:0px;border-left:1px solid $color5;}"
            . "div.js-ticket-detail-wrapper div.js-ticket-topbar div.js-last-left{border-left:0px;border-right: 1px solid $color5;}"
            . "div.js-filter-form-head div{border-right:0px; border-left: 1px solid $color3;}
               div.js-filter-form-data div{border-right:0px; border-left: 1px solid $color5;}"
            . "	div.js-ticket-body-row-button{border-left:0px;border-right: 1px solid $color5;}";
}
wp_add_inline_style('jsticket-style', $result);
?>