<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

$isUserStaff = JSSTincluder::getJSModel('staff')->isUserStaff();
$div = '';
$module = JSSTrequest::getVar('jstmod', null, 'jssupportticket');
$layout = JSSTrequest::getVar('jstlay', null);
if ($layout == 'printticket' )
    return false;
if (isset(jssupportticket::$_data['short_code_header'])){
    switch (jssupportticket::$_data['short_code_header']){
        case 'downloads':
            $module = 'download';
            break;
        case 'userknowledgebase':
            $module = 'knowledgebase';
            break;
        case 'faqs':
            $module = 'faq';
            break;
        case 'announcements':
            $module = 'announcement';
            break;
        default:
            $module = 'ticket';
            break;
    }
}
$homeclass = ($module == 'jssupportticket') ? 'active' : '';
$ticketclass = ($module == 'ticket') ? 'active' : '';
$knowledgebaseclass = ($module == 'knowledgebase' && $layout != 'addcategory') ? 'active' : '';
$announcementsclass = ($module == 'announcement') ? 'active' : '';
$downloadsclass = ($module == 'download') ? 'active' : '';
$faqclass = ($module == 'faq') ? 'active' : '';
//Layout variy for Staff Member and User
if ($isUserStaff) {
    $linkname = 'staff';
    $myticket = 'staffmyticket';
    $addticket = 'staffaddticket';
    $announcements = 'staffannouncements';
    $downloads = 'staffdownloads';
    $adddownload = 'adddownload';
    $faqs = 'stafffaqs';
    $addfaq = 'addfaq';
    $addcategory = 'addcategory';
    $categories = 'stafflistarticles';
    $addarticle = 'addarticle';
    $articles = 'stafflistarticles';
    $addannouncement = 'addannouncement';
} else {
    $linkname = 'user';
    $myticket = 'myticket';
    $addticket = 'addticket';
    $categories = 'userknowledgebase';
    $announcements = 'announcements';
    $downloads = 'downloads';
    $faqs = 'faqs';
}
$flage = true;
if (jssupportticket::$_config['tplink_home_' . $linkname] == 1) {
    $linkarray[] = array(
        'class' => $homeclass,
        'link' => site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=jssupportticket&jstlay=controlpanel'),
        'title' => __('Home', 'js-support-ticket'),
        'jstmod' => ''
    );
    $flage = false;
}
if (jssupportticket::$_config['tplink_tickets_' . $linkname] == 1) {
    $linkarray[] = array(
        'class' => $ticketclass,
        'link' => site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=ticket&jstlay=' . $myticket),
        'title' => __('Tickets', 'js-support-ticket'),
        'jstmod' => 'ticket'
    );
    $flage = false;
}
if (jssupportticket::$_config['tplink_knowledgebase_' . $linkname] == 1) {
    $linkarray[] = array(
        'class' => $knowledgebaseclass,
        'link' => site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=knowledgebase&jstlay=' . $categories),
        'title' => __('Knowledge Base', 'js-support-ticket'),
        'jstmod' => 'knowledgebase'
    );
    $flage = false;
}
if (jssupportticket::$_config['tplink_announcements_' . $linkname] == 1) {
    $linkarray[] = array(
        'class' => $announcementsclass,
        'link' => site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=announcement&jstlay=' . $announcements),
        'title' => __('Announcements', 'js-support-ticket'),
        'jstmod' => 'announcement'
    );
    $flage = false;
}
if (jssupportticket::$_config['tplink_downloads_' . $linkname] == 1) {
    $linkarray[] = array(
        'class' => $downloadsclass,
        'link' => site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=download&jstlay=' . $downloads),
        'title' => __('Downloads', 'js-support-ticket'),
        'jstmod' => 'download'
    );
    $flage = false;
}
if (jssupportticket::$_config['tplink_faqs_' . $linkname] == 1) {
    $linkarray[] = array(
        'class' => $faqclass,
        'link' => site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=faq&jstlay=' . $faqs),
        'title' => __("FAQ's", 'js-support-ticket'),
        'jstmod' => 'faq'
    );
    $flage = false;
}
$extramargin = '';
$displayhidden = '';
if ($flage)
    $displayhidden = 'display:none;';
$div .= '
		<div id="jsst-header-main-wrapper" style="' . $displayhidden . '">';
$div .='<div id="jsst-header" class="' . $extramargin . '" >';
if (isset($linkarray))
    foreach ($linkarray AS $link) {
        $div .= '<span class="jsst-header-tab ' . $link['class'] . '"><a href="' . $link['link'] . '">' . $link['title'] . '</a></span>';
    }
    switch ($module) {
        case 'ticket':
            $layout = JSSTrequest::getVar('jstlay', null, $myticket);

            if (isset(jssupportticket::$_data['short_code_header']) && jssupportticket::$_data['short_code_header'] == 'myticket')
                $layout = $myticket;
            if (isset(jssupportticket::$_data['short_code_header']) && jssupportticket::$_data['short_code_header'] == 'addticket')
                $layout = $addticket;

            $addtic = ($layout == $addticket) ? 'active' : '';
            $listticket = ($layout == $myticket) ? 'active' : '';
            $ticketstatus = ($layout == 'ticketstatus') ? 'active' : '';
            $div .= '<div id="jsst-header-2">
                        <span class="jsst-header-2-tab ' . $addtic . '"><a href="' . site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=ticket&jstlay=' . $addticket) . '">' . __('Add Ticket', 'js-support-ticket') . '</a></span>
                        <span class="jsst-header-2-tab ' . $listticket . '"><a href="' . site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=ticket&jstlay=' . $myticket) . '">' . __('My Tickets', 'js-support-ticket') . '</a></span>';
            if (!$isUserStaff) {
                $div .= '<span class="jsst-header-2-tab ' . $ticketstatus . '"><a href="' . site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=ticket&jstlay=ticketstatus') . '">' . __('Check Ticket Status', 'js-support-ticket') . '</a></span>';
            }
            $div .= '</div>';
            break;
        case 'knowledgebase':
            if ($isUserStaff && $layout != 'addcategory') {
                $layout = JSSTrequest::getVar('jstlay', null, $categories);
                $addcat = ($layout == $addcategory) ? 'active' : '';
                $addkbarticle = ($layout == $addarticle) ? 'active' : '';
                $listarticle = ($layout == $articles) ? 'active' : '';
                $listcat = ($layout == $categories) ? 'active' : '';
                $div .= '<div id="jsst-header-2">
                        <span class="jsst-header-2-tab ' . $addkbarticle . '"><a href="' . site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=knowledgebase&jstlay=' . $addarticle) . '">' . __('Add Knowledge Base', 'js-support-ticket') . '</a></span>
                        <span class="jsst-header-2-tab ' . $listarticle . '"><a href="' . site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=knowledgebase&jstlay=' . $articles) . '">' . __('Knowledge Base', 'js-support-ticket') . '</a></span>
                    </div>';
            }
            break;
        case 'announcement':
            if ($isUserStaff) {
                $layout = JSSTrequest::getVar('jstlay', null, $announcements);
                $addclass = ($layout == $addannouncement) ? 'active' : '';
                $listannouncement = ($layout == $announcements) ? 'active' : '';
                $div .= '<div id="jsst-header-2">
                            <span class="jsst-header-2-tab ' . $addclass . '"><a href="' . site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=announcement&jstlay=' . $addannouncement) . '">' . __('Add Announcement', 'js-support-ticket') . '</a></span>
                            <span class="jsst-header-2-tab ' . $listannouncement . '"><a href="' . site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=announcement&jstlay=' . $announcements) . '">' . __('Announcements', 'js-support-ticket') . '</a></span>
                        </div>';
            }
            break;
        case 'download':
            if ($isUserStaff) {
                $layout = JSSTrequest::getVar('jstlay', null, $downloads);
                $addclass = ($layout == $adddownload) ? 'active' : '';
                $listdownload = ($layout == $downloads) ? 'active' : '';
                $div .= '<div id="jsst-header-2">
                            <span class="jsst-header-2-tab ' . $addclass . '"><a href="' . site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=download&jstlay=' . $adddownload) . '">' . __('Add Download', 'js-support-ticket') . '</a></span>
                            <span class="jsst-header-2-tab ' . $listdownload . '"><a href="' . site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=download&jstlay=' . $downloads) . '">' . __('Downloads', 'js-support-ticket') . '</a></span>
                        </div>';
            }
            break;
        case 'faq':
            if ($isUserStaff) {
                $layout = JSSTrequest::getVar('jstlay', null, $faqs);
                $addclass = ($layout == $addfaq) ? 'active' : '';
                $listfaqs = ($layout == $faqs) ? 'active' : '';
                $div .= '<div id="jsst-header-2">
                            <span class="jsst-header-2-tab ' . $addclass . '"><a href="' . site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=faq&jstlay=' . $addfaq) . '">' . __('Add FAQ', 'js-support-ticket') . '</a></span>
                            <span class="jsst-header-2-tab ' . $listfaqs . '"><a href="' . site_url('?page_id=' . jssupportticket::getPageId() . '&jstmod=faq&jstlay=' . $faqs) . '">' . __("FAQ's", 'js-support-ticket') . '</a></span>
                        </div>';
            }
            break;
    }
$div .= '</div></div>';
echo $div;
?>
