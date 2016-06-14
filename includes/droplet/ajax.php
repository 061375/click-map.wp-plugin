<?php
function set_mapdata_move()
{
    $data = dropletGeneral::post_variable('data',false);
    if(false !== $data) {
        return set_mapdata($data,1);
    }
}
function set_mapdata_click()
{
    $data = dropletGeneral::post_variable('data',false);
    if(false !== $data) {
        return set_mapdata($data,0); 
    }
}
function set_mapdata($data,$type)
{
    global $wpdb;
    if(false !== $data) {
        if(false !== $_SESSION['cm_screen_height'] AND false !== $_SESSION['cm_screen_width']) {
            $sql = "INSERT INTO `wp_click_map`
            (`width`,`height`,`type`,`data`)
            VALUES
            (
             '".esc_sql($_SESSION['cm_screen_width'])."',
             '".esc_sql($_SESSION['cm_screen_height'])."',
             '".esc_sql($type)."',
             '".esc_sql(str_replace('&quot;','"',stripslashes($data)))."'
            )";
            //echo '<pre>';print_r($sql );exit();/*REMOVE ME*/
            $wpdb->query($sql);
        }    
    }
    return true;
}
function set_mapdata_width()
{
    $data = dropletGeneral::post_variable('data',false);
     //echo '<pre>';print_r($data );exit();/*REMOVE ME*/
    if(false !== $data) {
        $data = str_replace('&quot;','"',stripslashes($data));
        $data =  json_decode($data);
        $_SESSION['cm_screen_width'] = isset($data->width) ? $data->width : false;
        $_SESSION['cm_screen_height'] = isset($data->height) ? $data->height : false;
    }
}
function get_mapdata()
{
    global $wpdb;
    $type = dropletGeneral::get_variable('type',false);
    if (false === $type) {
        dropletErrorHandler::set_error_message('type is required');
        return false;
    }
    $width = dropletGeneral::get_variable('width',false);
    if (false === $width) {
        dropletErrorHandler::set_error_message('width is required');
        return false;
    }
    if($type != 'click' AND $type != 'move') {
        dropletErrorHandler::set_error_message('unexpected value "action"');
        return false;
    }
    // create a blank image
    $image = imagecreatetruecolor(600, 600);
    
    // fill the background color
    $bg = imagecolorallocate($image, 0, 0, 0);
    imagecolortransparent($image, $bg);
    $col_ellipse = imagecolorallocate($image, 100, 255, 150);

    $type = ($type == 'click' ? 0 : 1);
    $sql = "SELECT `data` FROM `wp_click_map`
    WHERE `width` = '".esc_sql($width)."' AND `type` = '".esc_sql($type)."'";
   
    $results =  $wpdb->get_results($sql,ARRAY_A);
    $xy = array();
    foreach($results as $result) {
        $rs = json_decode('['.$result['data'].']');
        foreach($rs as $r) {
            if(isset($xy[$r->x])) {
                $xy[$r->x]+=1;
            }else{
                $xy[$r->x] = 1;
            }
            if(isset($xy[$r->y])) {
                $xy[$r->y]+=1;
            }else{
                $xy[$r->y] = 1;
            }
            imagefilledellipse($image, $r->x, $r->y, $xy[$r->x], $xy[$r->y], $col_ellipse);
        }       
    }
    header("Content-type: image/png");
    imagepng($image);
}