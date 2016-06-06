<?php
    /*
    Plugin Name: clickmap 
    Plugin URI:
    Description: 
    Version: 1.0.0.0
    Author: Geographics
    License: GPL2
    */
    
        $droplet_settings = get_option("droplet_settings");
        $droplet_settings["updates"]["clickmap"] = "http://repo.mygeographics.info/clickmap/update.json";
        $droplet_settings["ajax"]["clickmap"] = "/wp-content/plugins/clickmap/includes/droplet/ajax.php";
        update_option("droplet_settings",$droplet_settings);
        // include droplet bootstrap.
        require_once($_SERVER["DOCUMENT_ROOT"]."/wp-content/plugins/droplet/droplet.php");
        