<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Report Sevi
Description: An example of a module
Version: 1.0
Author: Sevi
*/
define('Brainfood_campaigns_MODULE_NAME', 'Brainfood_campaigns');
define('Brainfood_campaigns_PATH', 'modules/Brainfood_campaigns/');

Brainfood_campaigns_module_activation_hook();

function Brainfood_campaigns_module_activation_hook() {
	$CI = &get_instance();
	require_once(__DIR__ . '/install.php');
}

hooks()->add_action('admin_init', 'Brainfood_campaigns_module_init_menu_items');

function Brainfood_campaigns_module_init_menu_items(){
    $CI = &get_instance();
    
    if (is_admin()) {
        $CI->app_menu->add_sidebar_menu_item('Brainfood_campaigns', [
        'slug' => 'Brainfood_campaigns',
        'name' => _l('Brainfood_campaigns'),
        'icon' => 'fa fa-video-camera',
        'href' => admin_url('brainfood_campaigns/reports/homeIndex'),
        'position' => 10, ]);
        }
        }