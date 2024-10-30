<?php

/*
   Plugin Name: Companies House Integrator
   Plugin URI: https://www.keybusinessconsultants.co.uk/
   description: Pull User data from Companies House directly into your website for quick user setups
   Version: 1.2
   Author: Inspire
   Author URI: http://www.inspiringitsolutions.co.uk/
   */
 
add_action('admin_menu', 'coho_admin_menu_companies');

function coho_admin_menu_companies(){
   
	add_menu_page( 
        __( 'Companies House Finder '),
        'Companies House Finder',
        'manage_options',
        'companieshousefinder',
        'coho_admin_companies_menu',
        plugins_url( 'img/icon.png', __FILE__  ),
        6
    ); 
	
	

}
 
require_once( ABSPATH . "wp-includes/pluggable.php" );
require_once(ABSPATH . '/wp-admin/includes/user.php');
include('adminapi.php');
include('addComUser.php');
include('adminMenu.php');


