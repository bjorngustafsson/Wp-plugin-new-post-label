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

class BjornLabelNewPosts {

	public static function init() {
        $class = __CLASS__;
        new $class;
    }

	public function __construct() {

        //load textdomain in case want i18n
		load_plugin_textdomain( 'label-new-posts-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );

        //Have to use array with $this since in a class
        add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
        //above is like in oop:
        //$plugg = new BjornLabelNewPosts();
		//$plugg->register_plugin_styles();

        add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );

        //maybe avoid hook in constructor if want to do unit test later
        add_filter( 'the_title', array( $this, 'label_new_posts' ));

    }

    public function register_plugin_styles() {
 
    wp_register_style( 'label-new-posts-plugin', plugins_url( 'new-post-label/css/styles.css' ) );
    wp_enqueue_style( 'label-new-posts-plugin' );
	}

	public function register_plugin_scripts() {
 
    wp_register_script( 'label-new-posts-plugin', plugins_url( 'new-post-label/js/new-post-label.js' ) );
    wp_enqueue_script( 'label-new-posts-plugin' );
}

	public function label_new_posts( $title ) {

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

 }

add_action( 'plugins_loaded', array( 'BjornLabelNewPosts', 'init' ) );

?>