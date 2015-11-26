<?php

global $config;

if ($_SESSION['widescreen']) {
    if (!$graph_array['height']) {
        $graph_array['height'] = '110';
    }

    if (!$graph_array['width']) {
        $graph_array['width'] = '215';
    }

    $periods = array(
        'sixhour',
        'day',
        'week',
        'month',
        'year',
        'twoyear',
    );
}
else {
    if (!$graph_array['height']) {
        $graph_array['height'] = '100';
    }

    if (!$graph_array['width']) {
        $graph_array['width'] = '215';
    }

    $periods = array(
        'day',
        'week',
        'month',
        'year',
    );
}//end if

if($_SESSION['screen_width']) {
   if($_SESSION['screen_width'] > 800) {
	   $graph_array['width'] = round(($_SESSION['screen_width'] - 430 )/count($periods)+1,0);
   }
   else {
	$graph_array['width'] = $_SESSION['screen_width'] - 155;
   }
}

if( $graph_array['width'] < 215) {
    $graph_array['width'] = 215;
}

if($_SESSION['screen_height']) {
    if($_SESSION['screen_width'] > 960) {
        $graph_array['height'] = round(($_SESSION['screen_height'] - 250)/5,0);
    }
    else {
        $graph_array['height'] = round(($_SESSION['screen_height'] - 250)/2,0);
    }
}

if($graph_array['height'] < 100 ) {
    $graph_array['height'] = 100;
}

$graph_array['to'] = $config['time']['now'];

$graph_data = array();
foreach ($periods as $period) {
    $graph_array['from']        = $config['time'][$period];
    $graph_array_zoom           = $graph_array;
    $graph_array_zoom['height'] = '150';
    $graph_array_zoom['width']  = '400';

    $link_array         = $graph_array;
    $link_array['page'] = 'graphs';
    unset($link_array['height'], $link_array['width']);
    $link = generate_url($link_array);

    if ($return_data === true) {
        $graph_data[] = overlib_link($link, generate_lazy_graph_tag($graph_array), generate_graph_tag($graph_array_zoom),  NULL);
    }
    else {
        echo(overlib_link($link, generate_lazy_graph_tag($graph_array), generate_graph_tag($graph_array_zoom),  NULL));
    }
}
