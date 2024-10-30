<?php
/**
 * Plugin Name: Listings - Jobs
 * Description: Adds job board functionality to the Listings plugin.
 * Version: 0.2.2
 * Author: The Look and Feel
 * Text Domain: listings-jobs
 */

// Define constants
define( 'LISTINGS_JOBS_VERSION', '0.2.2' );
define( 'LISTINGS_JOBS_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'LISTINGS_JOBS_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
define( 'LISTINGS_JOBS_PLUGIN_FILE', __FILE__ );

/**
 * @return \Listings\Jobs\Plugin
 */
function listings_jobs() {
    static $instance;
    if ( is_null( $instance ) ) {
        $instance = new \Listings\Jobs\Plugin();
        $instance->hooks();
    }
    return $instance;
}

function __load_listings_jobs() {
    if( version_compare( PHP_VERSION, '5.3', '<' ) ) {
        include('helpers/php-fallback.php');
        $fallback = new Listings_PHP_Fallback( 'Listings Jobs' );
        $fallback->trigger_notice();
        return;
    }

    $GLOBALS['listings_jobs'] = listings_jobs();
}

// autoloader
require 'vendor/autoload.php';

register_activation_hook( basename( dirname( LISTINGS_JOBS_PLUGIN_FILE ) ) . '/' . basename( LISTINGS_JOBS_PLUGIN_FILE ), function() {
    \Listings\Jobs\Install::install();
});

// create plugin object
add_action( 'listings_init', '__load_listings_jobs', 10 );
