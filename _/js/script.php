(function ( $ , window , document , undefined) {
	$(document).ready(function(){
        <?php
            $action = isset($_GET['action']) ? $_GET['action'] : false;
            if(false === $action)die();
            switch($action)
            {
                case 'record':
                    echo "clickMap.init({url:'/wp-admin/admin-ajax.php',wordpress:true,method:'set_mapdata'});";
                    break;
                case 'click':
                    echo "clickMap.map_overlay('/wp-admin/admin-ajax.php','click',$(window).width());";
                    break;
                case 'move':
                    echo "clickMap.map_overlay('/wp-admin/admin-ajax.php','move',$(window).width());";
                    break;
                default;
            }
        ?>
    });
} ( jQuery , window, document));
<?php
include(getcwd().'/script.js');
?>