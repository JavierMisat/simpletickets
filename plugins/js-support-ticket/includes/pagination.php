<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTpagination {

    private static $_limit;
    private static $_offset;

    static function setLimit($limit){
        if(is_numeric($limit))
            self::$_limit = $limit;
    }

    static function getLimit(){
        return (int) self::$_limit;
    }

    static function setOffset($offset){
        if(is_numeric($offset))
            self::$_offset = $offset;
    }

    static function getOffset(){
        return (int) self::$_offset;
    }

    static function getPagination($total) {
        if(!is_numeric($total)) return false;
        $pagenum = isset($_GET['pagenum']) ? absint($_GET['pagenum']) : 1;
        self::setLimit(jssupportticket::$_config['pagination_default_page_size']); // number of rows in page
        $offset = ( $pagenum - 1 ) * self::$_limit;
        self::setOffset($offset);
        $num_of_pages = ceil($total / self::$_limit);
        $num_of_pages = ($num_of_pages > 0) ? ceil($num_of_pages) : floor($num_of_pages);
        $result = paginate_links(array(
            'base' => add_query_arg('pagenum', '%#%'),
            'format' => '',
            'prev_next' => true,
            'prev_text' => __('Previous', 'js-support-ticket'),
            'next_text' => __('Next', 'js-support-ticket'),
            'total' => $num_of_pages,
            'current' => $pagenum,
            'add_args' => false,
        ));
        return $result;
    }

    static function isLastOrdering($total, $pagenum) {
        if(!is_numeric($total)) return false;
        if(!is_numeric($pagenum)) return false;
        $maxrecord = $pagenum * jssupportticket::$_config['pagination_default_page_size'];
        if ($maxrecord >= $total)
            return false;
        else
            return true;
    }

}

?>