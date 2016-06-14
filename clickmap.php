<?php
    /*
    Plugin Name: Desire Map 
    Plugin URI:
    Description: 
    Version: 1.0.0.0
    Author: Jeremy Heminger
    License: GPL2
    */
    
    $droplet_settings = get_option("droplet_settings");
    $droplet_settings["updates"]["clickmap"] = "http://repo.mygeographics.info/clickmap/update.json";
    $droplet_settings["ajax"]["clickmap"] = "/wp-content/plugins/clickmap/includes/droplet/ajax.php";
    update_option("droplet_settings",$droplet_settings);
    // include droplet bootstrap.
    require_once($_SERVER["DOCUMENT_ROOT"]."/wp-content/plugins/droplet/droplet.php");
    
    if ( !session_id() )session_start();
    
    global $wpdb;
    $sql = "CREATE TABLE IF NOT EXISTS `wp_click_map` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `width` int(4) NOT NULL,
            `height` int(4) NOT NULL,
            `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'click = 0;move = 1',
            `data` text NOT NULL,
            `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
             PRIMARY KEY (`id`),
             KEY `width` (`width`,`height`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $wpdb->query($sql);
    
    add_shortcode( 'record_desire_map', 'record_desire_map' );
    function record_desire_map()
    {
        wp_enqueue_style('desire_map',plugins_url('_/css/style.css',__FILE__));
        wp_enqueue_script('desire_map',plugins_url('_/js/script.php?action=record',__FILE__));
    }
    add_shortcode( 'display_desire_map', 'display_desire_map' );
    function display_desire_map( $atts )
    {
        wp_enqueue_style('desire_map',plugins_url('_/css/style.css',__FILE__));
        wp_enqueue_script('desire_map',plugins_url('_/js/script.php?action='.$atts['action'],__FILE__));
    }
    
