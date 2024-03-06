<?php
/**
 * Plugin Name: Primary Category Plugin
 * Description: Allows publishers to set a primary category for their posts.
 * Version: 1.0
 * Author: Jennifer Martinez
 * Author URI: https://github.com/lajennylove
 * License: MIT
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Include Composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Define the plugin's templates path
define( 'PLUGIN_TEMPLATES',     plugin_dir_path( __FILE__ ) . 'templates/' );
define( 'PLUGIN_PATH_ASSETS',   plugin_dir_path( __FILE__ ) . 'assets/' );
define( 'PLUGIN_ASSETS',        plugin_dir_url( __FILE__ )  . 'assets/' );

// Initialize the plugin
(new PrimaryCategoryPlugin\PrimaryCategory())->init();
