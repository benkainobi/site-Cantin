<?php
/**
 * @package ajout
 * @version 1
 */
/*
Plugin Name: ajout
Plugin URI: http://wordpress.org/plugins/ajout
Description: Ajout d'images
Author: Ben
Version: 1
Author URI: http://ma.tt/
*/
function ajout(){

    add_menu_page('Script Test', 'babobu', 'administrator', 'affichage.php', '', 'images/marker.png',3);
}

// Now we set that function up to execute when the admin_notices action is called.
add_action( 'admin_menu', 'ajout');


