<?php

function ts_get_flickr($settings) {
	if (!function_exists('MagpieRSS')) {
	    // Check if another plugin is using RSS, may not work
	    include_once ABSPATH . WPINC . '/class-simplepie.php';
	    error_reporting(E_ERROR);
	}

	if(!isset($settings['items']) || empty($settings['items']))
	{
		$settings['items'] = 9;
	}

	// get the feeds
	if ($settings['type'] == "user") { $rss_url = 'http://api.flickr.com/services/feeds/photos_public.gne?id=' . $settings['id'] . '&per_page='.$settings['items'].'&format=rss_200'; }
	elseif ($settings['type'] == "favorite") { $rss_url = 'http://api.flickr.com/services/feeds/photos_faves.gne?id=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "set") { $rss_url = 'http://api.flickr.com/services/feeds/photoset.gne?set=' . $settings['set'] . '&nsid=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "group") { $rss_url = 'http://api.flickr.com/services/feeds/groups_pool.gne?id=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "public" || $settings['type'] == "community") { $rss_url = 'http://api.flickr.com/services/feeds/photos_public.gne?'. '&format=rss_200'; }
	else {
	    print '<strong>No "type" parameter has been setup. Check your settings, or provide the parameter as an argument.</strong>';
	    die();
	}
	# get rss file

	$feed = new SimplePie();
    $feed->set_feed_url($rss_url);
    $feed->set_cache_location(THEMESTUDIO_LIBRARIES . "/apis/cache");
    $feed->init();
	$photos_arr = array();

	foreach ($feed->get_items() as $key => $item)
	{
	    $enclosure = $item->get_enclosure();
	    $img = ts_image_from_description($item->get_description()); 
	    $thumb_url = ts_select_image($img, 0);
	    $large_url = ts_select_image($img, 4);

	    $photos_arr[] = array(
	    	'title' => $enclosure->get_title(),
	    	'thumb_url' => $thumb_url,
	    	'url' => $large_url,
	    );

	    $current = intval($key+1);

	    if($current == $settings['items'])
	    {
	    	break;
	    }
	}

	return $photos_arr;
}
function ts_image_from_description($data) {
    preg_match_all('/<img src="([^"]*)"([^>]*)>/i', $data, $matches);
    return $matches[1][0];
}

function ts_select_image($img, $size) {
    $img = explode('/', $img);
    $filename = array_pop($img);

    // The sizes listed here are the ones Flickr provides by default.  Pass the array index in the

    // 0 for square, 1 for thumb, 2 for small, etc.
    $s = array(
        '_s.', // square
        '_t.', // thumb
        '_m.', // small
        '.',   // medium
        '_b.'  // large
    );

    $img[] = preg_replace('/(_(s|t|m|b))?\./i', $s[$size], $filename);
    return implode('/', $img);
}