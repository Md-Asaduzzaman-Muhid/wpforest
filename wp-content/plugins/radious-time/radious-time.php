<?php
/**
 * @package Radious_Time
 * @version 1.0.1
 */
/*
Plugin Name: Radious Time
Plugin URI: http://wordpress.org/plugins/Radious_Time/
Description: This is a demo plugin for radious theme
Author: Asaduzzaman Muhid
Version: 1.0.1
Author URI: http://Radious_Time.com/
*/
// if(!defined('ABSPATH')){
//     die;
// }
// defined('ABSPATH') or die('you can\t access it');

if(! function_exists('add_action')){
    echo "you can\t access it";
    exit;
}
class TimeCalculate{
    function __construct(int $time){
        echo "Number is: ".$time;
    }
    function activate(){
        $this->custom_post_type();
        flush_rewrite_rules();
    }
    function deactivate(){
        flush_rewrite_rules();
    }
    function custom_post_type(){
        register_post_type('time',['public'=>true, 'label'=> 'Times']);
    }
}

$timeCal = new TimeCalculate(10);
register_activation_hook(__FILE__,array($timeCal,'activate'));