<?php 

/*
Plugin Name: New Post Label
Plugin URI: https://github.com/bjorngustafsson/Wp-plugin-new-post-label/
Description: A WordPress plugin that labels new posts
Author: Bjorn Gustafsson
Version: 0.1
Author URI: http://bjorngustafsson.net/
*/


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

wp_register_script( 'my_plugin_script', plugins_url('/new-post-label.js', __FILE__), array('jquery'));
wp_enqueue_script( 'my_plugin_script' );

//Styles

wp_register_style( 'namespace', plugins_url('styles.css', __FILE__) );
wp_enqueue_style('namespace');  // wherever you want the css to load.

function label_new_posts( $title ) {


	$time_diff_today_to_post = time() - get_the_time('U');

	//get timediff in days
 	$days = date('d', $time_diff_today_to_post);

 	//convert for example 05 days to 5 days
 	$days_converted = intval($days);

 	//Add label to recent posts, 2678400 = 30 days
  if (in_the_loop() && is_home() && ((get_the_time('U') + 2678400) > time()) ) {
		$title = "<span title='Lades till " . $days_converted . 
		" dagar sedan.' class='new-post-label'>NYTT PROJEKT</span>" . $title;
  	}
  
	return $title;
	}

	add_filter( 'the_title', 'label_new_posts' );


?>